<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';

$user = authMiddleware();
if (!$user) {
    sendJSON(['message' => 'Nincs jogosultság'], 401);
}

$petId = (int)($_GET['pet_id'] ?? 0);
if (!$petId) {
    sendJSON(['message' => 'Hiányzó pet_id'], 400);
}

// Lekérdezzük az állatot és a tulajdonos adatait
$stmt = $pdo->prepare("
    SELECT p.*, 
           o.first_name AS owner_first, o.last_name AS owner_last, o.email AS owner_email, o.birth_date AS owner_birth, o.phone_number AS owner_phone
    FROM pet p
    JOIN owner_pet op ON p.pet_id = op.pet_id
    JOIN owner o ON op.owner_id = o.owner_id
    WHERE p.pet_id = ?
");
$stmt->execute([$petId]);
$pet = $stmt->fetch();
if (!$pet) {
    sendJSON(['message' => 'Állat nem található'], 404);
}

sendJSON($pet);
