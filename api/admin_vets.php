<?php

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../includes/db.php'; // your PDO $pdo
require_once __DIR__ . '/../classes/Vet.php';
require_once __DIR__ . '/../classes/VetRepository.php';

$pdo = new PDO("mysql:host=localhost;dbname=hk_e_ny", "root", "");
use App\Vet;
use App\VetRepository;

$repo = new VetRepository($pdo);

// Read JSON body
$input = json_decode(file_get_contents('php://input'), true) ?? [];

// GET: list all vets
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $vets = $repo->findAll();
    $data = array_map(fn($v) => $v->toArray(), $vets);
    echo json_encode(['success' => true, 'vets' => $data]);
    exit;
}

// POST: add new vet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vet = new Vet($input);

    // All fields required for creation
    if (!$vet->firstName || !$vet->lastName || !$vet->email || !$vet->phoneNumber || !$vet->birthDate || !$vet->specialization || !$vet->password) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    $id = $repo->create($vet);
    echo json_encode(['success' => true, 'id' => $id]);
    exit;
}

// PUT: update vet
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (!isset($input['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing vet ID']);
        exit;
    }

    $vet = $repo->find((int)$input['id']);
    if (!$vet) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Vet not found']);
        exit;
    }

    // Update fields
    $vet->firstName = $input['first_name'] ?? $vet->firstName;
    $vet->lastName = $input['last_name'] ?? $vet->lastName;
    $vet->email = $input['email'] ?? $vet->email;
    $vet->phoneNumber = $input['phone_number'] ?? $vet->phoneNumber;
    $vet->birthDate = $input['birth_date'] ?? $vet->birthDate;
    $vet->specialization = $input['specialization'] ?? $vet->specialization;

    // Only update password if provided
    if (!empty($input['password'])) {
        $vet->password = $input['password'];
    }

    $repo->update($vet);
    echo json_encode(['success' => true]);
    exit;
}

// DELETE: remove vet
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (!isset($input['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Missing vet ID']);
        exit;
    }

    $repo->delete((int)$input['id']);
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);
