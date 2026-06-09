<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';
?>

<h2>📄 Teacher Salary Report</h2>
<p>View all teacher salary payments, filter by month, payment method, or teacher, and export as Excel.</p>

<div style="background:#f9f9f9; padding:15px; border-radius:10px; margin-bottom:20px;">
  <form method="get">
    <label>Teacher:</label>
    <input type="text" name="search" placeholder="Name or Code" value="<?= $_GET['search'] ?? '' ?>" style="margin-right:10px;">
    <label>Month:</label>
    <input type="month" name="month" value="<?= $_GET['month'] ?? date('Y-m') ?>" style="margin-right:10px;">
    <label>Method:</label>
    <select name="method" style="margin-right:10px;">
      <option value="">All</option>
      <option value="Cash">Cash</option>
      <option value="Bank Transfer">Bank Transfer</option>
      <option value="Cheque">Cheque</option>
    </select>
    <button type="submit">🔍 Filter</button>
    <a href="teacher-payments-report.php" style="margin-left:10px;">🔄 Reset</a>
    <a href="<?= BASE_URL ?>backend/export_teacher_payments_excel.php?<?= http_build_query($_GET) ?>" 
       style="margin-left:10px;">📗 Export Excel</a>
  </form>
</div>

<?php
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

if ($res->num_rows == 0) {
  echo "<p style='color:gray;'>No payment records found.</p>";
  include 'partials/footer.php';
  exit;
}

$totalSalary = 0;
$totalBonus = 0;
$totalDeduction = 0;
$totalNet = 0;

echo "<table border='1' cellpadding='8' cellspacing='0' style='width:100%; border-collapse:collapse; background:#fff;'>
<thead style='background:#007bff; color:white;'>
<tr>
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
</tr>
</thead><tbody>";

$i = 1;
while ($row = $res->fetch_assoc()):
  $net = ($row['base_salary'] + $row['bonus']) - $row['deductions'];
  $totalSalary += $row['base_salary'];
  $totalBonus += $row['bonus'];
  $totalDeduction += $row['deductions'];
  $totalNet += $net;

  echo "<tr>
    <td>{$i}</td>
    <td>".esc($row['first_name'].' '.$row['last_name'])."<br><small>".esc($row['teacher_code'])."</small></td>
    <td>".esc($row['subject_name'] ?? '-')."</td>
    <td>".esc($row['month_year'])."</td>
    <td align='right'>".number_format($row['base_salary'],2)."</td>
    <td align='right'>".number_format($row['bonus'],2)."</td>
    <td align='right'>".number_format($row['deductions'],2)."</td>
    <td align='right'>".number_format($net,2)."</td>
    <td>".esc($row['method'])."</td>
    <td>".esc($row['payment_date'])."</td>
  </tr>";
  $i++;
endwhile;

echo "<tr style='font-weight:bold; background:#f0f0f0;'>
  <td colspan='4' align='right'>TOTALS:</td>
  <td align='right'>".number_format($totalSalary,2)."</td>
  <td align='right'>".number_format($totalBonus,2)."</td>
  <td align='right'>".number_format($totalDeduction,2)."</td>
  <td align='right'>".number_format($totalNet,2)."</td>
  <td colspan='2'></td>
</tr>";
echo "</tbody></table>";

include 'partials/footer.php';
?>
