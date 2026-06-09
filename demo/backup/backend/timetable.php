<?php
require 'conn.php';
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {
  header('HTTP/1.1 401 Unauthorized');
  exit;
}

$action = $_GET['action'] ?? '';

/* ============================================================
   CREATE NEW TIMETABLE ENTRY (Supports Multi-Period)
   ============================================================ */
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    die('CSRF failed');
  }

  $class_id   = (int)$_POST['class_id'];
  $section_id = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : null;
  $day_of_week = $_POST['day_of_week'];
  $subject_id = (int)$_POST['subject_id'];
  $teacher_id = (int)$_POST['teacher_id'];

  // Multi-period arrays
  $periods = $_POST['period_number'] ?? [];
  $starts  = $_POST['start_time'] ?? [];
  $ends    = $_POST['end_time'] ?? [];

  if (empty($periods)) {
    header('Location: ' . BASE_URL . 'admin/timetable.php?error=noperiod');
    exit;
  }

  foreach ($periods as $i => $pnum) {
    $pnum  = (int)$pnum;
    $start = $starts[$i] ?? null;
    $end   = $ends[$i] ?? null;

    // Check for duplicate entries (same class, section, day, period)
    $check = $conn->prepare("
      SELECT id 
      FROM timetable 
      WHERE class_id=? AND section_id <=> ? AND day_of_week=? AND period_number=?
    ");
    $check->bind_param("iisi", $class_id, $section_id, $day_of_week, $pnum);
    $check->execute();
    $dup = $check->get_result();
    if ($dup->num_rows > 0) continue; // Skip duplicates silently

    // Insert
    $stmt = $conn->prepare("
      INSERT INTO timetable 
      (class_id, section_id, day_of_week, period_number, subject_id, teacher_id, start_time, end_time)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iisiiiss", 
      $class_id, $section_id, $day_of_week, $pnum, $subject_id, $teacher_id, $start, $end
    );
    $stmt->execute();
  }

  header('Location: ' . BASE_URL . 'admin/timetable.php?created=1');
  exit;
}

/* ============================================================
   UPDATE EXISTING ENTRY
   ============================================================ */
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    die('CSRF failed');
  }

  $id = (int)$_POST['id'];
  $class_id   = (int)$_POST['class_id'];
  $section_id = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : null;
  $day_of_week = $_POST['day_of_week'];
  $period_number = (int)$_POST['period_number'];
  $subject_id = (int)$_POST['subject_id'];
  $teacher_id = (int)$_POST['teacher_id'];
  $start = !empty($_POST['start_time']) ? $_POST['start_time'] : null;
  $end = !empty($_POST['end_time']) ? $_POST['end_time'] : null;

  $stmt = $conn->prepare("
    UPDATE timetable 
    SET class_id=?, section_id=?, day_of_week=?, period_number=?, subject_id=?, teacher_id=?, start_time=?, end_time=? 
    WHERE id=?
  ");
  $stmt->bind_param("iisiiissi", 
    $class_id, $section_id, $day_of_week, $period_number, $subject_id, $teacher_id, $start, $end, $id
  );
  $stmt->execute();

  header('Location: ' . BASE_URL . 'admin/timetable.php?updated=1');
  exit;
}

/* ============================================================
   DELETE ENTRY
   ============================================================ */
if ($action === 'delete' && isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $stmt = $conn->prepare("DELETE FROM timetable WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  header('Location: ' . BASE_URL . 'admin/timetable.php?deleted=1');
  exit;
}
