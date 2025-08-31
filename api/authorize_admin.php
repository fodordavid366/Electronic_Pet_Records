<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function authorizeAdmin(): array
{
    $headers = getallheaders();
    $auth = $headers['Authorization'] ?? '';
    if (!preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
        http_response_code(401);
        echo json_encode(['message' => 'Nincs jogosultsága a művelethez']);
        exit;
    }

    try {
        $decoded = (array)JWT::decode($matches[1], new Key('titkos_kulcs', 'HS256'));
        return $decoded;
    } catch (\Exception $e) {
        http_response_code(401);
        echo json_encode(['message' => 'Érvénytelen token']);
        exit;
    }
}
