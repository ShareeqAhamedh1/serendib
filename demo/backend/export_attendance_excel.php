<?php
require 'conn.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=attendance_report_" . date('Ymd_His') . ".xls");

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

echo "<table border='1'>";
echo "<tr><th>Type</th><th>Name</th><th>Code</th><th>Class</th><th>Section</th><th>Date</th><th>Time In</th><th>Status</th></tr>";

while ($r = $res->fetch_assoc()) {
  $name = htmlspecialchars($r['first_name'] . ' ' . $r['last_name']);
  echo "<tr>
          <td>" . ucfirst($r['entity_type']) . "</td>
          <td>$name</td>
          <td>" . htmlspecialchars($r['code']) . "</td>
          <td>" . htmlspecialchars($r['class_name'] ?? '-') . "</td>
          <td>" . htmlspecialchars($r['section_name'] ?? '-') . "</td>
          <td>{$r['date']}</td>
          <td>{$r['time_in']}</td>
          <td>{$r['status']}</td>
        </tr>";
}
echo "</table>";
