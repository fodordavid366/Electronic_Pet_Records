<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$user = authMiddleware();
if (!$user) {
    sendJSON(['message' => 'Nincs jogosultság!'], 401);
}

// Allow only 'owner' or 'vet' roles to change password
if (!in_array($user['role'], ['owner', 'vet'])) {
    sendJSON(['message' => 'Nem engedélyezett szerepkör.'], 403);
}

// Read input JSON
$data = json_decode(file_get_contents('php://input'), true);

if (
    !isset($data['old_password']) ||
    !isset($data['new_password']) ||
    !isset($data['new_password_verify'])
) {
    sendJSON(['message' => 'Minden mező kitöltése kötelező!'], 400);
}

$old = $data['old_password'];
$new = $data['new_password'];
$new_v = $data['new_password_verify'];

// Check if new passwords match
if ($new !== $new_v) {
    sendJSON(['message' => 'Az új jelszavak nem egyeznek!'], 400);
}

// Validate new password strength
if (!validatePassword($new)) {
    sendJSON(['message' => 'Az új jelszó nem elég erős (min. 8 karakter, kis‑ és nagybetű, szám, speciális karakter).'], 400);
}

// Determine the table based on user role
$table = $user['role'] === 'owner' ? 'owner' : 'vet';

// Fetch current hashed password
$stmt = $pdo->prepare("SELECT password FROM $table WHERE {$table}_id = ?");
$stmt->execute([$user['sub']]);
$row = $stmt->fetch();

// Check old password match
if (!$row || !password_verify($old, $row['password'])) {
    sendJSON(['message' => 'Hibás jelenlegi jelszó.'], 403);
}

// Hash and update new password
$newHash = password_hash($new, PASSWORD_BCRYPT);
$update = $pdo->prepare("UPDATE $table SET password = ? WHERE {$table}_id = ?");
$update->execute([$newHash, $user['sub']]);

sendJSON(['message' => 'A jelszó sikeresen megváltoztatva.']);
