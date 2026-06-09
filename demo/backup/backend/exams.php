<?php
require 'conn.php';
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {
  header('HTTP/1.1 401 Unauthorized'); exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

  $name = trim($_POST['exam_name']);
  $term = trim($_POST['term']);
  $start = $_POST['start_date'] ?: null;
  $end = $_POST['end_date'] ?: null;
  $status = $_POST['status'];

  $stmt = $conn->prepare("INSERT INTO exams (exam_name, term, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $name, $term, $start, $end, $status);
  $stmt->execute();

  header('Location: ../admin/exams.php?created=1'); exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

  $id = (int)$_POST['id'];
  $name = trim($_POST['exam_name']);
  $term = trim($_POST['term']);
  $start = $_POST['start_date'] ?: null;
  $end = $_POST['end_date'] ?: null;
  $status = $_POST['status'];

  $stmt = $conn->prepare("UPDATE exams SET exam_name=?, term=?, start_date=?, end_date=?, status=? WHERE id=?");
  $stmt->bind_param("sssssi", $name, $term, $start, $end, $status, $id);
  $stmt->execute();

  header('Location: ../admin/exams.php?updated=1'); exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("DELETE FROM exams WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  header('Location: ../admin/exams.php?deleted=1'); exit;
}
