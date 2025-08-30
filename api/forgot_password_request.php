<?php

require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/mailer.php';

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');

if (!$email) sendJSON(['message' => 'Adj meg egy email címet!'], 400);

// Ellenőrizzük a felhasználót
$stmt = $pdo->prepare("SELECT owner_id FROM owner WHERE email = ?");
$stmt->execute([$email]);
$owner = $stmt->fetch();

if (!$owner) {
    // Ne áruljuk el, hogy létezik-e a fiók
    sendJSON(['message' => 'Ha a fiók létezik, emailt küldtünk.'], 200);
}

// Generálunk token-t és lejárati időt
$token = bin2hex(random_bytes(32));
$expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));

// Mentés az adatbázisba
$update = $pdo->prepare("UPDATE owner SET forgotten_password_token = ?, forgotten_password_token_expires = ? WHERE owner_id = ?");
$update->execute([$token, $expires, $owner['owner_id']]);

$baseUrl = rtrim($_ENV['BASE_URL'], '/');
$resetLink = $baseUrl . "/public/set_new_password.php?token=" . urlencode($token);


sendMail($email, "Jelszó reset", "Kattints a linkre az új jelszóhoz fél órán belül: <a href='$resetLink'>Link</a>");

sendJSON(['message' => 'Ha a fiók létezik, emailt küldtünk.']);
