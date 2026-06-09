<?php
require_once __DIR__.'/conn.php';
require_once __DIR__.'/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: ../admin/smart-announcement.php?result=error");
  exit;
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
  header("Location: ../admin/smart-announcement.php?result=error");
  exit;
}

$title       = trim($_POST['title']);
$message     = trim($_POST['message']);
$target_type = $_POST['target_type'];
$class_id    = $_POST['class_id'] ?: null;
$priority    = $_POST['priority'];
$expires_at  = $_POST['expires_at'] ?: null;
$audio_file  = $_POST['audio_file'] ?: null;

$stmt = $conn->prepare("
  INSERT INTO smart_announcements
  (title,message,target_type,class_id,sound_file,priority,expires_at,created_at)
  VALUES (?,?,?,?,?,?,?,NOW())
");

$stmt->bind_param(
  "sssssss",
  $title,
  $message,
  $target_type,
  $class_id,
  $audio_file,
  $priority,
  $expires_at
);

$stmt->execute();

header("Location: ../admin/smart-announcement.php?result=success");
exit;
