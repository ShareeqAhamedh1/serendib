<?php
require_once __DIR__ . '/phpqrcode/qrlib.php';

$data = $_GET['data'] ?? '';

if (!$data) {
    exit;
}

header('Content-Type: image/png');

QRcode::png(
    $data,
    null,
    QR_ECLEVEL_L,
    6
);
