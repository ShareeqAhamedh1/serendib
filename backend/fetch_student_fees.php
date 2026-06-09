<?php
require 'conn.php';
require 'helpers.php';

$limit = (int)($_GET['limit'] ?? 10);
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$search = trim($_GET['search'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');

$where = "1=1";
$params = [];

if ($search !== '') {
  $where .= " AND (s.admission_no LIKE ? OR s.first_name LIKE ? OR s.last_name LIKE ?)";
  $like = "%$search%";
  $params = [$like, $like, $like];
}

// Count total students
$qCount = "
  SELECT COUNT(DISTINCT s.id) AS total 
  FROM students s 
  LEFT JOIN student_fees sf ON s.id = sf.student_id 
  WHERE $where
";
$stmt = $conn->prepare($qCount);
if ($search !== '') $stmt->bind_param("sss", ...$params);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
$totalPages = max(1, ceil($total / $limit));

// Fetch students
$q = "
  SELECT DISTINCT s.id, s.admission_no, s.first_name, s.last_name, c.class_name
  FROM students s
  LEFT JOIN classes c ON s.class_id=c.id
  LEFT JOIN student_fees sf ON s.id = sf.student_id
  WHERE $where
  ORDER BY s.first_name ASC
  LIMIT $limit OFFSET $offset
";
$stmt = $conn->prepare($q);
if ($search !== '') $stmt->bind_param("sss", ...$params);
$stmt->execute();
$students = $stmt->get_result();

if ($students->num_rows == 0) {
  echo "<p style='color:gray;'>No students found.</p><!--PAGE_SPLIT--><!--PAGE_SPLIT-->";
  exit;
}

$totalAmount = 0;
$totalPaid = 0;
$totalBalance = 0;

ob_start();

while ($s = $students->fetch_assoc()):
  $student_id = $s['id'];

  // Fetch assigned fees
  $fees = $conn->query("
    SELECT sf.*, ft.name AS fee_name
    FROM student_fees sf
    JOIN fee_types ft ON sf.fee_type_id = ft.id
    WHERE sf.student_id = $student_id
    ORDER BY sf.due_date
  ");

  if ($statusFilter === 'No Fees' && $fees->num_rows > 0) continue;
  if ($statusFilter !== 'No Fees' && $fees->num_rows === 0) {
    echo "<div style='margin-bottom:15px; background:#fff; border-radius:8px; padding:10px;'>
            <h3>".esc($s['first_name'].' '.$s['last_name'])." (".esc($s['admission_no']).")</h3>
            <p style='color:gray;'>No fees assigned.</p>
          </div>";
    continue;
  }

  echo "<div style='margin-bottom:25px; background:#fff; border-radius:10px; box-shadow:0 0 5px rgba(0,0,0,0.1); padding:15px;'>";
  echo "<h3>".esc($s['first_name'].' '.$s['last_name'])." (".esc($s['admission_no']).") — ".esc($s['class_name'])."</h3>";
echo "
<button 
  type='button' 
  onclick='toggleAllPayments()' 
  id='toggleAllBtn'
  style='margin-bottom:10px; padding:6px 12px;'>
  ⬇️ View All Payments
</button>
";

  echo "<table border='1' cellpadding='6' style='width:100%; border-collapse:collapse;'>
        <thead style='background:#007bff; color:white;'>
          <tr>
            <th>Fee Type</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Paid</th>
            <th>Balance</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>";

  while ($f = $fees->fetch_assoc()):
    $fee_id = $f['id'];
    $pRes = $conn->query("SELECT SUM(paid_amount) AS total_paid FROM fee_payments WHERE student_fee_id=$fee_id");
    $paid = (float)($pRes->fetch_assoc()['total_paid'] ?? 0);
    $balance = $f['amount'] - $paid;

    $status = $balance <= 0 ? 'Paid' : ($paid > 0 ? 'Partial' : 'Pending');
    if ($statusFilter && $statusFilter !== 'No Fees' && strcasecmp($statusFilter, $status) !== 0) continue;

    $statusColor = $status === 'Paid' ? 'green' : ($status === 'Partial' ? 'orange' : 'red');
    $placeholder = $status === 'Partial' ? 'Remaining: '.number_format($balance,2) : 'Amount';

    $totalAmount += $f['amount'];
    $totalPaid += $paid;
    $totalBalance += max(0, $balance);

    echo "<tr>
            <td>".esc($f['fee_name'])."</td>
            <td>".number_format($f['amount'],2)."</td>
            <td style='color:$statusColor;'>$status</td>
            <td>".esc($f['due_date'])."</td>
            <td>".number_format($paid,2)."</td>
            <td>".number_format(max(0,$balance),2)."</td>
            <td>";

    if ($status === 'Pending' || $status === 'Partial') {
      echo "
      <form class='paymentForm' data-id='$fee_id' style='display:inline-block;'>
        <input type='hidden' name='csrf_token' value='{$_SESSION['csrf_token']}'>
        <input type='hidden' name='student_fee_id' value='$fee_id'>
        <input type='number' name='amount' step='0.01' min='0.01' max='$balance' placeholder='$placeholder' required>
        <select name='method'>
          <option value='Cash'>Cash</option>
          <option value='Card'>Card</option>
          <option value='Bank Transfer'>Bank Transfer</option>
          <option value='Online'>Online</option>
        </select>
        <input type='text' name='remarks' placeholder='Remarks' style='width:120px;'>
        <button type='submit'>💵 Pay</button>
      </form>";
    } else {
      echo "<span style='color:green;font-weight:bold;'>✅ Paid</span>";
    }

    echo "</td></tr>";

    // ✅ Display payment history with receipt links
    $pDetails = $conn->query("SELECT id, paid_amount, payment_date, method FROM fee_payments WHERE student_fee_id=$fee_id ORDER BY payment_date ASC");
if ($pDetails && $pDetails->num_rows > 0) {
  echo "<tr>
          <td colspan='7'>
            <div class='payment-history' style='display:none;'>
              <b>Payment History:</b><br>";

      echo "<table border='1' style='width:95%; margin:8px auto; border-collapse:collapse; background:#f9f9f9;'>";
      echo "<tr style='background:#eee; font-weight:bold;'>
              <td>Date</td><td>Amount</td><td>Method</td><td>Receipt</td>
            </tr>";
      while ($p = $pDetails->fetch_assoc()) {
        echo "<tr>
                <td>".date('d-M-Y', strtotime($p['payment_date']))."</td>
                <td>".number_format($p['paid_amount'],2)."</td>
                <td>".esc($p['method'])."</td>
                <td><a href='".BASE_URL."admin/fee-receipt.php?payment_id={$p['id']}' target='_blank'>🧾 View</a></td>
              </tr>";
      }
      echo "</table></div></td></tr>";
    }

  endwhile;

  echo "</tbody></table></div>";
endwhile;

$output = ob_get_clean();
echo $output;

// --- Pagination ---
echo "<!--PAGE_SPLIT-->";
if ($totalPages > 1) {
  echo "<div>";
  for ($i = 1; $i <= $totalPages; $i++) {
    $active = $i === $page ? 'font-weight:bold; background:#007bff; color:white; padding:4px 8px; border-radius:4px;' : 'padding:4px 8px;';
    echo "<a href='#' class='page-link' data-page='$i' style='margin:2px; text-decoration:none; $active'>$i</a>";
  }
  echo "</div>";
}

// --- Summary ---
echo "<!--PAGE_SPLIT-->";
echo "💰 Total Fees: ".number_format($totalAmount,2). 
     " | 🟢 Total Paid: ".number_format($totalPaid,2).
     " | 🔴 Balance: ".number_format($totalBalance,2);
