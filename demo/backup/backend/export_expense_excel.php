<?php
require 'conn.php';
require 'helpers.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=expenses_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

$category_id = (int)($_GET['category_id'] ?? 0);
$method = trim($_GET['method'] ?? '');
$from = $_GET['from_date'] ?? '';
$to = $_GET['to_date'] ?? '';

$where = "1=1";
if ($category_id > 0) $where .= " AND e.category_id = $category_id";
if ($method !== '') $where .= " AND e.payment_method = '$method'";
if ($from !== '' && $to !== '') $where .= " AND e.expense_date BETWEEN '$from' AND '$to'";
elseif ($from !== '') $where .= " AND e.expense_date >= '$from'";
elseif ($to !== '') $where .= " AND e.expense_date <= '$to'";

$res = $conn->query("
  SELECT e.*, c.name AS category_name
  FROM expenses e
  LEFT JOIN expense_categories c ON e.category_id = c.id
  WHERE $where
  ORDER BY e.expense_date DESC
");

echo "<table border='1'>";
echo "<tr><th colspan='6' style='background:#007bff;color:white;'>Expense Report - " . date('d M Y') . "</th></tr>";
echo "<tr><th>Date</th><th>Title</th><th>Category</th><th>Amount</th><th>Method</th><th>Remarks</th></tr>";

$total = 0;
while ($r = $res->fetch_assoc()) {
  $total += $r['amount'];
  echo "<tr>
    <td>".esc($r['expense_date'])."</td>
    <td>".esc($r['title'])."</td>
    <td>".esc($r['category_name'])."</td>
    <td align='right'>".number_format($r['amount'],2)."</td>
    <td>".esc($r['payment_method'])."</td>
    <td>".esc($r['remarks'])."</td>
  </tr>";
}
echo "<tr style='font-weight:bold;'><td colspan='3' align='right'>Total:</td><td align='right'>".number_format($total,2)."</td><td colspan='2'></td></tr>";
echo "</table>";
