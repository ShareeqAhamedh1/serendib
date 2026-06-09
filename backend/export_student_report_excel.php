<?php
require 'conn.php';
require 'helpers.php';

$student_id = (int)($_GET['student_id'] ?? 0);
$exam_id = (int)($_GET['exam_id'] ?? 0);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Student_Report_{$student_id}_Exam_{$exam_id}.xls");

$q = $conn->query("
  SELECT s.admission_no, s.first_name, s.last_name, c.class_name, sec.section_name, ex.exam_name
  FROM students s
  JOIN classes c ON s.class_id=c.id
  JOIN sections sec ON s.section_id=sec.id
  JOIN exams ex
  WHERE s.id=$student_id AND ex.id=$exam_id
");
$info = $q->fetch_assoc();

$res = $conn->query("
  SELECT sub.subject_name, em.marks_obtained, em.grade, em.status
  FROM exam_marks em
  JOIN subjects sub ON em.subject_id=sub.id
  WHERE em.exam_id=$exam_id AND em.student_id=$student_id
  ORDER BY sub.subject_name
");

echo "<h3>Exam Report - ".esc($info['exam_name'])."</h3>";
echo "<p>Student: ".esc($info['first_name'].' '.$info['last_name'])." (".esc($info['admission_no']).")</p>";
echo "<p>Class: ".esc($info['class_name'])." - ".esc($info['section_name'])."</p>";

echo "<table border='1'>";
echo "<tr><th>Subject</th><th>Marks</th><th>Grade</th><th>Status</th></tr>";

$total = 0; $count = 0;
while($r = $res->fetch_assoc()){
  $total += $r['marks_obtained']; $count++;
  echo "<tr>
          <td>".esc($r['subject_name'])."</td>
          <td>".esc($r['marks_obtained'])."</td>
          <td>".esc($r['grade'])."</td>
          <td>".esc($r['status'])."</td>
        </tr>";
}
$avg = $count ? round($total / $count, 2) : 0;
echo "</table><br><b>Total:</b> $total | <b>Average:</b> $avg";
