<?php

// Töröljük az auth_token cookie-t
setcookie('auth_token', '', [
    'expires' => time() - 3600, // múltba állítva lejártatjuk
    'path' => '/',
    'secure' => false,   // localhoston false, élesben true
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Átirányítás a login oldalra
header('Location: doctor_login.php');
exit;
