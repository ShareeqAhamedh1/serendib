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

  $exam_id = (int)$_POST['exam_id'];
  $class_id = (int)$_POST['class_id'];
  $subject_id = (int)$_POST['subject_id'];
  $max = (float)$_POST['max_marks'];
  $pass = (float)$_POST['pass_marks'];

  // Prevent duplicate
  $check = $conn->prepare("SELECT id FROM exam_subjects WHERE exam_id=? AND class_id=? AND subject_id=?");
  $check->bind_param("iii", $exam_id, $class_id, $subject_id);
  $check->execute();
  if ($check->get_result()->num_rows > 0) {
    header("Location: ../admin/exam-subjects.php?exists=1");
    exit;
  }

  $stmt = $conn->prepare("INSERT INTO exam_subjects (exam_id, class_id, subject_id, max_marks, pass_marks) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("iiidd", $exam_id, $class_id, $subject_id, $max, $pass);
  $stmt->execute();

  header("Location: ../admin/exam-subjects.php?created=1");
  exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("DELETE FROM exam_subjects WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header("Location: ../admin/exam-subjects.php?deleted=1");
  exit;
}
