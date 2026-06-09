<?php
require 'conn.php';
require 'helpers.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Student_Report_Cards.xls");

$exam_id = (int)($_GET['exam_id'] ?? 0);
$class_id = (int)($_GET['class_id'] ?? 0);
$section_id = (int)($_GET['section_id'] ?? 0);

$where = "1=1";
if($exam_id) $where .= " AND em.exam_id=$exam_id";
if($class_id) $where .= " AND em.class_id=$class_id";
if($section_id) $where .= " AND em.section_id=$section_id";

$q = "
SELECT s.admission_no, s.first_name, s.last_name,
       c.class_name, sec.section_name, ex.exam_name,
       SUM(em.marks_obtained) AS total_marks,
       COUNT(em.subject_id) AS subjects_count,
       ROUND(AVG(em.marks_obtained),2) AS avg_marks,
       SUM(CASE WHEN em.status='Pass' THEN 1 ELSE 0 END) AS passed
FROM exam_marks em
JOIN students s ON em.student_id=s.id
JOIN classes c ON em.class_id=c.id
JOIN sections sec ON em.section_id=sec.id
JOIN exams ex ON em.exam_id=ex.id
WHERE $where
GROUP BY s.id
ORDER BY s.first_name
";

$res = $conn->query($q);

echo "<table border='1'>";
echo "<tr>
<th>Exam</th>
<th>Admission No</th>
<th>Student Name</th>
<th>Class</th>
<th>Section</th>
<th>Total Marks</th>
<th>Average</th>
<th>Status</th>
</tr>";

while($r = $res->fetch_assoc()){
  $result = ($r['passed'] == $r['subjects_count']) ? 'Pass' : 'Fail';
  echo "<tr>
    <td>".esc($r['exam_name'])."</td>
    <td>".esc($r['admission_no'])."</td>
    <td>".esc($r['first_name'].' '.$r['last_name'])."</td>
    <td>".esc($r['class_name'])."</td>
    <td>".esc($r['section_name'])."</td>
    <td>".esc($r['total_marks'])."</td>
    <td>".esc($r['avg_marks'])."</td>
    <td>$result</td>
  </tr>";
}
echo "</table>";
