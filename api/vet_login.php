<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../classes/Vet.php';
require_once __DIR__ . '/../classes/VetRepository.php';
require_once __DIR__ . '/../includes/dokiAuth.php'; // issueToken függvény
require_once __DIR__ . '/../core/init.php';

use App\VetRepository;

ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');


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

    // JWT cookie-ba
    setcookie(
        'auth_token',        // name
        $token,              // value
        [
            'expires' => time() + 7200, // 2 óra
            'path' => '/',
            'secure' => false,          // HTTPS esetén true
            'httponly' => true,
            'samesite' => 'Lax'
        ]
    );

    echo json_encode(['success' => true]);
} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Hibás bejelentkezés']);
}
