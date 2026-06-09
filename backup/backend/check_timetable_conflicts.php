<?php
require 'conn.php';
header('Content-Type: application/json');

$day = $_GET['day'] ?? '';
$teacher_id = isset($_GET['teacher_id']) ? (int)$_GET['teacher_id'] : 0;
$class_id = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
$section_id = isset($_GET['section_id']) ? (int)$_GET['section_id'] : 0;

$response = [
  'teacher_conflicts' => [],
  'class_conflicts' => []
];

if (!$day) {
  echo json_encode($response);
  exit;
}

// 1️⃣ Find all periods where this teacher is already teaching that day
if ($teacher_id) {
  $stmt = $conn->prepare("
    SELECT DISTINCT period_number 
    FROM timetable 
    WHERE day_of_week = ? AND teacher_id = ?
  ");
  $stmt->bind_param("si", $day, $teacher_id);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($r = $res->fetch_assoc()) {
    $response['teacher_conflicts'][] = (int)$r['period_number'];
  }
}

// 2️⃣ Find all periods where this class + section already has a slot that day
if ($class_id) {
  $stmt = $conn->prepare("
    SELECT DISTINCT period_number 
    FROM timetable 
    WHERE day_of_week = ? 
      AND class_id = ? 
      AND (section_id <=> ?)
  ");
  $stmt->bind_param("sii", $day, $class_id, $section_id);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($r = $res->fetch_assoc()) {
    $response['class_conflicts'][] = (int)$r['period_number'];
  }
}

echo json_encode($response);
