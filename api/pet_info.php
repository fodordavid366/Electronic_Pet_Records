<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';

$user = authMiddleware();
if (!$user) {
    sendJSON(['message' => 'Nincs jogosultság'], 401);
}

// appointment_id a GET paraméterből
$appointmentId = (int)($_GET['appointment_id'] ?? 0);
if (!$appointmentId) {
    sendJSON(['message' => 'Hiányzó időpont azonosító'], 400);
}

// Lekérdezzük az appointment-et, és azon keresztül a pet-et és a tulajdonos adatait
$stmt = $pdo->prepare("
    SELECT a.appointment_id,
           p.*,
           o.first_name AS owner_first, 
           o.last_name AS owner_last, 
           o.email AS owner_email, 
           o.birth_date AS owner_birth, 
           o.phone_number AS owner_phone,
           a.description,
           a.status
    FROM appointment a
    JOIN pet p ON a.pet_id = p.pet_id
    JOIN owner_pet op ON p.pet_id = op.pet_id
    JOIN owner o ON op.owner_id = o.owner_id
    WHERE a.appointment_id = ?
");
$stmt->execute([$appointmentId]);
$data = $stmt->fetch();

if (!$data) {
    sendJSON(['message' => 'Időpont vagy állat nem található'], 404);
}

sendJSON($data);
