<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../classes/Vet.php';
require_once __DIR__ . '/../classes/VetRepository.php';
require_once __DIR__ . '/authorize_admin.php'; // csak ha kell admin

use App\Vet;
use App\VetRepository;

$pdo = new PDO("mysql:host=localhost;dbname=hk_e_ny", "root", "");
$vetRepo = new VetRepository($pdo);

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

header('Content-Type: application/json');

switch ($method) {

    case 'GET':
        if ($id) {
            $vet = $vetRepo->find((int)$id);
            echo json_encode($vet ? $vet->toArray(false) : ['message' => 'Orvos nem található']);
            // false: ne adjuk vissza a jelszót
        } else {
            $vets = array_map(fn($v) => $v->toArray(false), $vetRepo->findAll());
            echo json_encode($vets);
        }
        break;

    case 'POST':
    case 'PUT':
    case 'DELETE':
        // Ezekhez kell admin
        $admin = authorizeAdmin();

        if ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $vet = new Vet($data);
            if (!$vet->password) {
                http_response_code(400);
                echo json_encode(['message' => 'A jelszó kötelező az új orvoshoz']);
                exit;
            }
            $id = $vetRepo->create($vet);
            echo json_encode(['message' => 'Orvos létrehozva', 'id' => $id]);
        }

        if ($method === 'PUT') {
            if (!$id) {
                http_response_code(400);
                echo json_encode(['message' => 'Hiányzik az orvos azonosítója']);
                exit;
            }
            $data = json_decode(file_get_contents("php://input"), true);
            $vet = new Vet(array_merge($data, ['vet_id' => $id]));
            $vetRepo->update($vet);
            echo json_encode(['message' => 'Orvos frissítve']);
        }

        if ($method === 'DELETE') {
            if (!$id) {
                http_response_code(400);
                echo json_encode(['message' => 'Hiányzik az orvos azonosítója']);
                exit;
            }
            $vetRepo->delete((int)$id);
            echo json_encode(['message' => 'Orvos törölve']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Nem támogatott HTTP metódus']);
}
