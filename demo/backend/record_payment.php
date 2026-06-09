<?php
require 'conn.php';
require 'helpers.php';
header('Content-Type: application/json');

// ✅ Ensure POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
  exit;
}

// ✅ CSRF validation (only if csrf_field() is used)
if (!verify_csrf($_POST['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'message' => 'CSRF validation failed.']);
  exit;
}

$student_fee_id = (int)($_POST['student_fee_id'] ?? 0);
$amount         = (float)($_POST['amount'] ?? 0);
$method         = trim($_POST['method'] ?? 'Cash');
$remarks        = trim($_POST['remarks'] ?? '');
$payment_date   = date('Y-m-d');
$created_at     = date('Y-m-d H:i:s');
$created_by     = $_SESSION['user_id'] ?? null;

if ($student_fee_id <= 0 || $amount <= 0) {
  echo json_encode(['success' => false, 'message' => 'Invalid payment details.']);
  exit;
}

// ✅ Verify fee record exists
$feeCheck = $conn->prepare("SELECT id, amount FROM student_fees WHERE id=?");
$feeCheck->bind_param("i", $student_fee_id);
$feeCheck->execute();
$fee = $feeCheck->get_result()->fetch_assoc();

if (!$fee) {
  echo json_encode(['success' => false, 'message' => 'Student fee record not found.']);
  exit;
}

$totalDue = (float)$fee['amount'];

// ✅ Get already paid amount
$paidRes = $conn->prepare("SELECT SUM(paid_amount) AS total_paid FROM fee_payments WHERE student_fee_id=?");
$paidRes->bind_param("i", $student_fee_id);
$paidRes->execute();
$totalPaidBefore = (float)($paidRes->get_result()->fetch_assoc()['total_paid'] ?? 0);

// ✅ Prevent overpayment
if (($totalPaidBefore + $amount) > $totalDue) {
  echo json_encode(['success' => false, 'message' => 'Payment exceeds total fee amount.']);
  exit;
}

// ✅ Insert payment record
$stmt = $conn->prepare("
  INSERT INTO fee_payments (student_fee_id, paid_amount, payment_date, method, remarks, created_by, created_at)
  VALUES (?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
  echo json_encode(['success' => false, 'message' => 'SQL Prepare failed: ' . $conn->error]);
  exit;
}

// Bind types: i = int, d = double, s = string
$stmt->bind_param("idsssds", $student_fee_id, $amount, $payment_date, $method, $remarks, $created_by, $created_at);
$stmt->execute();
$receipt_id = $conn->insert_id; // store for later use

// ✅ Recalculate total paid
$totalPaidRes = $conn->prepare("SELECT SUM(paid_amount) AS total_paid FROM fee_payments WHERE student_fee_id=?");
$totalPaidRes->bind_param("i", $student_fee_id);
$totalPaidRes->execute();
$totalPaid = (float)($totalPaidRes->get_result()->fetch_assoc()['total_paid'] ?? 0);

// ✅ Determine status
if ($totalPaid >= $totalDue) {
  $newStatus = 'Paid';
} elseif ($totalPaid > 0) {
  $newStatus = 'Partial';
} else {
  $newStatus = 'Pending';
}

// ✅ Update main fee table
$update = $conn->prepare("UPDATE student_fees SET status=? WHERE id=?");
$update->bind_param("si", $newStatus, $student_fee_id);
$update->execute();

// ✅ Calculate remaining balance
$remaining = max(0, $totalDue - $totalPaid);

// ✅ Final response
echo json_encode([
  'success' => true,
  'message' => 'Payment recorded successfully!',
  'receipt_id' => $receipt_id, // so UI can open fee-receipt.php?payment_id=...
  'details' => [
    'total_due' => number_format($totalDue, 2),
    'total_paid' => number_format($totalPaid, 2),
    'remaining_balance' => number_format($remaining, 2),
    'status' => $newStatus,
    'method' => $method,
    'date' => $payment_date
  ]
]);
exit;
?>
