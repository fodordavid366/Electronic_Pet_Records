<?php
require_once __DIR__ . '/../core/init.php';


// Read JSON input data
$data = json_decode(file_get_contents('php://input'), true);
// Check if all required fields are set
if (
    !isset($data['token'])
) {
    sendJSON(['message' => 'Hiányzik a token.'], 400);
}

$token = trim($data['token']);

try {
    // Check if the token exists and is not expired
    $stmt = $pdo->prepare("SELECT * FROM owner WHERE registration_token = ? AND registration_token_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        // Token is invalid or expired
        sendJSON(['message' => 'Az aktivációs token érvénytelen vagy lejárt. (bejelentkezéskor kérhet másikat ha szükséges)'], 400);
    }

    // Activate the user account
    $updateStmt = $pdo->prepare("UPDATE owner SET verified = 1, registration_token = NULL, registration_token_expires = NULL WHERE owner_id = ?");
    $updateStmt->execute([$user['owner_id']]);

    // Successful activation
    sendJSON(['message' => 'Fiók aktiválva! Most már <a href="../public/index.php">bejelentkezhet.</a>'], 200);
} catch (Exception $e) {
    error_log('Hiba az aktiválás során: ' . $e->getMessage());
    // Internal server error
    sendJSON(['message' => 'Belső szerverhiba. Kérjük, próbálja meg később.'], 500);
}
?>