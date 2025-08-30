<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../classes/Pet.php';
require_once __DIR__ . '/../classes/PetRepository.php';

use App\Pet;
use App\PetRepository;

$user = authMiddleware();
if (!$user) {
    sendJSON(['message' => 'Unauthorized'], 401);
}

$repo = new PetRepository($pdo);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /* GET: list or single */
    case 'GET':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pet = $repo->find((int)$id);
            if (!$pet || !canAccess($user, $pet)) {
                sendJSON(['message' => 'Not found'], 404);
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

    /* POST: create */
    case 'POST':
        if ($user['role'] !== 'owner' && $user['role'] !== 'admin') {
            sendJSON(['message' => 'Forbidden'], 403);
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $pet  = new Pet($data);
        $newId = $repo->create($pet,$user['sub']);
        if(!is_int($newId))
        {
            sendJSON(['message' => $newId], 201);
            break;
        }

        if ($user['role'] === 'owner') {
            $link = $pdo->prepare("INSERT INTO owner_pet (owner_id, pet_id) VALUES (?, ?)");
            $link->execute([$user['sub'], $newId]);
        }
        sendJSON(['pet_id' => $newId], 201);
        break;

    /* PUT: update */
    case 'PUT':
        $put = json_decode(file_get_contents('php://input'), true);
        if (empty($put['id'])) {
            sendJSON(['message' => 'Missing id'], 400);
        }

        $existing = $repo->find((int)$put['id']);
        if (!$existing || !canAccess($user, $existing)) {
            sendJSON(['message' => 'Forbidden'], 403);
        }

        $updated = new Pet(array_merge($existing->toArray(), $put, ['id' => $existing->id]));
        $repo->update($updated);
        sendJSON(['message' => 'Updated']);
        break;

    /* DELETE */
    case 'DELETE':
        parse_str(file_get_contents('php://input'), $del);
        if (empty($del['id'])) sendJSON(['message' => 'Missing id'], 400);

        $existing = $repo->find((int)$del['id']);
        if (!$existing || !canAccess($user, $existing)) {
            sendJSON(['message' => 'Forbidden'], 403);
        }
        $repo->delete($existing->id);
        sendJSON(['message' => 'Deleted']);
        break;

    default:
        sendJSON(['message' => 'Method not allowed'], 405);
}

/* Helper: role‑based access to a pet */
function canAccess(array $user, Pet $pet): bool
{
    return match ($user['role']) {
        'admin' => true,
        'owner' => $user['sub'] === $pet->ownerId,
        'vet'   => $user['sub'] === $pet->vetId,
        default => false
    };
}
