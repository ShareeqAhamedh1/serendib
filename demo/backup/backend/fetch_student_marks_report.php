<?php
require 'conn.php';
require 'helpers.php';

$exam_id = (int)($_GET['exam_id'] ?? 0);
$class_id = (int)($_GET['class_id'] ?? 0);
$section_id = (int)($_GET['section_id'] ?? 0);
$subject_id = (int)($_GET['subject_id'] ?? 0);
$admission_no = trim($_GET['admission_no'] ?? '');

$where = "1=1";
if($exam_id) $where .= " AND em.exam_id=$exam_id";
if($class_id) $where .= " AND em.class_id=$class_id";
if($section_id) $where .= " AND em.section_id=$section_id";
if($subject_id) $where .= " AND em.subject_id=$subject_id";
if($admission_no !== '') $where .= " AND s.admission_no LIKE '%".$conn->real_escape_string($admission_no)."%'";

$q = "
SELECT s.admission_no, s.first_name, s.last_name,
       c.class_name, sec.section_name,
       ex.exam_name, sub.subject_name,
       em.marks_obtained, em.grade, em.status
FROM exam_marks em
JOIN students s ON em.student_id = s.id
JOIN classes c ON em.class_id = c.id
JOIN sections sec ON em.section_id = sec.id
JOIN subjects sub ON em.subject_id = sub.id
JOIN exams ex ON em.exam_id = ex.id
WHERE $where
ORDER BY s.first_name, sub.subject_name
";

$res = $conn->query($q);

if(!$res || $res->num_rows == 0) {
  echo "<p style='color:gray;'>No marks found for selected filters.</p>";
  exit;
}

echo "<table border='1' cellpadding='6' style='width:100%; border-collapse:collapse; background:#fff;'>";
echo "<thead style='background:#007bff; color:white;'>
<tr>
  <th>Admission No</th>
  <th>Student Name</th>
  <th>Class</th>
  <th>Section</th>
  <th>Exam</th>
  <th>Subject</th>
  <th>Marks</th>
  <th>Grade</th>
  <th>Status</th>
</tr>
</thead><tbody>";

while($r = $res->fetch_assoc()) {
  $statusColor = $r['status'] == 'Pass' ? 'green' : 'red';
  echo "<tr>
    <td>".esc($r['admission_no'])."</td>
    <td>".esc($r['first_name'].' '.$r['last_name'])."</td>
    <td>".esc($r['class_name'])."</td>
    <td>".esc($r['section_name'])."</td>
    <td>".esc($r['exam_name'])."</td>
    <td>".esc($r['subject_name'])."</td>
    <td>".esc($r['marks_obtained'])."</td>
    <td>".esc($r['grade'])."</td>
    <td style='color:$statusColor;'>".esc($r['status'])."</td>
  </tr>";
}
echo "</tbody></table>";
