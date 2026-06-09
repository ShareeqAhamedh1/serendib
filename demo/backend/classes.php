<?php
require 'conn.php';
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {
  header('HTTP/1.1 401 Unauthorized');
  exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

  $name = trim($_POST['class_name'] ?? '');
  $desc = trim($_POST['description'] ?? '');

  $stmt = $conn->prepare("INSERT INTO classes (class_name, description) VALUES (?, ?)");
  $stmt->bind_param("ss", $name, $desc);
  if (!$stmt->execute()) die('Execute failed: ' . $stmt->error);
  header('Location: ' . BASE_URL . 'admin/classes.php?created=1');
  exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

  $id = (int)($_POST['id'] ?? 0);
  $name = trim($_POST['class_name'] ?? '');
  $desc = trim($_POST['description'] ?? '');

  $stmt = $conn->prepare("UPDATE classes SET class_name=?, description=? WHERE id=?");
  $stmt->bind_param("ssi", $name, $desc, $id);
  if (!$stmt->execute()) die('Execute failed: ' . $stmt->error);
  header('Location: ' . BASE_URL . 'admin/classes.php?updated=1');
  exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("DELETE FROM classes WHERE id = ?");
  $stmt->bind_param("i", $id);
  if (!$stmt->execute()) die('Execute failed: ' . $stmt->error);
  header('Location: ' . BASE_URL . 'admin/classes.php?deleted=1');
  exit;
}

/* optional: get single class for AJAX */
if ($action === 'get' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM classes WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  echo json_encode($stmt->get_result()->fetch_assoc());
  exit;
}
