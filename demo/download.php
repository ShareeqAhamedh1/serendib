<?php
require_once __DIR__ . '/phpqrcode/qrlib.php';

$data = $_POST['data'] ?? '';

if (!$data) {
    die('Invalid request');
}

// Temporary file
$tempFile = tempnam(sys_get_temp_dir(), 'qr_');

// Generate QR image
QRcode::png(
    $data,
    $tempFile,
    QR_ECLEVEL_L,
    8
);

// Download headers
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="qr-code.png"');
header('Content-Length: ' . filesize($tempFile));

// Output file
readfile($tempFile);
unlink($tempFile);
exit;
