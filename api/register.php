<?php



require_once __DIR__ . '/../core/init.php';
require_once __DIR__ . '/../includes/mailer.php';

use PHPMailer\PHPMailer\Exception;

// Function to validate password strength
function validatePassword($password) {
    if (strlen($password) < 8) {
        return false; // Minimum length check
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return false; // At least one uppercase letter
    }
    if (!preg_match('/[a-z]/', $password)) {
        return false; // At least one lowercase letter
    }
    if (!preg_match('/[0-9]/', $password)) {
        return false; // At least one number
    }
    if (!preg_match('/[!@#$%^&*()_\-+=\[\]{};:\'",.<>?\\|]/', $password)) {
        return false; // At least one special character
    }
    return true;
}

// Read JSON input data
$data = json_decode(file_get_contents('php://input'), true);

// Check if all required fields are set
if (
    !isset($data['email'], $data['password'], $data['password_verify'],
        $data['firstname'], $data['lastname'], $data['phone'], $data['birth_date'])
) {
    sendJSON(['message' => 'Minden mező kitöltése kötelező.'], 400);
}

// Trim input data to remove extra spaces
$email = trim($data['email']);
$password = $data['password'];
$password_v = $data['password_verify'];
$firstname = trim($data['firstname']);
$lastname = trim($data['lastname']);
$phone = trim($data['phone']);
$birth_date = trim($data['birth_date']);

// Check for empty fields to enforce required inputs
if (
    empty($email) || empty($password) || empty($password_v) ||
    empty($firstname) || empty($lastname) || empty($phone) || empty($birth_date)
) {
    sendJSON(['message' => 'Kérjük, töltse ki az összes kötelező mezőt!'], 400);
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendJSON(['message' => 'Érvénytelen e-mail cím!'], 400);
}

// Check if passwords match
if ($password !== $password_v) {
    sendJSON(['message' => 'A jelszavak nem egyeznek!'], 400);
}

// Validate password strength
if (!validatePassword($password)) {
    sendJSON(['message' => 'A jelszónak minimum 8 karakter hosszúnak kell lennie, tartalmaznia kell nagybetűt, kisbetűt, számot és speciális karaktert.'], 400);
}

// Validate first name length
if (mb_strlen($firstname) > 40) {
    sendJSON(['message' => 'A keresztnév nem lehet több, mint 40 karakter.'], 400);
}

// Validate last name length
if (mb_strlen($lastname) > 40) {
    sendJSON(['message' => 'A vezetéknév nem lehet több, mint 40 karakter.'], 400);
}

// Validate phone number length and characters
if (mb_strlen($phone) > 13) {
    sendJSON(['message' => 'A telefonszám túl hosszú.'], 400);
}
if (!preg_match('/^[0-9+\-\s]+$/', $phone)) {
    sendJSON(['message' => 'A telefonszám csak számokat, plusz jelet, kötőjelet és szóközt tartalmazhat.'], 400);
}

// Validate birth date format (Y-m-d)
$date = DateTime::createFromFormat('Y-m-d', $birth_date);
if (!$date || $date->format('Y-m-d') !== $birth_date) {
    sendJSON(['message' => 'Érvénytelen születési dátum!'], 400);
}

// Check if email already exists in the database
try {
    $stmt = $pdo->prepare("SELECT * FROM owner WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        sendJSON(['message' => 'Ez az e-mail cím már regisztrálva van.'], 409);
    }
} catch (Exception $e) {
    error_log('DB hiba: ' . $e->getMessage());
    sendJSON(['message' => 'Belső szerverhiba. Kérjük, próbálja meg később.'], 500);
}

// Hash the password
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Generate registration token and expiration time
$registrationToken = bin2hex(random_bytes(32));
$expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));

// Insert new owner record into database
try {
    $stmt = $pdo->prepare(
        "INSERT INTO owner (
            email, password, first_name, last_name, phone_number, birth_date,
            registration_token, registration_token_expires, verified,
            forgotten_password_token, forgotten_password_token_expires,
            is_banned, email_notification
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, '', '0000-00-00 00:00:00', 0, 0)"
    );
    $stmt->execute([
        $email,
        $passwordHash,
        $firstname,
        $lastname,
        $phone,
        $birth_date,
        $registrationToken,
        $expiresAt
    ]);
} catch (Exception $e) {
    error_log('DB hiba: ' . $e->getMessage());
    sendJSON(['message' => 'Belső szerverhiba. Kérjük, próbálja meg később.'], 500);
}

// Create activation link
$activationLink = $_ENV['BASE_URL'] . '/activate.php?token=' . $registrationToken;

// Send activation email
$body = "<h3>Aktiváld a fiókodat</h3><a href='$activationLink'>Kattints ide!</a>";

$success = sendMail($email, 'Fiók aktiválása', $body);

if (!$success) {
    // Registration successful but email failed to send
    sendJSON(['message' => 'A regisztráció sikeres, de nem sikerült aktiváló emailt küldeni.'], 500);
}

// Success message
sendJSON(['message' => 'Sikeres regisztráció! Kérjük, ellenőrizze az e-mail fiókját az aktiváláshoz.'], 201);