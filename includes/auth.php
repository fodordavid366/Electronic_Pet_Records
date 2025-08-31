<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Create JWT token
function issueToken(int $userId, string $role): string
{
    $payload = [
        'iss'  => $_ENV['BASE_URL'], // issuer
        'sub'  => $userId,           // subject = user id
        'role' => $role,
        'exp'  => time() + 7200
    ];
    return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
}

// Verify JWT token, return payload or null
function authMiddleware(): ?array
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!preg_match('/Bearer\s(\S+)/', $header, $m)) {
        return null;
    }
    try {
        $decoded = JWT::decode($m[1], new Key($_ENV['JWT_SECRET'], 'HS256'));
        return (array)$decoded;
    } catch (Exception $e) {
        error_log("JWT decode error: " . $e->getMessage());
        return null;
    }
}
