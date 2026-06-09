<?php
require 'conn.php';

$house_id = (int)$_POST['house_id'];
$points   = (int)$_POST['points'];
$action   = $_POST['action']; // ADD | DEDUCT
$reason   = $_POST['reason'];
$source   = $_POST['source']; // ADMIN | TEACHER | SYSTEM
$entity_type = $_POST['entity_type'] ?? null;
$entity_id   = $_POST['entity_id'] ?? null;


/* Get active year */
$year = $conn->query("
  SELECT id FROM academic_years WHERE is_active=1 LIMIT 1
")->fetch_assoc();

$year_id = $year['id'];

if ($action === 'DEDUCT') {
  $points = -abs($points);
}

/* Log entry */
$stmt = $conn->prepare("
  INSERT INTO house_point_logs
  (house_id, academic_year_id, entity_type, entity_id, points, action, reason, source)
  VALUES (?,?,?,?,?,?,?,?)
");

$stmt->bind_param(
  "iississs",
  $house_id,
  $year_id,
  $entity_type,
  $entity_id,
  $points,
  $action,
  $reason,
  $source
);

$stmt->execute();

/* Update total */
$conn->query("
  INSERT INTO house_points (house_id, academic_year_id, total_points)
  VALUES ($house_id, $year_id, $points)
  ON DUPLICATE KEY UPDATE total_points = total_points + $points
");

echo json_encode(['status'=>'success']);
