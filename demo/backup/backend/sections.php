<?php
require 'conn.php';
require 'helpers.php';
if (!isset($_SESSION['user_id'])) { header('HTTP/1.1 401 Unauthorized'); exit; }

$action = $_GET['action'] ?? '';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');
  $class_id = !empty($_POST['class_id']) ? (int)$_POST['class_id'] : null;
  $name = trim($_POST['section_name'] ?? '');
  $stmt = $conn->prepare("INSERT INTO sections (class_id, section_name) VALUES (?, ?)");
  $stmt->bind_param("is", $class_id, $name);
  if (!$stmt->execute()) die('Execute failed: ' . $stmt->error);
  header('Location: ' . BASE_URL . 'admin/sections.php?created=1'); exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');
  $id = (int)($_POST['id'] ?? 0);
  $class_id = !empty($_POST['class_id']) ? (int)$_POST['class_id'] : null;
  $name = trim($_POST['section_name'] ?? '');
  $stmt = $conn->prepare("UPDATE sections SET class_id=?, section_name=? WHERE id=?");
  $stmt->bind_param("isi", $class_id, $name, $id);
  if (!$stmt->execute()) die('Execute failed: ' . $stmt->error);
  header('Location: ' . BASE_URL . 'admin/sections.php?updated=1'); exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("DELETE FROM sections WHERE id = ?");
  $stmt->bind_param("i", $id);
  if (!$stmt->execute()) die('Execute failed: ' . $stmt->error);
  header('Location: ' . BASE_URL . 'admin/sections.php?deleted=1'); exit;
}

if ($action === 'get' && isset($_GET['class_id'])) {
  $class_id = (int)$_GET['class_id'];
  $stmt = $conn->prepare("SELECT id, section_name FROM sections WHERE class_id = ?");
  $stmt->bind_param("i", $class_id);
  $stmt->execute();
  $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  header('Content-Type: application/json'); echo json_encode($rows); exit;
}
