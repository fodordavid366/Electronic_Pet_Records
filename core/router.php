<?php
require_once __DIR__ . '/init.php';

// Parse request URI and HTTP method
$path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Handle only API requests, e.g. /api/pets
if (str_starts_with($path, '/api/')) {
    $segments = explode('/', trim($path, '/'));  // ['api', 'pets']
    $resource = $segments[1] ?? '';

    $apiFile = __DIR__ . '/../api/' . $resource . '.php';

    if (is_file($apiFile)) {
        require $apiFile;
        exit;
    }

    sendJSON(['message' => 'Unknown API resource'], 404);
}

// If the path is not /api/ return a simple 404
http_response_code(404);
echo '404 – Page not found';
