<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../classes/Vet.php';
require_once __DIR__ . '/../classes/VetRepository.php';
require_once __DIR__ . '/../includes/auth.php'; // JWT issueToken függvény
require_once __DIR__ . '/../core/init.php';

use App\VetRepository;

$pdo = new PDO("mysql:host=localhost;dbname=hk_e_ny", "root", "");
$vetRepo = new VetRepository($pdo);

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM vet WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $token = issueToken($user['vet_id'], 'vet');
    echo json_encode(['success' => true, 'token' => $token],200);
} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Hibás bejelentkezés'],401);
}
