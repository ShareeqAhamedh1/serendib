<?php
require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/helpers.php';

header('Content-Type: application/json');

/* ===============================
   CSRF
================================ */
if (!verify_csrf($_POST['csrf_token'] ?? '')) {
  echo json_encode([
    'status'  => 'error',
    'message' => 'CSRF validation failed'
  ]);
  exit;
}

/* ===============================
   FILE CHECK
================================ */
if (empty($_FILES['audio']) || $_FILES['audio']['error'] !== UPLOAD_ERR_OK) {
  echo json_encode([
    'status'  => 'error',
    'message' => 'Invalid audio upload'
  ]);
  exit;
}

$event = $_POST['event_type'] ?? '';
$file  = $_FILES['audio'];

if (!$event) {
  echo json_encode([
    'status'  => 'error',
    'message' => 'Event type missing'
  ]);
  exit;
}

/* ===============================
   SAVE FILE
================================ */
$ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$name = uniqid('audio_', true) . "_$event.$ext";

$uploadDir = __DIR__ . '/../uploads/announcements/';
if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

$dest = $uploadDir . $name;

if (!move_uploaded_file($file['tmp_name'], $dest)) {
  echo json_encode([
    'status'  => 'error',
    'message' => 'Failed to save audio file'
  ]);
  exit;
}

/* ===============================
   DB INSERT
================================ */
$stmt = $conn->prepare("
  INSERT INTO smart_audio_events (event_type, audio_file, created_at)
  VALUES (?, ?, NOW())
");
$stmt->bind_param("ss", $event, $name);
$stmt->execute();

/* ===============================
   RESPONSE
================================ */
echo json_encode([
  'status'  => 'success',
  'message' => 'Audio uploaded successfully'
]);
exit;
