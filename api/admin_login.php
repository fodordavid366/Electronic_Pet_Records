<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$pdo = new PDO("mysql:host=localhost;dbname=hk_e_ny", "root", "");

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM admin WHERE email=?");
$stmt->execute([$email]);
$admin = $stmt->fetch();

if (!$admin || !password_verify($password, $admin['password'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Hibás felhasználónév vagy jelszó']);
    exit;
}

$payload = [
    'admin_id' => $admin['admin_id'],
    'email' => $admin['email'],
    'exp' => time() + 3600
];

$jwt = JWT::encode($payload, 'titkos_kulcs', 'HS256');
echo json_encode(['token' => $jwt]);
