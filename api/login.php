<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';

// Mindig JSON válasz
header('Content-Type: application/json; charset=utf-8');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['email'], $data['password'])) {
        sendJSON(['message' => 'E-mail és jelszó kötelező'], 400);
    }

    $email = trim($data['email']);
    $password = $data['password'];

    if (strlen($email) > 60) {
        sendJSON(['message' => 'Érvénytelen e-mail cím'], 400);
    }
    if (strlen($password) < 6) {
        sendJSON(['message' => 'A jelszó túl rövid'], 400);
    }

    $stmt = $pdo->prepare("SELECT * FROM owner WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        sendJSON(['message' => 'Hibás bejelentkezési adatok'], 401);
    }

    if ((int)$user['verified'] === 0) {
        sendJSON(['message' => 'A fiók nincs aktiválva'], 403);
    }

    if ((int)$user['is_banned'] === 1) {
        sendJSON(['message' => 'A fiókot letiltották'], 403);
    }

    // JWT kiadása
    $token = issueToken($user['owner_id'], 'owner');

    sendJSON([
        'message' => 'Sikeres bejelentkezés',
        'token'   => $token
    ], 200);

} catch (PDOException $e) {
    error_log("DB error: " . $e->getMessage());
    sendJSON(['message' => 'Adatbázis hiba'], 500);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    sendJSON(['message' => 'Váratlan hiba'], 500);
}
