<?php
require 'conn.php';
require 'helpers.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
  exit;
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'message' => 'CSRF validation failed.']);
  exit;
}

$title = trim($_POST['title'] ?? '');
$category_id = (int)($_POST['category_id'] ?? 0);
$amount = (float)($_POST['amount'] ?? 0);
$expense_date = $_POST['expense_date'] ?? date('Y-m-d');
$method = $_POST['payment_method'] ?? 'Cash';
$remarks = trim($_POST['remarks'] ?? '');
$created_by = $_SESSION['user_id'] ?? null;

if ($title === '' || $amount <= 0 || $category_id <= 0) {
  echo json_encode(['success' => false, 'message' => 'Missing or invalid data.']);
  exit;
}

$stmt = $conn->prepare("
  INSERT INTO expenses (category_id, title, amount, expense_date, payment_method, remarks, created_by)
  VALUES (?, ?, ?, ?, ?, ?, ?)
");
if (!$stmt) {
  echo json_encode(['success' => false, 'message' => 'SQL Error: ' . $conn->error]);
  exit;
}
$stmt->bind_param("isdsssi", $category_id, $title, $amount, $expense_date, $method, $remarks, $created_by);
$stmt->execute();

echo json_encode(['success' => true, 'message' => 'Expense saved successfully!']);

header("Location: ../admin/add-expense.php?saved=1");
exit;