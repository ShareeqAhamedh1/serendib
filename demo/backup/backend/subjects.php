<?php
require 'conn.php';
require 'helpers.php';
if (!isset($_SESSION['user_id'])) { header('HTTP/1.1 401 Unauthorized'); exit; }

$action = $_GET['action'] ?? '';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');
  $name = trim($_POST['subject_name'] ?? '');
  $code = trim($_POST['subject_code'] ?? null);
  $stmt = $conn->prepare("INSERT INTO subjects (subject_name, subject_code) VALUES (?, ?)");
  $stmt->bind_param("ss", $name, $code);
  if (!$stmt->execute()) die('Execute failed: ' . $stmt->error);
  header('Location: ' . BASE_URL . 'admin/subjects.php?created=1'); exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');
  $id = (int)($_POST['id'] ?? 0);
  $name = trim($_POST['subject_name'] ?? '');
  $code = trim($_POST['subject_code'] ?? null);
  $stmt = $conn->prepare("UPDATE subjects SET subject_name=?, subject_code=? WHERE id=?");
  $stmt->bind_param("ssi", $name, $code, $id);
  if (!$stmt->execute()) die('Execute failed: ' . $stmt->error);
  header('Location: ' . BASE_URL . 'admin/subjects.php?updated=1'); exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
  $stmt->bind_param("i", $id);
  if (!$stmt->execute()) die('Execute failed: ' . $stmt->error);
  header('Location: ' . BASE_URL . 'admin/subjects.php?deleted=1'); exit;
}

if ($action === 'get' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  echo json_encode($stmt->get_result()->fetch_assoc()); exit;
}
