<?php
require 'conn.php';
require 'helpers.php';

if (!isset($_SESSION['user_id'])) {
  header('HTTP/1.1 401 Unauthorized');
  exit;
}

$action = $_GET['action'] ?? '';

/* ============================================================
   CREATE NEW TIMETABLE ENTRY (Basket-aware)
   ============================================================ */
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    die('CSRF failed');
  }

  $class_id     = (int)$_POST['class_id'];
  $section_id   = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : null;
  $day_of_week  = $_POST['day_of_week'];
  $subject_id   = (int)$_POST['subject_id'];
  $teacher_id   = (int)$_POST['teacher_id'];
  $basket_group = !empty($_POST['basket_group']) ? $_POST['basket_group'] : null;

  $periods = $_POST['period_number'] ?? [];
  $starts  = $_POST['start_time'] ?? [];
  $ends    = $_POST['end_time'] ?? [];

  if (empty($periods)) {
    header('Location: ' . BASE_URL . 'admin/timetable.php?error=noperiod');
    exit;
  }

foreach ($periods as $i => $pnum) {

  $pnum = (int)$pnum;

  // 🚫 Skip invalid / interval rows
  if ($pnum <= 0) {
    continue;
  }

  $start = $starts[$i] ?? null;
  $end   = $ends[$i] ?? null;


    /* ❌ HARD RULE: TEACHER DOUBLE BOOKING */
    $tchk = $conn->prepare("
      SELECT id FROM timetable
      WHERE day_of_week=? AND period_number=? AND teacher_id=?
    ");
    $tchk->bind_param("sii", $day_of_week, $pnum, $teacher_id);
    $tchk->execute();
if ($tchk->get_result()->num_rows > 0) {
  $_SESSION['flash'] = [
    'type' => 'error',
    'title' => 'Teacher Busy!',
    'text' => 'This teacher is already assigned for that period.'
  ];
  header('Location: ' . BASE_URL . 'admin/timetable.php');
  exit;
}


    /* ❌ CLASS + PERIOD CONFLICT LOGIC */
    if ($basket_group) {

      // Basket subject → block only SAME basket group
      $chk = $conn->prepare("
        SELECT id FROM timetable
        WHERE class_id=? AND section_id <=> ? 
          AND day_of_week=? AND period_number=? 
          AND basket_group <=> ?
      ");
      $chk->bind_param(
        "iisis",
        $class_id,
        $section_id,
        $day_of_week,
        $pnum,
        $basket_group
      );
      $chk->execute();

      if ($chk->get_result()->num_rows > 0) {
$_SESSION['flash'] = [
  'type' => 'error',
  'title' => 'Basket Busy!',
  'text' => 'This basket is already assigned for that period.'
];
header('Location: ' . BASE_URL . 'admin/timetable.php');
exit;

      }

    } else {

      // Normal subject → block ANY existing entry
      $chk = $conn->prepare("
        SELECT id FROM timetable
        WHERE class_id=? AND section_id <=> ? 
          AND day_of_week=? AND period_number=?
      ");
      $chk->bind_param(
        "iisi",
        $class_id,
        $section_id,
        $day_of_week,
        $pnum
      );
      $chk->execute();

      if ($chk->get_result()->num_rows > 0) {
        continue;
      }
    }

    /* ✅ INSERT */
    $stmt = $conn->prepare("
      INSERT INTO timetable
      (class_id, section_id, day_of_week, period_number,
       subject_id, basket_group, teacher_id, start_time, end_time)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
      "iisiisiss",
      $class_id,
      $section_id,
      $day_of_week,
      $pnum,
      $subject_id,
      $basket_group,
      $teacher_id,
      $start,
      $end
    );

    $stmt->execute();
  }

  $_SESSION['flash'] = [
  'type' => 'success',
  'title' => 'Timetable Created!',
  'text' => 'Periods added successfully.'
];

header('Location: ' . BASE_URL . 'admin/timetable.php');
exit;

}

/* ============================================================
   UPDATE EXISTING ENTRY (Basket-aware)
   ============================================================ */
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    die('CSRF failed');
  }

  $id            = (int)$_POST['id'];
  $class_id      = (int)$_POST['class_id'];
  $section_id    = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : null;
  $day_of_week   = $_POST['day_of_week'];
  $period_number = (int)($_POST['period_number'][0] ?? 0);
  $start         = $_POST['start_time'][0] ?? null;
  $end           = $_POST['end_time'][0] ?? null;
  $subject_id    = (int)$_POST['subject_id'];
  $teacher_id    = (int)$_POST['teacher_id'];
  $basket_group  = !empty($_POST['basket_group']) ? $_POST['basket_group'] : null;

  /* ❌ TEACHER CONFLICT (ignore self) */
  $tchk = $conn->prepare("
    SELECT id FROM timetable
    WHERE day_of_week=? AND period_number=? AND teacher_id=? AND id!=?
  ");
  $tchk->bind_param("siii", $day_of_week, $period_number, $teacher_id, $id);
  $tchk->execute();

  if ($tchk->get_result()->num_rows > 0) {
$_SESSION['flash'] = [
  'type' => 'error',
  'title' => 'Teacher Busy!',
  'text' => 'This teacher is already assigned for that period.'
];
header('Location: ' . BASE_URL . 'admin/timetable.php');
exit;

  }

  /* ❌ CLASS CONFLICT */
  if ($basket_group) {

    $chk = $conn->prepare("
      SELECT id FROM timetable
      WHERE class_id=? AND section_id <=> ? AND day_of_week=? 
        AND period_number=? AND basket_group <=> ? AND id!=?
    ");
    $chk->bind_param(
      "iisisi",
      $class_id,
      $section_id,
      $day_of_week,
      $period_number,
      $basket_group,
      $id
    );
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {

    $_SESSION['flash'] = [
  'type' => 'error',
  'title' => 'Basket Busy!',
  'text' => 'This Basket is already assigned for that period.'
];

header('Location: ' . BASE_URL . 'admin/timetable.php');
exit;

    }

  } else {

    $chk = $conn->prepare("
      SELECT id FROM timetable
      WHERE class_id=? AND section_id <=> ? AND day_of_week=? 
        AND period_number=? AND id!=?
    ");
    $chk->bind_param(
      "iisii",
      $class_id,
      $section_id,
      $day_of_week,
      $period_number,
      $id
    );
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
$_SESSION['flash'] = [
  'type' => 'error',
  'title' => 'Class Busy!',
  'text' => 'This Class is already assigned for that period.'
];
header('Location: ' . BASE_URL . 'admin/timetable.php');
exit;

    }
  }

  /* ✅ UPDATE */
  $stmt = $conn->prepare("
    UPDATE timetable SET
      class_id=?, section_id=?, day_of_week=?, period_number=?,
      subject_id=?, basket_group=?, teacher_id=?, start_time=?, end_time=?
    WHERE id=?
  ");

  $stmt->bind_param(
    "iisiiisssi",
    $class_id,
    $section_id,
    $day_of_week,
    $period_number,
    $subject_id,
    $basket_group,
    $teacher_id,
    $start,
    $end,
    $id
  );

  $stmt->execute();

  $_SESSION['flash'] = [
  'type' => 'success',
  'title' => 'Updated Successfully!',
  'text' => 'Timetable entry updated.'
];
header('Location: ' . BASE_URL . 'admin/timetable.php');
exit;

}

/* ============================================================
   DELETE ENTRY
   ============================================================ */
if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    die('CSRF failed');
  }

  $id = (int)$_POST['id'];

  $stmt = $conn->prepare("DELETE FROM timetable WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

 $_SESSION['flash'] = [
  'type' => 'success',
  'title' => 'Deleted!',
  'text' => 'Timetable entry removed.'
];
header('Location: ' . BASE_URL . 'admin/timetable.php');
exit;

}

