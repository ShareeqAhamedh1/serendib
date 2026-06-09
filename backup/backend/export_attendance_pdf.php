<?php
require 'conn.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Make sure Dompdf is installed

use Dompdf\Dompdf;

$date = $_GET['date'] ?? date('Y-m-d');
$type = $_GET['type'] ?? '';
$class_id = $_GET['class_id'] ?? '';
$section_id = $_GET['section_id'] ?? '';

$where = ["a.date = '$date'"];
if ($type) $where[] = "a.entity_type = '$type'";
if ($class_id) $where[] = "s.class_id = " . (int)$class_id;
if ($section_id) $where[] = "s.section_id = " . (int)$section_id;

$whereSql = implode(' AND ', $where);

$q = "
  SELECT a.entity_type, a.date, a.time_in, a.status,
         CASE 
           WHEN a.entity_type='student' THEN s.first_name
           ELSE t.first_name
         END AS first_name,
         CASE 
           WHEN a.entity_type='student' THEN s.last_name
           ELSE t.last_name
         END AS last_name,
         CASE 
           WHEN a.entity_type='student' THEN s.admission_no
           ELSE t.teacher_code
         END AS code,
         c.class_name, sec.section_name
  FROM attendance a
  LEFT JOIN students s ON a.entity_type='student' AND a.entity_id=s.id
  LEFT JOIN teachers t ON a.entity_type='teacher' AND a.entity_id=t.id
  LEFT JOIN classes c ON s.class_id=c.id
  LEFT JOIN sections sec ON s.section_id=sec.id
  WHERE $whereSql
  ORDER BY a.entity_type, a.time_in
";

$res = $conn->query($q);

$html = '<h3 style="text-align:center;">Attendance Report (' . $date . ')</h3>';
$html .= '<table border="1" cellpadding="6" style="width:100%; border-collapse:collapse;">
<thead style="background:#007bff; color:white;">
<tr><th>Type</th><th>Name</th><th>Code</th><th>Class</th><th>Section</th><th>Time In</th><th>Status</th></tr>
</thead><tbody>';

while ($r = $res->fetch_assoc()) {
  $html .= '<tr>
    <td>' . ucfirst($r['entity_type']) . '</td>
    <td>' . htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) . '</td>
    <td>' . htmlspecialchars($r['code']) . '</td>
    <td>' . htmlspecialchars($r['class_name'] ?? '-') . '</td>
    <td>' . htmlspecialchars($r['section_name'] ?? '-') . '</td>
    <td>' . htmlspecialchars($r['time_in']) . '</td>
    <td>' . ucfirst($r['status']) . '</td>
  </tr>';
}
$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("attendance_report_" . date('Ymd_His') . ".pdf");
