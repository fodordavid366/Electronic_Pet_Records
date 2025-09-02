<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/init.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Get pet_id from query string
$petId = $_GET['pet_id'] ?? null;
if (!$petId) {
    http_response_code(400);
    echo "Hiányzó pet_id";
    exit;
}

$petId = (int)$petId;
$url = $_ENV['BASE_URL']."/QR_code_page.php?pet_id=$petId";

// Create QR code
$qrCode = new QrCode($url);

// Use PNG writer
$writer = new PngWriter();
$result = $writer->write($qrCode);

// Output QR code image
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
