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

// Verify JWT token, optionally check role
function authMiddleware(?string $requiredRole = null): ?array
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!preg_match('/Bearer\s(\S+)/', $header, $m)) {
        return null;
    }

    try {
        $decoded = JWT::decode($m[1], new Key($_ENV['JWT_SECRET'], 'HS256'));
        $payload = (array)$decoded;

        // Ha kell szerepkört is ellenőrizni
        if ($requiredRole !== null && ($payload['role'] ?? null) !== $requiredRole) {
            return null;
        }

        return $payload;
    } catch (Exception $e) {
        error_log("JWT decode error: " . $e->getMessage());
        return null;
    }
}
