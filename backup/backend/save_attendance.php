<?php
require 'conn.php';
require 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') die('Invalid request');
if (!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

$class_id = (int)$_POST['class_id'];
$section_id = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : null;
$date = $_POST['date'];
$period = (int)$_POST['period_number'];
$statuses = $_POST['status'] ?? [];
$teacher_id = $_SESSION['user_id'] ?? null; // assuming teacher is logged in

$count = 0;

foreach ($statuses as $student_id => $status) {
  $stmt = $conn->prepare("
    INSERT INTO attendance (student_id, class_id, section_id, date, period_number, status, marked_by)
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE status=VALUES(status)
  ");
  $stmt->bind_param("iiisisi", $student_id, $class_id, $section_id, $date, $period, $status, $teacher_id);
  if ($stmt->execute()) $count++;
}

echo "✅ Attendance saved successfully for $count students.";
