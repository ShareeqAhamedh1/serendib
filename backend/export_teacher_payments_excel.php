<?php
require 'conn.php';
require 'helpers.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=teacher_payments_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

$search = trim($_GET['search'] ?? '');
$month = trim($_GET['month'] ?? '');
$method = trim($_GET['method'] ?? '');
$monthYear = $month ? date('M-Y', strtotime($month)) : '';

$where = "1=1";
$params = [];
$types = "";

if ($search !== '') {
  $where .= " AND (t.first_name LIKE ? OR t.last_name LIKE ? OR t.teacher_code LIKE ?)";
  $like = "%$search%";
  $params = array_merge($params, [$like, $like, $like]);
  $types .= "sss";
}

if ($monthYear !== '') {
  $where .= " AND tp.month_year = ?";
  $params[] = $monthYear;
  $types .= "s";
}

if ($method !== '') {
  $where .= " AND tp.method = ?";
  $params[] = $method;
  $types .= "s";
}

$q = "
SELECT tp.*, t.first_name, t.last_name, t.teacher_code, s.subject_name
FROM teacher_payments tp
JOIN teachers t ON tp.teacher_id = t.id
LEFT JOIN subjects s ON t.subject_id = s.id
WHERE $where
ORDER BY tp.payment_date DESC
";

$stmt = $conn->prepare($q);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();

echo "<table border='1'>
<tr style='background:#007bff; color:white; font-weight:bold;'>
  <th>#</th>
  <th>Teacher</th>
  <th>Subject</th>
  <th>Month</th>
  <th>Base Salary</th>
  <th>Bonus</th>
  <th>Deductions</th>
  <th>Net Paid</th>
  <th>Method</th>
  <th>Date</th>
</tr>";

$i = 1;
while ($r = $res->fetch_assoc()):
  $net = ($r['base_salary'] + $r['bonus']) - $r['deductions'];
  echo "<tr>
    <td>{$i}</td>
    <td>".esc($r['first_name'].' '.$r['last_name'])." (".esc($r['teacher_code']).")</td>
    <td>".esc($r['subject_name'] ?? '-')."</td>
    <td>".esc($r['month_year'])."</td>
    <td align='right'>".number_format($r['base_salary'],2)."</td>
    <td align='right'>".number_format($r['bonus'],2)."</td>
    <td align='right'>".number_format($r['deductions'],2)."</td>
    <td align='right'>".number_format($net,2)."</td>
    <td>".esc($r['method'])."</td>
    <td>".esc($r['payment_date'])."</td>
  </tr>";
  $i++;
endwhile;

echo "</table>";
exit;
