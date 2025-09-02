<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../vendor/autoload.php';


// JWT kiadása dokiknak
function issueToken(int $vetId, string $role): string
{
    $payload = [
        'iss'  => $_ENV['BASE_URL'] ?? 'http://localhost',
        'sub'  => $vetId,
        'role' => $role,
        'exp'  => time() + 7200
    ];

    return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
}

// JWT ellenőrzés cookie-ból
function checkDokiAuth()
{
    if (empty($_COOKIE['auth_token'])) {
        return null;
    }

    try {
        $decoded = JWT::decode($_COOKIE['auth_token'], new Key($_ENV['JWT_SECRET'], 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        error_log("JWT decode error: " . $e->getMessage());
        return null;
    }
}
