<?php
header("Content-Type: application/json");

require_once __DIR__ . "/../includes/db.php"; // your PDO connection

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    // 🔹 List all owners
    if ($method === 'GET' && $action === 'list') {
        $stmt = $pdo->query("SELECT owner_id, last_name, first_name, email, phone_number, birth_date, is_banned FROM owner");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // 🔹 Update owner
    if ($method === 'PUT' && $action === 'update') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !$data['id']) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Missing ID"]);
            exit;
        }

        $banned = !empty($data['banned']) ? 1 : 0;

        $stmt = $pdo->prepare("
            UPDATE owner
            SET last_name=:last_name, first_name=:first_name, email=:email, 
                phone_number=:phone, birth_date=:birth_date, is_banned=:banned 
            WHERE owner_id=:id
        ");
        $stmt->execute([
            ":id"         => $data['id'],
            ":last_name"  => $data['last_name'],
            ":first_name" => $data['first_name'],
            ":email"      => $data['email'],
            ":phone"      => $data['phone'],
            ":birth_date" => $data['birth_date'],
            ":banned"     => $banned
        ]);

        echo json_encode(["success" => true]);
        exit;
    }

    // 🔹 Delete owner
    if ($method === 'DELETE' && $action === 'delete') {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Missing ID"]);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM owner WHERE owner_id=:id");
        $stmt->execute([":id" => $id]);

        echo json_encode(["success" => true]);
        exit;
    }

    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid request"]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
