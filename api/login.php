<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';

// Parse JSON input
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['email'], $data['password'])) {
    sendJSON(['message' => 'E‑mail és jelszó kötelező'], 400);
}

$email = trim($data['email']);
$password = $data['password'];

// Check user
$stmt = $pdo->prepare("SELECT * FROM owner WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();
if (!$user || !password_verify($password, $user['password'])) {
    sendJSON(['message' => 'Hibás bejelentkezési adatok'], 401);
}
if ($user['verified']===0) {
    sendJSON(['message' => 'A fiók nincs aktiválva'], 401);
}
if ($user['is_banned']===1) {
    sendJSON(['message' => 'A fiókot letiltották'], 401);
}

// Issue JWT
$token = issueToken($user['owner_id'], 'owner');

sendJSON([
    'message' => 'Sikeres bejelentkezés',
    'token'   => $token
], 200);
