<?php
require 'conn.php';
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {
  header('HTTP/1.1 401 Unauthorized');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die('Invalid request');
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
  die('CSRF validation failed');
}

$scope = $_POST['scope'] ?? 'class'; // 'class' or 'individual'
$fee_type_id = (int)$_POST['fee_type_id'];
$amount = (float)($_POST['amount'] ?? 0);
$term = trim($_POST['term'] ?? '');
$due_date = $_POST['due_date'] ?? null;

if ($scope === 'class') {
  $class_id = (int)$_POST['class_id'];
  $section_id = (int)$_POST['section_id'];

  // Fetch all students in this class/section
  $q = $conn->prepare("SELECT id FROM students WHERE class_id=? AND section_id=?");
  $q->bind_param("ii", $class_id, $section_id);
  $q->execute();
  $res = $q->get_result();

  if ($res->num_rows === 0) {
    die('No students found in selected class/section.');
  }

  $stmt = $conn->prepare("
    INSERT INTO student_fees (student_id, fee_type_id, term, amount, status, due_date)
    VALUES (?, ?, ?, ?, 'Pending', ?)
  ");

  while ($row = $res->fetch_assoc()) {
    $sid = (int)$row['id'];
    // avoid duplicate assignment for same student & fee_type & term (optional)
    $chk = $conn->prepare("SELECT id FROM student_fees WHERE student_id=? AND fee_type_id=? AND term=? LIMIT 1");
    $chk->bind_param("iis", $sid, $fee_type_id, $term);
    $chk->execute();
    $exists = $chk->get_result()->fetch_assoc();
    if ($exists) continue;

    // bind types: student_id(i), fee_type_id(i), term(s), amount(d), due_date(s) => "iisds"
    $stmt->bind_param("iisds", $sid, $fee_type_id, $term, $amount, $due_date);
    $stmt->execute();
  }

  header('Location: ' . BASE_URL . 'admin/assign-fees.php?assigned=1');
  exit;
}
elseif ($scope === 'individual') {
  $student_ids = $_POST['student_ids'] ?? [];
  if (!is_array($student_ids) || count($student_ids) === 0) {
    die('No students selected.');
  }

  $stmt = $conn->prepare("
    INSERT INTO student_fees (student_id, fee_type_id, term, amount, status, due_date)
    VALUES (?, ?, ?, ?, 'Pending', ?)
  ");

  foreach ($student_ids as $sidRaw) {
    $sid = (int)$sidRaw;
    if ($sid <= 0) continue;

    // optional duplicate check
    $chk = $conn->prepare("SELECT id FROM student_fees WHERE student_id=? AND fee_type_id=? AND term=? LIMIT 1");
    $chk->bind_param("iis", $sid, $fee_type_id, $term);
    $chk->execute();
    $exists = $chk->get_result()->fetch_assoc();
    if ($exists) continue;

    $stmt->bind_param("iisds", $sid, $fee_type_id, $term, $amount, $due_date);
    $stmt->execute();
  }

  header('Location: ' . BASE_URL . 'admin/assign-fees.php?assigned=1');
  exit;
}
else {
  die('Invalid scope');
}
