<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';

$user = authMiddleware();
if (!$user) {
    sendJSON(['message' => 'Nincs jogosultság'], 401);
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /* -------------------------------
       GET: fetch appointments or slots
    -------------------------------- */
    case 'GET':
        // If user asks for available slots
        if ($_GET['action'] ?? '' === 'slots') {
            $vetId = (int)($_GET['vet_id'] ?? 0);
            $date  = $_GET['date'] ?? '';
            $treatmentId = (int)($_GET['treatment_id'] ?? 0);

            if (!$vetId || !$date || !$treatmentId) {
                sendJSON(['message' => 'Hiányzó paraméterek'], 400);
            }

            // Load treatment duration
            $stmt = $pdo->prepare("SELECT duration_min FROM treatment WHERE treatment_id = ?");
            $stmt->execute([$treatmentId]);
            $treatment = $stmt->fetch();
            if (!$treatment) {
                sendJSON(['message' => 'Érvénytelen kezelés'], 404);
            }
            $duration = (int)$treatment['duration_min'];

            // Weekday (0 = Sunday, 1 = Monday...)
            $weekday = date('w', strtotime($date));

            // Load vet schedule
            $stmt = $pdo->prepare("SELECT * FROM vet_schedule WHERE vet_id = ? AND weekday = ?");
            $stmt->execute([$vetId, $weekday]);
            $schedule = $stmt->fetch();
            if (!$schedule) {
                sendJSON(['message' => 'Ezen a napon nincs rendelés'], 404);
            }

            $slotMinutes = (int)$schedule['slot_minutes'];
            $startTime = new DateTime($date . ' ' . $schedule['start_time']);
            $endTime   = new DateTime($date . ' ' . $schedule['end_time']);

            // Load already booked appointments
            $stmt = $pdo->prepare("SELECT starts_at, ends_at FROM appointment 
                                   WHERE vet_id = ? AND DATE(starts_at) = ? AND status = 'booked'");
            $stmt->execute([$vetId, $date]);
            $booked = $stmt->fetchAll();

            $bookedIntervals = array_map(fn($row) => [
                new DateTime($row['starts_at']),
                new DateTime($row['ends_at'])
            ], $booked);

            // Generate available slots
            $available = [];
            $current = clone $startTime;
            while ($current <= $endTime) {
                $slotEnd = (clone $current)->modify("+{$duration} minutes");

                if ($slotEnd > $endTime) break;

                // Check overlap with booked intervals
                $conflict = false;
                foreach ($bookedIntervals as [$bStart, $bEnd]) {
                    if ($current < $bEnd && $slotEnd > $bStart) {
                        $conflict = true;
                        break;
                    }
                }

                if (!$conflict) {
                    $available[] = $current->format('H:i');
                }

                $current->modify("+{$slotMinutes} minutes");
            }

            sendJSON(['available_slots' => $available]);
        }

        // Otherwise: list appointments
        if ($user['role'] === 'admin') {
            $stmt = $pdo->query("SELECT * FROM appointment");
            $appointments = $stmt->fetchAll();
        } elseif ($user['role'] === 'vet') {
            $stmt = $pdo->prepare("SELECT * FROM appointment WHERE vet_id = ?");
            $stmt->execute([$user['sub']]);
            $appointments = $stmt->fetchAll();
        } else { // owner
            $stmt = $pdo->prepare("SELECT a.appointment_id, a.pet_id, a.vet_id, a.description, a.starts_at, a.ends_at, a.treatment_id, a.status,
       p.name AS pet_name,
       CONCAT(v.first_name, ' ', v.last_name) AS vet_name,
       t.name AS treatment_name
FROM appointment a
JOIN pet p ON a.pet_id = p.pet_id
JOIN vet v ON a.vet_id = v.vet_id
JOIN treatment t ON a.treatment_id = t.treatment_id
JOIN owner_pet op ON p.pet_id = op.pet_id
WHERE op.owner_id = ?
");
            $stmt->execute([$user['sub']]);
            $appointments = $stmt->fetchAll();
        }

        sendJSON($appointments);
        break;

    /* -------------------------------
       POST: create new appointment
    -------------------------------- */
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        $petId       = (int)($data['pet_id'] ?? 0);
        $vetId       = (int)($data['vet_id'] ?? 0);
        $treatmentId = (int)($data['treatment_id'] ?? 0);
        $startsAt    = $data['starts_at'] ?? '';
        $description = $data['description'] ?? '';

        if (!$petId || !$vetId || !$treatmentId || !$startsAt) {
            sendJSON(['message' => 'Hiányzó mezők'], 400);
        }

        // Owner can only create appointments for his own pets
        if ($user['role'] === 'owner') {
            $stmt = $pdo->prepare("SELECT 1 FROM owner_pet WHERE owner_id = ? AND pet_id = ?");
            $stmt->execute([$user['sub'], $petId]);
            if (!$stmt->fetch()) {
                sendJSON(['message' => 'Ez a kisállat nem a tiéd'], 403);
            }
        }

        // Load treatment duration
        $stmt = $pdo->prepare("SELECT duration_min FROM treatment WHERE treatment_id = ?");
        $stmt->execute([$treatmentId]);
        $treatment = $stmt->fetch();
        if (!$treatment) {
            sendJSON(['message' => 'Érvénytelen kezelés'], 404);
        }
        $duration = (int)$treatment['duration_min'];

        $startDt = new DateTime($startsAt);
        $endDt   = (clone $startDt)->modify("+{$duration} minutes");

        // Check conflicts
        $stmt = $pdo->prepare("SELECT 1 FROM appointment WHERE vet_id = ? AND status='booked'
                               AND ((starts_at < ? AND ends_at > ?) OR (starts_at < ? AND ends_at > ?))");
        $stmt->execute([$vetId, $endDt->format('Y-m-d H:i:s'), $startDt->format('Y-m-d H:i:s'),
            $endDt->format('Y-m-d H:i:s'), $startDt->format('Y-m-d H:i:s')]);
        if ($stmt->fetch()) {
            sendJSON(['message' => 'Időpont ütközés'], 409);
        }

        // Insert
        $stmt = $pdo->prepare("INSERT INTO appointment (pet_id, vet_id, description, starts_at, ends_at, treatment_id, status)
                               VALUES (?, ?, ?, ?, ?, ?, 'booked')");
        $stmt->execute([$petId, $vetId, $description, $startDt->format('Y-m-d H:i:s'), $endDt->format('Y-m-d H:i:s'), $treatmentId]);

        sendJSON(['message' => 'Időpont lefoglalva', 'appointment_id' => $pdo->lastInsertId()], 201);
        break;

    /* -------------------------------
       PATCH: update appointment
    -------------------------------- */
    case 'PATCH':
        parse_str(file_get_contents("php://input"), $data);

        $appointmentId = (int)($data['appointment_id'] ?? 0);
        $status        = $data['status'] ?? '';
        $description   = $data['description'] ?? '';

        if (!$appointmentId) {
            sendJSON(['message' => 'Hiányzó appointment_id'], 400);
        }

        // Load appointment
        $stmt = $pdo->prepare("SELECT * FROM appointment WHERE appointment_id = ?");
        $stmt->execute([$appointmentId]);
        $appointment = $stmt->fetch();
        if (!$appointment) {
            sendJSON(['message' => 'Időpont nem található'], 404);
        }

        // Permission checks
        if ($user['role'] === 'owner') {
            $stmt = $pdo->prepare("SELECT 1 FROM owner_pet WHERE owner_id = ? AND pet_id = ?");
            $stmt->execute([$user['sub'], $appointment['pet_id']]);
            if (!$stmt->fetch()) {
                sendJSON(['message' => 'Nincs jogosultság ehhez az időponthoz'], 403);
            }
        } elseif ($user['role'] === 'vet' && $appointment['vet_id'] != $user['sub']) {
            sendJSON(['message' => 'Ez az időpont nem hozzád tartozik'], 403);
        }

        // Update allowed fields
        if ($status) {
            $stmt = $pdo->prepare("UPDATE appointment SET status = ? WHERE appointment_id = ?");
            $stmt->execute([$status, $appointmentId]);
        }
        if ($description) {
            $stmt = $pdo->prepare("UPDATE appointment SET description = ? WHERE appointment_id = ?");
            $stmt->execute([$description, $appointmentId]);
        }

        sendJSON(['message' => 'Időpont frissítve']);
        break;

    /* -------------------------------
       DELETE: delete appointment
    -------------------------------- */
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        $appointmentId = (int)($data['appointment_id'] ?? 0);

        if (!$appointmentId) {
            sendJSON(['message' => 'Hiányzó foglalás'], 400);
        }

        $stmt = $pdo->prepare("SELECT * FROM appointment WHERE appointment_id = ?");
        $stmt->execute([$appointmentId]);
        $appointment = $stmt->fetch();
        if (!$appointment) {
            sendJSON(['message' => 'Időpont nem található'], 404);
        }

        // Permission checks
        if ($user['role'] === 'owner') {
            $stmt = $pdo->prepare("SELECT 1 FROM owner_pet WHERE owner_id = ? AND pet_id = ?");
            $stmt->execute([$user['sub'], $appointment['pet_id']]);
            if (!$stmt->fetch()) {
                sendJSON(['message' => 'Nincs jogosultság ehhez az időponthoz'], 403);
            }
        } elseif ($user['role'] === 'vet' && $appointment['vet_id'] != $user['sub']) {
            sendJSON(['message' => 'Ez az időpont nem hozzád tartozik'], 403);
        }

        $stmt = $pdo->prepare("DELETE FROM appointment WHERE appointment_id = ?");
        $stmt->execute([$appointmentId]);

        sendJSON(['message' => 'Időpont törölve']);
        break;

    default:
        sendJSON(['message' => 'Metódus nem engedélyezett'], 405);
}
