<?php

require '../includes/db.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Ha ID van az URL-ben, akkor egyet hozunk, ha nincs, akkor mindet
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $pdo->prepare("SELECT * FROM treatment WHERE treatment_id = ?");
            $stmt->execute([$id]);
            $treatment = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($treatment) {
                echo json_encode($treatment);
            } else {
                http_response_code(404);
                echo json_encode(["hiba" => "A kezelés nem található."]);
            }
        } else {
            $stmt = $pdo->query("SELECT * FROM treatment");
            $treatments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($treatments);
        }
        break;

    case 'POST':
        // Új kezelés hozzáadása
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['name'], $data['duration_min'], $data['cost'])) {
            http_response_code(400);
            echo json_encode(["hiba" => "Hiányzó adatok a kezelés létrehozásához."]);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO treatment (name, duration_min, cost) VALUES (?, ?, ?)");
        $ok = $stmt->execute([
            $data['name'],
            $data['duration_min'],
            $data['cost']
        ]);

        if ($ok) {
            echo json_encode(["uzenet" => "A kezelés sikeresen létrehozva.", "id" => $pdo->lastInsertId()]);
        } else {
            http_response_code(500);
            echo json_encode(["hiba" => "Nem sikerült létrehozni a kezelést."]);
        }
        break;

    case 'PUT':
        // Kezelés módosítása
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["hiba" => "Hiányzik az azonosító."]);
            exit;
        }
        $id = intval($_GET['id']);
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $pdo->prepare("UPDATE treatment SET name = ?, duration_min = ?, cost = ? WHERE treatment_id = ?");
        $ok = $stmt->execute([
            $data['name'] ?? null,
            $data['duration_min'] ?? null,
            $data['cost'] ?? null,
            $id
        ]);

        if ($ok) {
            echo json_encode(["uzenet" => "A kezelés sikeresen módosítva."]);
        } else {
            http_response_code(500);
            echo json_encode(["hiba" => "Nem sikerült módosítani a kezelést."]);
        }
        break;

    case 'DELETE':
        // Kezelés törlése
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["hiba" => "Hiányzik az azonosító."]);
            exit;
        }
        $id = intval($_GET['id']);
        $stmt = $pdo->prepare("DELETE FROM treatment WHERE treatment_id = ?");
        $ok = $stmt->execute([$id]);

        if ($ok) {
            echo json_encode(["uzenet" => "A kezelés sikeresen törölve."]);
        } else {
            http_response_code(500);
            echo json_encode(["hiba" => "Nem sikerült törölni a kezelést."]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["hiba" => "Nem támogatott metódus."]);
        break;
}
