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

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
  header("Location: ../admin/smart-announcement.php?result=error");
  exit;
}

/* ===============================
   CHECK ANNOUNCEMENT
================================ */
$stmt = $conn->prepare("
  SELECT expires_at
  FROM smart_announcements
  WHERE id=?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$a = $stmt->get_result()->fetch_assoc();

if (!$a) {
  header("Location: ../admin/smart-announcement.php?result=error");
  exit;
}

if ($a['expires_at'] && strtotime($a['expires_at']) <= time()) {
  header("Location: ../admin/smart-announcement.php?result=expired");
  exit;
}

/* ===============================
   DELETE
================================ */
$stmt = $conn->prepare("
  DELETE FROM smart_announcements
  WHERE id=?
");

$stmt->bind_param("i", $id);
$stmt->execute();

/* ===============================
   REDIRECT
================================ */
header("Location: ../admin/smart-announcement.php?result=deleted");
exit;
