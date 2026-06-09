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

  $class_id = (int)$_POST['class_id'];
  $subject_id = (int)$_POST['subject_id'];
  $teacher_id = (int)$_POST['teacher_id'];

  // prevent duplicates
  $check = $conn->prepare("SELECT id FROM class_subject_teacher WHERE class_id=? AND subject_id=? AND teacher_id=?");
  $check->bind_param("iii", $class_id, $subject_id, $teacher_id);
  $check->execute();
  if ($check->get_result()->num_rows > 0) {
    header('Location: ' . BASE_URL . 'admin/mappings.php?exists=1');
    exit;
  }

  $stmt = $conn->prepare("INSERT INTO class_subject_teacher (class_id, subject_id, teacher_id) VALUES (?, ?, ?)");
  $stmt->bind_param("iii", $class_id, $subject_id, $teacher_id);
  $stmt->execute();

  header('Location: ' . BASE_URL . 'admin/mappings.php?created=1');
  exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

  $id = (int)$_POST['id'];
  $class_id = (int)$_POST['class_id'];
  $subject_id = (int)$_POST['subject_id'];
  $teacher_id = (int)$_POST['teacher_id'];

  $stmt = $conn->prepare("UPDATE class_subject_teacher SET class_id=?, subject_id=?, teacher_id=? WHERE id=?");
  $stmt->bind_param("iiii", $class_id, $subject_id, $teacher_id, $id);
  $stmt->execute();

  header('Location: ' . BASE_URL . 'admin/mappings.php?updated=1');
  exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("DELETE FROM class_subject_teacher WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header('Location: ' . BASE_URL . 'admin/mappings.php?deleted=1');
  exit;
}
