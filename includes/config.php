<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

define('DB_DSN', 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4');
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASS', $_ENV['DB_PASS']);

define('MAIL_HOST', $_ENV['MAIL_HOST']);
define('MAIL_USER', $_ENV['MAIL_USER']);
define('MAIL_PASS', $_ENV['MAIL_PASS']);

define('JWT_SECRET', $_ENV['JWT_SECRET']);
define('BASE_URL', $_ENV['BASE_URL']);
