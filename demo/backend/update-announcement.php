<?php
require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ../admin/smart-announcement.php");
  exit;
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
  die('CSRF validation failed');
}

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
  header("Location: ../admin/smart-announcement.php");
  exit;
}

/* ===============================
   FETCH CURRENT RECORD
================================ */
$stmt = $conn->prepare("
  SELECT sound_file, expires_at
  FROM smart_announcements
  WHERE id=?
  LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$current = $stmt->get_result()->fetch_assoc();

if (!$current) {
  die('Announcement not found');
}

if ($current['expires_at'] && strtotime($current['expires_at']) <= time()) {
  die('Expired announcements cannot be edited');
}

/* ===============================
   INPUTS
================================ */
$title       = trim($_POST['title']);
$message     = trim($_POST['message']);
$target_type = $_POST['target_type'];
$class_id    = $_POST['class_id'] ?: null;
$priority    = $_POST['priority'];
$expires_at  = $_POST['expires_at'] ?: null;

$sound_file = $_POST['audio_file'] !== ''
  ? $_POST['audio_file']
  : $current['sound_file'];

/* ===============================
   UPDATE
================================ */
$stmt = $conn->prepare("
  UPDATE smart_announcements
  SET
    title=?,
    message=?,
    target_type=?,
    class_id=?,
    sound_file=?,
    priority=?,
    expires_at=?
  WHERE id=?
");

$stmt->bind_param(
  "sssisssi",
  $title,
  $message,
  $target_type,
  $class_id,
  $sound_file,
  $priority,
  $expires_at,
  $id
);

$stmt->execute();

/* ===============================
   REDIRECT
================================ */
header("Location: ../admin/smart-announcement.php?updated=1");
exit;
