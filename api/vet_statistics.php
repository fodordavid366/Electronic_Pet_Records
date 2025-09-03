<?php

require_once __DIR__ . '/../includes/db.php';

header('Content-Type: application/json');

try {
    $sql = "
        SELECT v.vet_id, v.first_name, v.last_name, COUNT(a.appointment_id) AS appointment_count
        FROM vet v
        LEFT JOIN appointment a ON v.vet_id = a.vet_id
        GROUP BY v.vet_id, v.first_name, v.last_name
        ORDER BY appointment_count DESC
    ";

    $stmt = $pdo->query($sql);
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $stats]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
