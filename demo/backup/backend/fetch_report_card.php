<?php
require 'conn.php';
require 'helpers.php';

$exam_id = (int)($_GET['exam_id'] ?? 0);
$class_id = (int)($_GET['class_id'] ?? 0);
$section_id = (int)($_GET['section_id'] ?? 0);

$where = "1=1";
if($exam_id) $where .= " AND em.exam_id=$exam_id";
if($class_id) $where .= " AND em.class_id=$class_id";
if($section_id) $where .= " AND em.section_id=$section_id";

$q = "
SELECT 
  em.exam_id,
  ex.exam_name,
  s.id AS student_id,
  s.admission_no,
  s.first_name,
  s.last_name,
  c.class_name,
  sec.section_name,
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
GROUP BY em.exam_id, s.id
ORDER BY ex.exam_name, s.first_name
";

$res = $conn->query($q);

if(!$res || $res->num_rows == 0){
  echo "<p style='color:gray;'>No records found.</p>";
  exit;
}

echo "<table border='1' cellpadding='6' style='width:100%; border-collapse:collapse; background:#fff;'>";
echo "<thead style='background:#007bff; color:white;'>
<tr>
  <th>Exam</th>
  <th>Admission No</th>
  <th>Student Name</th>
  <th>Class</th>
  <th>Section</th>
  <th>Total Marks</th>
  <th>Average</th>
  <th>Status</th>
  <th>Action</th>
</tr></thead><tbody>";

while($r = $res->fetch_assoc()){
  $result = ($r['passed'] == $r['subjects_count']) ? 'Pass' : 'Fail';
  $color = $result == 'Pass' ? 'green' : 'red';

  // ✅ Ensure we always pass the real exam_id from the row
  $link = BASE_URL . "admin/student-report-view.php?student_id={$r['student_id']}&exam_id={$r['exam_id']}";

  echo "<tr>
    <td>".esc($r['exam_name'])."</td>
    <td>".esc($r['admission_no'])."</td>
    <td>".esc($r['first_name'].' '.$r['last_name'])."</td>
    <td>".esc($r['class_name'])."</td>
    <td>".esc($r['section_name'])."</td>
    <td>".esc($r['total_marks'])."</td>
    <td>".esc($r['avg_marks'])."</td>
    <td style='color:$color;'>$result</td>
    <td>
      <a href='$link' target='_blank' 
         style='padding:6px 10px; background:#28a745; color:white; text-decoration:none; border-radius:4px;'>
         View Report
      </a>
    </td>
  </tr>";
}
echo "</tbody></table>";
