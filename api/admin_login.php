<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../core/init.php';

$pdo = new PDO("mysql:host=localhost;dbname=hk_e_ny", "root", "");
// Read JSON body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing email or password']);
    exit;
}

$email = trim($data['email']);
$password = $data['password'];

if (strlen($email) > 60) {
    http_response_code(400);
    echo json_encode(['message' => 'Érvénytelen e-mail cím']);
}
if (strlen($password) < 6) {
    http_response_code(400);
    echo json_encode(['message' => 'A jelszó túl rövid']);
}

// Fetch admin by email
$stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
$stmt->execute([$email]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify password
if (!password_verify($password, $admin['password'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    exit;
}

// Set session
$_SESSION['admin_id'] = $admin['admin_id'];
$_SESSION['admin_email'] = $admin['email'];
$_SESSION['admin_name'] = $admin['first_name'] . ' ' . $admin['last_name'];

echo json_encode(['success' => true, 'message' => 'Login successful']);
