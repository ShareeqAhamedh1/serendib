<?php
require 'conn.php';
require 'helpers.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['status'=>'error','message'=>'Unauthorized']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$log_id      = (int)($data['log_id'] ?? 0);
$student_id  = (int)($data['student_id'] ?? 0);
$homework_id = (int)($data['homework_id'] ?? 0);

if (!$log_id || !$student_id || !$homework_id) {
  echo json_encode(['status'=>'error','message'=>'Invalid request']);
  exit;
}

/* ===============================
   FETCH LOG
================================ */
$log = $conn->query("
  SELECT house_id, academic_year_id, points
  FROM house_point_logs
  WHERE id=$log_id
    AND entity_type='student'
    AND source='HOMEWORK'
")->fetch_assoc();

if (!$log) {
  echo json_encode(['status'=>'error','message'=>'Log not found']);
  exit;
}

$house_id = $log['house_id'];
$year_id  = $log['academic_year_id'];
$points   = (int)$log['points'];

$conn->begin_transaction();

try {

  /* DELETE LOG */
  $conn->query("DELETE FROM house_point_logs WHERE id=$log_id");

  /* UPDATE HOUSE TOTAL */
  $conn->query("
    UPDATE house_points
    SET total_points = total_points - $points
    WHERE house_id=$house_id AND academic_year_id=$year_id
  ");

  /* DELETE SUBMISSION */
  $sub = $conn->query("
    SELECT file_path
    FROM homework_submissions
    WHERE homework_id=$homework_id AND student_id=$student_id
    LIMIT 1
  ")->fetch_assoc();

  if ($sub) {
    if ($sub['file_path'] && file_exists(__DIR__.'/../'.$sub['file_path'])) {
      unlink(__DIR__.'/../'.$sub['file_path']);
    }

    $conn->query("
      DELETE FROM homework_submissions
      WHERE homework_id=$homework_id AND student_id=$student_id
    ");
  }

  $conn->commit();

  echo json_encode([
    'status'=>'success',
    'message'=>'Homework submission & house points removed'
  ]);

} catch (Exception $e) {
  $conn->rollback();
  echo json_encode(['status'=>'error','message'=>'Failed to remove']);
}
