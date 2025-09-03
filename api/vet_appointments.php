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

switch ($method) {
    case 'GET':
        $stmt = $pdo->prepare("SELECT a.*, p.name AS pet_name, CONCAT(v.first_name, ' ', v.last_name) AS vet_name, t.name AS treatment_name
            FROM appointment a
            JOIN pet p ON a.pet_id = p.pet_id
            JOIN vet v ON a.vet_id = v.vet_id
            JOIN treatment t ON a.treatment_id = t.treatment_id
            WHERE a.vet_id = ? ORDER BY a.starts_at DESC");
        $stmt->execute([$user->sub]);
        $appointments = $stmt->fetchAll();
        echo json_encode($appointments);
        break;

    case 'PATCH':
        parse_str(file_get_contents("php://input"), $data);

        $appointmentId = (int)($data['appointment_id'] ?? 0);
        $status = $data['status'] ?? '';
        $description = $data['description'] ?? '';

        if (!$appointmentId) {
            http_response_code(400);
            echo json_encode(['message' => 'Hiányzó appointment_id']);
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM appointment WHERE appointment_id = ?");
        $stmt->execute([$appointmentId]);
        $appointment = $stmt->fetch();
        if (!$appointment) {
            http_response_code(404);
            echo json_encode(['message' => 'Időpont nem található']);
            exit;
        }

        if ($user->role === 'vet' && $appointment['vet_id'] != $user->sub) {
            http_response_code(403);
            echo json_encode(['message' => 'Ez az időpont nem hozzád tartozik']);
            exit;
        }

        if ($status) {
            $stmt = $pdo->prepare("UPDATE appointment SET status = ? WHERE appointment_id = ?");
            $stmt->execute([$status, $appointmentId]);
        }
        if ($description) {
            $stmt = $pdo->prepare("UPDATE appointment SET description = ? WHERE appointment_id = ?");
            $stmt->execute([$description, $appointmentId]);
        }

        echo json_encode(['message' => 'Időpont frissítve']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Metódus nem engedélyezett']);
}
