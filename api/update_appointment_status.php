<?php

require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/mailer.php';

header('Content-Type: application/json; charset=utf-8');

$user = authMiddleware();
if (!$user) {
    sendJSON(['message' => 'Nincs jogosultság'], 401);
}

if ($user['role'] !== 'vet') {
    sendJSON(['message' => 'Nincs jogosultság'], 403);
}

$data = json_decode(file_get_contents('php://input'), true);
$appointmentId = (int)($data['appointment_id'] ?? 0);
$status = $data['status'] ?? '';
$cancelMessage = trim($data['cancel_message'] ?? '');

if (!$appointmentId || !in_array($status, ['booked', 'completed', 'canceled'])) {
    sendJSON(['message' => 'Hiányzó vagy érvénytelen adatok'], 400);
}

try {
    $stmt = $pdo->prepare("UPDATE appointment SET status = ? WHERE appointment_id = ?");
    $stmt->execute([$status, $appointmentId]);

    if ($status === 'canceled' && $cancelMessage) {
        $stmt = $pdo->prepare("
            SELECT o.email, o.first_name, o.last_name, p.name AS pet_name, a.starts_at
            FROM appointment a
            JOIN pet p ON a.pet_id = p.pet_id
            JOIN owner_pet op ON p.pet_id = op.pet_id
            JOIN owner o ON op.owner_id = o.owner_id
            WHERE a.appointment_id = ?
        ");
        $stmt->execute([$appointmentId]);
        $owner = $stmt->fetch();

        if ($owner) {
            $to = $owner['email'];
            $subject = "Foglalás törölve: " . $owner['pet_name'];
            $body = "Kedves {$owner['first_name']} {$owner['last_name']},<br>"
                . "A következő foglalása törlésre került: {$owner['pet_name']} {$owner['starts_at']}<br><br>"
                . "Üzenet az orvostól:<br>$cancelMessage<br><br>Kérjük vegye figyelembe.";
            sendMail($to, $subject, $body); // implementáld a sendMail függvényt a meglévő rendszered szerint
        }
    }

    sendJSON(['message' => 'Státusz frissítve'], 200);
} catch (PDOException $e) {
    error_log("DB error update_appointment_status: " . $e->getMessage());
    sendJSON(['message' => 'Adatbázis hiba'], 500);
}
