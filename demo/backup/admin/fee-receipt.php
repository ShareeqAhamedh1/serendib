<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$payment_id = (int)($_GET['payment_id'] ?? 0);
if (!$payment_id) {
  echo "<p style='color:red;'>Invalid receipt request.</p>";
  include 'partials/footer.php';
  exit;
}

// Fetch payment + student info
$q = $conn->prepare("
  SELECT 
    fp.id AS payment_id, fp.paid_amount, fp.payment_date, fp.method,
    sf.amount AS total_fee, sf.due_date, sf.term,
    ft.name AS fee_type,
    s.first_name, s.last_name, s.admission_no, c.class_name
  FROM fee_payments fp
  JOIN student_fees sf ON fp.student_fee_id = sf.id
  JOIN fee_types ft ON sf.fee_type_id = ft.id
  JOIN students s ON sf.student_id = s.id
  LEFT JOIN classes c ON s.class_id = c.id
  WHERE fp.id = ?
");
$q->bind_param("i", $payment_id);
$q->execute();
$receipt = $q->get_result()->fetch_assoc();

if (!$receipt) {
  echo "<p style='color:red;'>Receipt not found.</p>";
  include 'partials/footer.php';
  exit;
}

$receipt_no = "RCPT-" . str_pad($receipt['payment_id'], 5, '0', STR_PAD_LEFT);
?>
<style>
  .receipt-container {
    max-width: 700px;
    margin: 30px auto;
    border: 1px solid #ccc;
    padding: 25px;
    background: #fff;
    border-radius: 10px;
    font-family: Arial, sans-serif;
  }
  .receipt-header {
    text-align: center;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
    margin-bottom: 20px;
  }
  .receipt-header h2 { color: #007bff; margin: 0; }
  .receipt-details p { margin: 5px 0; }
  .fee-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
  .fee-table th, .fee-table td {
    border: 1px solid #ddd;
    padding: 8px;
  }
  .fee-table th { background: #007bff; color: white; }
  .print-btn {
    margin-top: 20px;
    background: #28a745;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
</style>

<div class="receipt-container" id="receiptContent">
  <div class="receipt-header">
    <h2>🏫 Serendib School</h2>
    <p><b>Official Fee Payment Receipt</b></p>
  </div>

  <div class="receipt-details">
    <p><b>Receipt No:</b> <?= esc($receipt_no) ?></p>
    <p><b>Date:</b> <?= date('d M Y', strtotime($receipt['payment_date'])) ?></p>
    <p><b>Student:</b> <?= esc($receipt['first_name'].' '.$receipt['last_name']) ?> (<?= esc($receipt['admission_no']) ?>)</p>
    <p><b>Class:</b> <?= esc($receipt['class_name']) ?></p>
  </div>

  <table class="fee-table">
    <tr>
      <th>Fee Type</th>
      <th>Term</th>
      <th>Due Date</th>
      <th>Total Fee</th>
      <th>Paid Amount</th>
      <th>Method</th>
    </tr>
    <tr>
      <td><?= esc($receipt['fee_type']) ?></td>
      <td><?= esc($receipt['term']) ?></td>
      <td><?= esc($receipt['due_date']) ?></td>
      <td><?= number_format($receipt['total_fee'],2) ?></td>
      <td><?= number_format($receipt['paid_amount'],2) ?></td>
      <td><?= esc($receipt['method']) ?></td>
    </tr>
  </table>

  <p style="text-align:right; font-weight:bold; margin-top:10px;">
    Total Paid: <?= number_format($receipt['paid_amount'],2) ?>
  </p>

  <div style="margin-top:30px; text-align:center;">
    <p>✅ Thank you for your payment!</p>
    <p><i>This is a computer-generated receipt and does not require a signature.</i></p>
  </div>
</div>

<div style="text-align:center;">
  <button class="print-btn" onclick="window.print()">🖨 Print / Save as PDF</button>
</div>

<?php include 'partials/footer.php'; ?>
