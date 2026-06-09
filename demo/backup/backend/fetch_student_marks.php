<?php
require 'conn.php';
require 'helpers.php';

$exam_id = (int)($_GET['exam_id'] ?? 0);
$student_id = (int)($_GET['student_id'] ?? 0);

if(!$exam_id || !$student_id){
  echo "<p style='color:red;'>Invalid request.</p>";
  exit;
}

$q = "
SELECT sub.subject_name, em.marks_obtained, em.grade, em.status
FROM exam_marks em
JOIN subjects sub ON em.subject_id=sub.id
WHERE em.exam_id=$exam_id AND em.student_id=$student_id
ORDER BY sub.subject_name
";

$res = $conn->query($q);

if(!$res || $res->num_rows == 0){
  echo "<p>No marks found for this student.</p>";
  exit;
}

$total = 0; $count = 0;
echo "<table border='1' cellpadding='6' style='width:100%; border-collapse:collapse; background:#fff; margin-top:10px;'>";
echo "<thead style='background:#444; color:white;'>
<tr>
  <th>Subject</th>
  <th>Marks</th>
  <th>Grade</th>
  <th>Status</th>
</tr></thead><tbody>";

while($r = $res->fetch_assoc()){
  $color = $r['status'] == 'Pass' ? 'green' : 'red';
  echo "<tr>
    <td>".esc($r['subject_name'])."</td>
    <td>".esc($r['marks_obtained'])."</td>
    <td>".esc($r['grade'])."</td>
    <td style='color:$color;'>".esc($r['status'])."</td>
  </tr>";
  $total += $r['marks_obtained'];
  $count++;
}
$avg = $count ? round($total / $count, 2) : 0;
echo "</tbody></table><br>
<p><b>Total Marks:</b> $total &nbsp;&nbsp; <b>Average:</b> $avg</p>";
