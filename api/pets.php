<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/Pet.php';
require_once __DIR__ . '/../classes/PetRepository.php';

use App\Pet;
use App\PetRepository;

$user = authMiddleware();
if (!$user) {
    sendJSON(['message' => 'Nincs jogosultság!'], 401);
}

$repo = new PetRepository($pdo);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pet = $repo->find((int)$id);
            if (!$pet || !canAccess($user, $pet)) {
                sendJSON(['message' => 'A keresett házikedvenc nem található.'], 404);
            }
            sendJSON($pet->toArray());
        } else {
            $pets = match ($user['role']) {
                'admin' => $repo->findAll(),
                'owner' => $repo->findByOwner($user['sub']),
                'vet'   => $repo->findByVet($user['sub']),
            };
            sendJSON(array_map(fn($p) => $p->toArray(), $pets));
        }
        break;

    case 'POST':
        if ($user['role'] !== 'owner' && $user['role'] !== 'admin') {
            sendJSON(['message' => 'Nincs jogosultság új házikedvenc létrehozásához.'], 403);
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $pet  = new Pet($data);
        $newId = $repo->create($pet, $user['sub']);

        if (!is_int($newId)) {
            sendJSON(['message' => $newId], 409);
        }

        sendJSON(['message' => 'Házikedvenc sikeresen hozzáadva.', 'pet_id' => $newId], 201);
        break;

    case 'PUT':
        $put = json_decode(file_get_contents('php://input'), true);
        if (empty($put['pet_id'])) {
            sendJSON(['message' => 'Hiányzik az azonosító.'], 400);
        }

        $existing = $repo->find((int)$put['pet_id']);
        if (!$existing || !canAccess($user, $existing)) {
            sendJSON(['message' => 'Nincs jogosultság a szerkesztéshez.'], 403);
        }

        $updated = new Pet(array_merge($existing->toArray(), $put, ['pet_id' => $existing->id]));
        $repo->update($updated);
        sendJSON(['message' => 'Házikedvenc sikeresen frissítve.']);
        break;

    case 'DELETE':
        parse_str(file_get_contents('php://input'), $del);
        if (empty($del['id'])) sendJSON(['message' => 'Hiányzik az azonosító.'], 400);

        $existing = $repo->find((int)$del['id']);
        if (!$existing || !canAccess($user, $existing)) {
            sendJSON(['message' => 'Nincs jogosultság a törléshez.'], 403);
        }
        $repo->delete($existing->id);
        sendJSON(['message' => 'Házikedvenc sikeresen törölve.']);
        break;

    default:
        sendJSON(['message' => 'A HTTP metódus nem támogatott.'], 405);
}

/* Jogosultságellenőrzés */
function canAccess(array $user, Pet $pet): bool
{
    return match ($user['role']) {
        'admin' => true,
        'owner' => $user['sub'] === $pet->ownerId,
        'vet'   => $user['sub'] === $pet->vetId,
        default => false
    };
}
