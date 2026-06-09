<?php
require 'conn.php';
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {
  header('HTTP/1.1 401 Unauthorized');
  exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    die('CSRF validation failed');
  }

  $name = trim($_POST['name'] ?? '');
  $desc = trim($_POST['description'] ?? '');
  $amount = (float)($_POST['default_amount'] ?? 0);

  if ($name === '') die('Fee name required');

  $stmt = $conn->prepare("INSERT INTO fee_types (name, description, default_amount) VALUES (?, ?, ?)");
  $stmt->bind_param("ssd", $name, $desc, $amount);
  $stmt->execute();

  header('Location: ' . BASE_URL . 'admin/fee-types.php?created=1');
  exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("DELETE FROM fee_types WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  header('Location: ' . BASE_URL . 'admin/fee-types.php?deleted=1');
  exit;
}

echo "Invalid request";
exit;
