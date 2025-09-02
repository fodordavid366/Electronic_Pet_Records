<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/dokiAuth.php';

// mindig JSON legyen a válasz
header('Content-Type: application/json; charset=utf-8');

$user = checkDokiAuth();
if (!$user) {
    http_response_code(401);
    echo json_encode(['message' => 'Nincs jogosultság']);
    exit;
}

// bejövő adatok
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

$appointmentId = (int)($data['appointment_id'] ?? 0);
$description   = trim($data['description'] ?? '');

if (!$appointmentId) {
    sendJSON(['message' => 'Hiányzó appointment_id'], 400);
}

try {
    $stmt = $pdo->prepare("UPDATE appointment SET description = ? WHERE appointment_id = ?");
    $stmt->execute([$description, $appointmentId]);
    sendJSON(['message' => 'Megjegyzés frissítve'], 200);
} catch (PDOException $e) {
    error_log("DB error update_appointment_description: " . $e->getMessage());
    sendJSON(['message' => 'Adatbázis hiba'], 500);
}
