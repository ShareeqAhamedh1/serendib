<?php
require 'conn.php';
header('Content-Type: application/json');

$day        = $_GET['day'] ?? '';
$teacher_id = isset($_GET['teacher_id']) ? (int)$_GET['teacher_id'] : 0;
$class_id   = isset($_GET['class_id']) ? (int)$_GET['class_id'] : 0;
$section_id = isset($_GET['section_id']) ? (int)$_GET['section_id'] : 0;
$basket_grp = $_GET['basket_group'] ?? null; // G1 / G2 / G3 or null

$response = [
  'teacher_conflicts' => [],
  'class_conflicts'   => [], // normal subjects
  'basket_conflicts'  => []  // same group only
];

if (!$day) {
  echo json_encode($response);
  exit;
}

/* ===============================
   1️⃣ TEACHER CONFLICTS (UNCHANGED)
================================ */
if ($teacher_id) {
  $stmt = $conn->prepare("
    SELECT DISTINCT period_number
    FROM timetable
    WHERE day_of_week = ?
      AND teacher_id = ?
  ");
  $stmt->bind_param("si", $day, $teacher_id);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($r = $res->fetch_assoc()) {
    $response['teacher_conflicts'][] = (int)$r['period_number'];
  }
}

/* ===============================
   2️⃣ CLASS CONFLICTS – NORMAL SUBJECTS
   (basket_group IS NULL)
================================ */
if ($class_id) {
  $stmt = $conn->prepare("
    SELECT DISTINCT period_number
    FROM timetable
    WHERE day_of_week = ?
      AND class_id = ?
      AND (section_id <=> ?)
      AND basket_group IS NULL
  ");
  $stmt->bind_param("sii", $day, $class_id, $section_id);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($r = $res->fetch_assoc()) {
    $response['class_conflicts'][] = (int)$r['period_number'];
  }
}

/* ===============================
   3️⃣ BASKET GROUP CONFLICTS
   (same group only)
================================ */
if ($class_id && $basket_grp) {
  $stmt = $conn->prepare("
    SELECT DISTINCT period_number
    FROM timetable
    WHERE day_of_week = ?
      AND class_id = ?
      AND (section_id <=> ?)
      AND basket_group = ?
  ");
  $stmt->bind_param("siis", $day, $class_id, $section_id, $basket_grp);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($r = $res->fetch_assoc()) {
    $response['basket_conflicts'][] = (int)$r['period_number'];
  }
}

echo json_encode($response);
