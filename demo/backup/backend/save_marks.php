<?php
require 'conn.php';
require 'helpers.php';

if(!verify_csrf($_POST['csrf_token'] ?? '')) die('CSRF failed');

$exam_id = (int)$_POST['exam_id'];
$class_id = (int)$_POST['class_id'];
$section_id = (int)$_POST['section_id'];
$subject_id = (int)$_POST['subject_id'];
$marks = $_POST['marks'] ?? [];

// Get max & pass marks
$q = $conn->prepare("SELECT max_marks, pass_marks FROM exam_subjects WHERE exam_id=? AND class_id=? AND subject_id=?");
$q->bind_param("iii",$exam_id,$class_id,$subject_id);
$q->execute();
$limit = $q->get_result()->fetch_assoc();
$max = $limit['max_marks'] ?? 100;
$pass = $limit['pass_marks'] ?? 35;

foreach($marks as $student_id => $m){
  $m = (float)$m;
  $grade = ($m >= 75 ? 'A' : ($m >= 60 ? 'B' : ($m >= 45 ? 'C' : ($m >= 35 ? 'D' : 'F'))));
  $status = ($m >= $pass) ? 'Pass' : 'Fail';

  $check = $conn->prepare("SELECT id FROM exam_marks WHERE exam_id=? AND subject_id=? AND student_id=?");
  $check->bind_param("iii",$exam_id,$subject_id,$student_id);
  $check->execute();
  $exists = $check->get_result()->fetch_assoc();

  if($exists){
    $upd = $conn->prepare("UPDATE exam_marks SET marks_obtained=?, grade=?, status=? WHERE id=?");
    $upd->bind_param("dssi",$m,$grade,$status,$exists['id']);
    $upd->execute();
  } else {
    $ins = $conn->prepare("INSERT INTO exam_marks (exam_id,class_id,section_id,student_id,subject_id,marks_obtained,grade,status) VALUES (?,?,?,?,?,?,?,?)");
    $ins->bind_param("iiiiddss",$exam_id,$class_id,$section_id,$student_id,$subject_id,$m,$grade,$status);
    $ins->execute();
  }
}

header("Location: ../admin/enter-marks.php?saved=1");
exit;
