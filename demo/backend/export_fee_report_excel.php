<?php
require 'conn.php';
require 'helpers.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=fee_report_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

$search = trim($_GET['search'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');

$where = "1=1";
$params = [];

if ($search !== '') {
  $where .= " AND (s.admission_no LIKE ? OR s.first_name LIKE ? OR s.last_name LIKE ?)";
  $like = "%$search%";
  $params = [$like, $like, $like];
}

// Fetch students
$q = "
  SELECT DISTINCT s.id AS student_id, s.admission_no, s.first_name, s.last_name, c.class_name
  FROM students s
  LEFT JOIN classes c ON s.class_id=c.id
  LEFT JOIN student_fees sf ON s.id = sf.student_id
  WHERE $where
  ORDER BY c.class_name, s.first_name
";
$stmt = $conn->prepare($q);
if ($search !== '') $stmt->bind_param("sss", ...$params);
$stmt->execute();
$students = $stmt->get_result();

// Start table
echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
echo "<tr><td colspan='11' align='center' style='font-weight:bold; font-size:18px; background:#007bff; color:white;'>School ERP - Detailed Fee Report (" . date('d M Y') . ")</td></tr>";
echo "<tr><td colspan='11'>&nbsp;</td></tr>";

$totalAmount = $totalPaid = $totalBalance = 0;
$today = date('Y-m-d');

while ($s = $students->fetch_assoc()) {
  $student_id = $s['student_id'];

  // Fetch fees
  $fees = $conn->query("
    SELECT sf.*, ft.name AS fee_name
    FROM student_fees sf
    JOIN fee_types ft ON sf.fee_type_id = ft.id
    WHERE sf.student_id = $student_id
    ORDER BY sf.due_date
  ");

  if ($statusFilter === 'No Fees' && $fees->num_rows > 0) continue;
  if ($fees->num_rows === 0 && $statusFilter !== 'No Fees') continue;

  // --- Student Header Section ---
  echo "<tr style='background:#004080; color:white; font-weight:bold;'>
          <td colspan='11'>
            Admission No: ".esc($s['admission_no'])." &nbsp;&nbsp;|&nbsp;&nbsp;
            Student: ".esc($s['first_name'].' '.$s['last_name'])." &nbsp;&nbsp;|&nbsp;&nbsp;
            Class: ".esc($s['class_name'])."
          </td>
        </tr>";

  // Fee table header
  echo "<tr style='background:#007bff; color:white; font-weight:bold;'>
          <th>Fee Type</th>
          <th>Total Fee</th>
          <th>Status</th>
          <th>Due Date</th>
          <th>Payment Date</th>
          <th>Payment Method</th>
          <th>Paid Amount</th>
          <th>Balance</th>
        </tr>";

  $studentTotal = $studentPaid = $studentBalance = 0;

  while ($f = $fees->fetch_assoc()) {
    $fee_id = $f['id'];
    $paidTotal = 0;

    $pRes = $conn->query("
      SELECT paid_amount, payment_date, method 
      FROM fee_payments 
      WHERE student_fee_id=$fee_id 
      ORDER BY payment_date
    ");

    if ($pRes && $pRes->num_rows > 0) {
      while ($p = $pRes->fetch_assoc()) {
        $paidTotal += (float)$p['paid_amount'];
        $balance = max(0, $f['amount'] - $paidTotal);

        $status = $balance <= 0 ? 'Paid' : ($paidTotal > 0 ? 'Partial' : 'Pending');
        $color = $status === 'Paid' ? 'green' : ($status === 'Partial' ? 'orange' : 'red');

        // 🔴 Overdue highlight
        $rowStyle = ($f['due_date'] < $today && $balance > 0)
          ? "style='background:#ffe6e6;'"   // light red
          : "";

        echo "<tr $rowStyle>
                <td>".esc($f['fee_name'])."</td>
                <td align='right'>".number_format($f['amount'],2)."</td>
                <td style='color:$color;'>$status</td>
                <td>".esc($f['due_date'])."</td>
                <td>".date('d-m-Y', strtotime($p['payment_date']))."</td>
                <td>".esc(ucfirst($p['method']))."</td>
                <td align='right'>".number_format($p['paid_amount'],2)."</td>
                <td align='right'>".number_format($balance,2)."</td>
              </tr>";
      }
    } else {
      // No payments yet
      $balance = $f['amount'];
      $status = 'Pending';
      $rowStyle = ($f['due_date'] < $today) ? "style='background:#ffe6e6;'" : ""; // overdue highlight

      echo "<tr $rowStyle>
              <td>".esc($f['fee_name'])."</td>
              <td align='right'>".number_format($f['amount'],2)."</td>
              <td style='color:red;'>$status</td>
              <td>".esc($f['due_date'])."</td>
              <td>-</td>
              <td>-</td>
              <td align='right'>0.00</td>
              <td align='right'>".number_format($balance,2)."</td>
            </tr>";
    }

    $studentTotal += $f['amount'];
    $studentPaid += $paidTotal;
    $studentBalance += max(0, $f['amount'] - $paidTotal);
    $totalAmount += $f['amount'];
    $totalPaid += $paidTotal;
    $totalBalance += max(0, $f['amount'] - $paidTotal);
  }

  // --- Student Totals Row ---
  echo "<tr style='background:#e9f5ff; font-weight:bold;'>
          <td align='right'>Total for ".esc($s['first_name']).":</td>
          <td align='right'>".number_format($studentTotal,2)."</td>
          <td colspan='3'></td>
          <td align='right'>Total Paid:</td>
          <td align='right'>".number_format($studentPaid,2)."</td>
          <td align='right'>".number_format($studentBalance,2)."</td>
        </tr>";
  echo "<tr><td colspan='11'>&nbsp;</td></tr>";
}

// --- Grand Totals ---
echo "<tr style='background:#007bff; color:white; font-weight:bold;'>
        <td align='right'>Grand Totals:</td>
        <td align='right'>".number_format($totalAmount,2)."</td>
        <td colspan='4'></td>
        <td align='right'>".number_format($totalPaid,2)."</td>
        <td align='right'>".number_format($totalBalance,2)."</td>
      </tr>";

echo "</table>";
exit;
