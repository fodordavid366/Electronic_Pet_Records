<?php
require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/dokiAuth.php';

$user = checkDokiAuth();
if (!$user) {
    http_response_code(401);
    echo json_encode(['message' => 'Nincs jogosultság']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$vet_id = $user->sub;

switch ($method) {
    case 'GET':
        // Fetch existing schedule for this vet
        $stmt = $pdo->prepare("SELECT * FROM vet_schedule WHERE vet_id = ?");
        $stmt->execute([$vet_id]);
        $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($schedules);
        break;

    case 'POST':
        // Save/update schedule
        $weekdays = ['monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6, 'sunday' => 7];

        $data = [];
        foreach ($weekdays as $dayName => $dayNumber) {
            $start = $_POST["{$dayName}_start"] ?? null;
            $end = $_POST["{$dayName}_end"] ?? null;
            $slot = $_POST["{$dayName}_number"] ?? null;

            if (!$start || !$end || !$slot) continue;

            $data[] = [
                'weekday' => $dayNumber,
                'start_time' => $start,
                'end_time' => $end,
                'slot_minutes' => (int)$slot
            ];
        }

        if (empty($data)) {
            http_response_code(400);
            echo json_encode(['message' => 'Nincs adat elküldve']);
            exit;
        }

        try {
            $pdo->beginTransaction();

            // Delete existing
            $stmtDel = $pdo->prepare("DELETE FROM vet_schedule WHERE vet_id = ?");
            $stmtDel->execute([$vet_id]);

            // Insert new
            $stmt = $pdo->prepare("INSERT INTO vet_schedule (vet_id, weekday, start_time, end_time, slot_minutes) VALUES (?, ?, ?, ?, ?)");
            foreach ($data as $day) {
                $stmt->execute([$vet_id, $day['weekday'], $day['start_time'], $day['end_time'], $day['slot_minutes']]);
            }

            $pdo->commit();
            echo json_encode(['message' => 'Munkarend mentve!']);
        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode(['message' => 'Hiba történt: ' . $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Metódus nem engedélyezett']);
        break;
}

