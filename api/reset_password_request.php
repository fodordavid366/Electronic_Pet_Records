<?php

require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$token = $data['token'] ?? '';
$new = $data['new_password'] ?? '';
$new_v = $data['new_password_verify'] ?? '';

if (!$token || !$new || !$new_v) {
    echo json_encode(['success' => false, 'message' => 'Minden mező kitöltése kötelező!']);
    exit;
}

if ($new !== $new_v) {
    echo json_encode(['success' => false, 'message' => 'Az új jelszavak nem egyeznek!']);
    exit;
}

// Jelszó erősség ellenőrzés
if (!validatePassword($new)) {
    echo json_encode(['success' => false, 'message' => 'Az új jelszó nem elég erős!']);
    exit;
}

// Ellenőrizzük a token-t az owner táblában
$stmt = $pdo->prepare("SELECT owner_id, forgotten_password_token_expires FROM owner WHERE forgotten_password_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Érvénytelen token!']);
    exit;
}

if (strtotime($user['forgotten_password_token_expires']) < time()) {
    echo json_encode(['success' => false, 'message' => 'A token lejárt, kérj újat!']);
    exit;
}

// Hash-eljük az új jelszót
$hash = password_hash($new, PASSWORD_BCRYPT);

// Frissítjük az adatbázist és töröljük a tokent
$update = $pdo->prepare("UPDATE owner SET password = ?, forgotten_password_token = NULL, forgotten_password_token_expires = NULL WHERE owner_id = ?");
$update->execute([$hash, $user['owner_id']]);

echo json_encode(['success' => true, 'message' => 'A jelszó sikeresen módosítva.']);
exit;
