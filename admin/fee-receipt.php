<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$payment_id = (int)($_GET['payment_id'] ?? 0);
if (!$payment_id) {
  echo "<p style='color:red;'>Invalid receipt request.</p>";
  include 'partials/footer.php';
  exit;
}

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

/* ---------- MAIN LAYOUT ---------- */
body {
  background: #f4f6f9;
  font-family: 'Segoe UI', Arial, sans-serif;
}

.receipt-container {
  max-width: 680px;
  margin: 40px auto;
  padding: 35px;
  background: #ffffff;
  border-radius: 14px;
  box-shadow: 0 15px 35px rgba(0,0,0,0.08);
}

/* ---------- HEADER ---------- */
.receipt-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 3px solid #0d6efd;
  padding-bottom: 15px;
  margin-bottom: 25px;
}

.school-info {
  display: flex;
  align-items: center;
  gap: 15px;
}

.school-info img {
  width: 60px;
}

.school-info h2 {
  margin: 0;
  color: #0d6efd;
  font-size: 22px;
  font-weight: 700;
}

.receipt-title {
  text-align: right;
}

.receipt-title h3 {
  margin: 0;
  font-size: 16px;
  font-weight: 600;
  color: #333;
}

.receipt-title p {
  margin: 4px 0 0;
  font-size: 13px;
  color: #666;
}

/* ---------- DETAILS ---------- */

.receipt-details {
  background: #f8f9fc;
  padding: 20px;
  border-radius: 10px;
  margin-bottom: 25px;
  font-size: 14px;
  display: grid;
  grid-template-columns: 170px 1fr;
  row-gap: 10px;
}

.receipt-details .label {
  font-weight: 600;
  color: #333;
}

.receipt-details .value {
  color: #444;
}


/* ---------- TABLE ---------- */
.fee-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.fee-table th {
  background: #0d6efd;
  color: white;
  padding: 10px;
  text-align: left;
  font-weight: 600;
}

.fee-table td {
  padding: 10px;
  border-bottom: 1px solid #eaeaea;
}

.fee-table tr:last-child td {
  border-bottom: none;
}

/* ---------- TOTAL BOX ---------- */
.total-box {
  margin-top: 20px;
  padding: 15px;
  background: #e9f2ff;
  border-radius: 8px;
  text-align: right;
  font-size: 15px;
  font-weight: 600;
  color: #0d6efd;
}

/* ---------- SIGNATURE ---------- */
.signature-section {
  margin-top: 35px;
  display: flex;
  justify-content: space-between;
  font-size: 13px;
  color: #444;
}

.signature-box {
  text-align: center;
}

.signature-line {
  margin-top: 40px;
  border-top: 1px solid #333;
  width: 180px;
  margin-left: auto;
  margin-right: auto;
}

/* ---------- FOOTER NOTE ---------- */
.footer-note {
  margin-top: 30px;
  text-align: center;
  font-size: 13px;
  color: #666;
}

/* ---------- PRINT BUTTON ---------- */
.print-btn {
  margin: 25px auto;
  display: block;
  background: #198754;
  color: white;
  padding: 10px 18px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
}
.fee-table td:nth-child(3),
.fee-table th:nth-child(3) {
  white-space: nowrap;
}

.fee-table td:nth-child(2),
.fee-table td:nth-child(3),
.fee-table td:nth-child(4),
.fee-table td:nth-child(5) {
  text-align: center;
}

/* ---------- PRINT SETTINGS ---------- */
@media print {

  @page {
    size: A5 portrait;
    margin: 8mm;
  }

  html, body {
    width: 148mm;
    height: 210mm;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background: white;
  }

  body * {
    visibility: hidden;
  }

  #receiptContent,
  #receiptContent * {
    visibility: visible;
  }

  #receiptContent {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    margin: 0;
    box-shadow: none;
  }

  .print-btn {
    display: none !important;
  }
}

</style>


<div class="receipt-container" id="receiptContent">

  <div class="receipt-header">
    <div class="school-info">
      <img src="<?= BASE_URL ?>assets/img/favicon.png" alt="Logo">
      <h2>Serendib School</h2>
    </div>
    <div class="receipt-title">
      <h3>OFFICIAL PAYMENT RECEIPT</h3>
      <p>Receipt No: <?= esc($receipt_no) ?></p>
    </div>
  </div>

<div class="receipt-details">

  <div class="label">Payment Date</div>
  <div class="value"><?= date('d M Y', strtotime($receipt['payment_date'])) ?></div>

  <div class="label">Student</div>
  <div class="value">
    <?= esc($receipt['first_name'].' '.$receipt['last_name']) ?>
    (<?= esc($receipt['admission_no']) ?>)
  </div>

  <div class="label">Class</div>
  <div class="value"><?= esc($receipt['class_name']) ?></div>

  <div class="label">Payment Method</div>
  <div class="value"><?= esc($receipt['method']) ?></div>

</div>


  <table class="fee-table">
    <tr>
      <th>Fee Type</th>
      <th>Term</th>
      <th>Due Date</th>
      <th>Total Fee</th>
      <th>Paid Amount</th>
    </tr>
    <tr>
      <td><?= esc($receipt['fee_type']) ?></td>
      <td><?= esc($receipt['term']) ?></td>
      <td><?= date('d M Y', strtotime($receipt['due_date'])) ?></td>
      <td><?= number_format($receipt['total_fee'],2) ?></td>
      <td><?= number_format($receipt['paid_amount'],2) ?></td>
    </tr>
  </table>

  <div class="total-box">
    Total Paid: <?= number_format($receipt['paid_amount'],2) ?>
  </div>

  <div class="signature-section">
    <div class="signature-box">
      <div class="signature-line"></div>
      Authorized Signature
    </div>
    <div class="signature-box">
      <div class="signature-line"></div>
      School Stamp
    </div>
  </div>

  <div class="footer-note">
    ✅ Thank you for your payment.<br>
    <em>This is a computer-generated receipt and it required a physical signature.</em>
  </div>

</div>

<button class="print-btn" onclick="window.print()">🖨 Print / Save as PDF</button>

<?php include 'partials/footer.php'; ?>
