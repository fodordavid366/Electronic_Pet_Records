<?php

require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/auth.php';

$user = authMiddleware();
if (!$user) {
    sendJSON(['message' => 'Nincs jogosultság!'], 401);
}

// Accept only owner or vet
if (!in_array($user['role'], ['owner', 'vet'])) {
    sendJSON(['message' => 'Nem engedélyezett szerepkör.'], 403);
}

$table = $user['role'] === 'owner' ? 'owner' : 'vet';
$primaryKey = "{$table}_id";
$userId = $user['sub'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /* GET: return own profile */
    case 'GET':
        $stmt = $pdo->prepare("SELECT email, first_name, last_name, phone_number, birth_date, email_notify
                               FROM $table WHERE $primaryKey = ?");
        $stmt->execute([$userId]);
        $profile = $stmt->fetch();
        if (!$profile) {
            sendJSON(['message' => 'A felhasználó nem található.'], 404);
        }
        sendJSON($profile);
        break;

    /* PUT: update profile fields */
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            sendJSON(['message' => 'Érvénytelen JSON.'], 400);
        }

        // Allowed fields to update
        $allowed = ['first_name', 'last_name', 'phone_number', 'birth_date', 'email_notify'];
        $set = [];
        $params = [];

        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $value = trim($data[$field]);

                // Basic validations
                switch ($field) {
                    case 'first_name':
                    case 'last_name':
                        if (mb_strlen($value) > 40) {
                            sendJSON(['message' => ucfirst(str_replace('_', ' ', $field)) . ' túl hosszú.'], 400);
                        }
                        break;
                    case 'phone_number':
                        if (mb_strlen($value) > 13 || !preg_match('/^[0-9+\-\s]+$/', $value)) {
                            sendJSON(['message' => 'Érvénytelen telefonszám.'], 400);
                        }
                        break;
                    case 'birth_date':
                        $d = DateTime::createFromFormat('Y-m-d', $value);
                        if (!$d || $d->format('Y-m-d') !== $value) {
                            sendJSON(['message' => 'Érvénytelen születési dátum.'], 400);
                        }
                        break;
                    case 'email_notify':
                        $value = $value ? 1 : 0;
                        break;

                }

                $set[] = "$field = ?";
                $params[] = $value;
            }
        }

        if (!$set) {
            sendJSON(['message' => 'Nincs frissíthető mező.'], 400);
        }

        $params[] = $userId;

        $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE $primaryKey = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        sendJSON(['message' => 'Profil sikeresen frissítve.']);
        break;

    default:
        sendJSON(['message' => 'A HTTP metódus nem támogatott.'], 405);
}
