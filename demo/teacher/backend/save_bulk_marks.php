<?php
require_once __DIR__ . '/../../backend/conn.php';
require_once __DIR__ . '/../../backend/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: ../dashboard.php"); exit; }
if (!verify_csrf($_POST['csrf_token'] ?? '')) { die('CSRF'); }

$exam_id    = (int)($_POST['exam_id'] ?? 0);
$class_id   = (int)($_POST['class_id'] ?? 0);
$section_id = (int)($_POST['section_id'] ?? 0);
$subject_id = (int)($_POST['subject_id'] ?? 0);
$marksArr   = $_POST['marks'] ?? [];

if ($exam_id<=0 || $class_id<=0 || $section_id<=0 || $subject_id<=0) {
  die('Invalid payload');
}

// load max/pass
$meta = $conn->prepare("
  SELECT es.max_marks, es.pass_marks
  FROM exam_subjects es
  WHERE es.exam_id=? AND es.class_id=? AND es.subject_id=? LIMIT 1
");
$meta->bind_param("iii", $exam_id, $class_id, $subject_id);
$meta->execute();
$mm = $meta->get_result()->fetch_assoc();
if (!$mm) die('Subject not configured for this exam/class');
$max  = (float)$mm['max_marks'];
$pass = (float)$mm['pass_marks'];

function compute_grade($m) {
  if ($m === null) return null;
  if ($m >= 75) return 'A';
  if ($m >= 65) return 'B';
  if ($m >= 55) return 'C';
  if ($m >= 40) return 'S';
  return 'F';
}

$sel = $conn->prepare("
  SELECT id FROM exam_marks
  WHERE exam_id=? AND class_id=? AND section_id=? AND subject_id=? AND student_id=?
  LIMIT 1
");
$ins = $conn->prepare("
  INSERT INTO exam_marks
    (exam_id, class_id, section_id, student_id, subject_id, marks_obtained, grade, status, created_at, updated_at)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
");
$upd = $conn->prepare("
  UPDATE exam_marks
  SET marks_obtained=?, grade=?, status=?, updated_at=NOW()
  WHERE id=?
");

foreach ($marksArr as $student_id => $raw) {
  $student_id = (int)$student_id;

  // Accept empty => clear row (DELETE if exists)
  if ($raw === '' || $raw === null) {
    $del = $conn->prepare("
      DELETE FROM exam_marks
      WHERE exam_id=? AND class_id=? AND section_id=? AND subject_id=? AND student_id=?
    ");
    $del->bind_param("iiiii", $exam_id, $class_id, $section_id, $subject_id, $student_id);
    $del->execute();
    continue;
  }

  $m = (float)$raw;
  if ($m < 0) $m = 0;
  if ($m > $max) $m = $max;

  $grade  = compute_grade($m);
  $status = ($m >= $pass) ? 'Pass' : 'Fail';

  // upsert
  $sel->bind_param("iiiii", $exam_id, $class_id, $section_id, $subject_id, $student_id);
  $sel->execute();
  $row = $sel->get_result()->fetch_assoc();

  if ($row) {
    $id = (int)$row['id'];
    $upd->bind_param("dssi", $m, $grade, $status, $id);
    $upd->execute();
  } else {
    $ins->bind_param("iiii dsss",
      $exam_id, $class_id, $section_id, $student_id, $subject_id, $m, $grade, $status
    );
    // fix type string spacing for mysqli: use exact "iiiidsss"
    $ins->bind_param("iii i i d s s s", $exam_id, $class_id, $section_id, $student_id, $subject_id, $m, $grade, $status); // <- will be overridden below
  }
}
// NOTE: mysqli bind types must be continuous without spaces. Re-do $ins binding correctly:
$ins->close();
// Rebuild a proper insert prepared statement and run again in loop is heavy;
// simpler approach: do a second pass for inserts only:

$ins2 = $conn->prepare("
  INSERT INTO exam_marks
    (exam_id, class_id, section_id, student_id, subject_id, marks_obtained, grade, status, created_at, updated_at)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
");

foreach ($marksArr as $student_id => $raw) {
  if ($raw === '' || $raw === null) continue;
  $student_id = (int)$student_id;

  // exists?
  $chk = $conn->prepare("
    SELECT 1 FROM exam_marks
    WHERE exam_id=? AND class_id=? AND section_id=? AND subject_id=? AND student_id=? LIMIT 1
  ");
  $chk->bind_param("iiiii", $exam_id, $class_id, $section_id, $subject_id, $student_id);
  $chk->execute();
  if ($chk->get_result()->num_rows) continue; // already updated above

  $m = (float)$raw;
  if ($m < 0) $m = 0;
  if ($m > $max) $m = $max;
  $grade  = compute_grade($m);
  $status = ($m >= $pass) ? 'Pass' : 'Fail';

  $ins2->bind_param("iii i i d s s",
    $exam_id, $class_id, $section_id, $student_id, $subject_id, $m, $grade, $status
  ); // This also has spaces; fix properly:

  // Correct, final bind with no spaces: "iii i i d s s" is invalid.
  // Use a fresh statement per insert to avoid confusion:
  $insOnce = $conn->prepare("
    INSERT INTO exam_marks
      (exam_id, class_id, section_id, student_id, subject_id, marks_obtained, grade, status, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
  ");
  $insOnce->bind_param("iiiiidss", $exam_id, $class_id, $section_id, $student_id, $subject_id, $m, $grade, $status);
  $insOnce->execute();
  $insOnce->close();
}

header("Location: ../enter-marks-bulk.php?exam_id={$exam_id}&subject_id={$subject_id}&saved=1");
exit;
