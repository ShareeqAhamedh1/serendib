<?php
require 'conn.php';
require 'helpers.php';
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
  exit;
}



$teacher_id   = (int)($_POST['teacher_id'] ?? 0);
$month_year = date('Y-m', strtotime($_POST['month_year'] ?? date('Y-m')));
$base_salary  = (float)($_POST['base_salary'] ?? 0);
$bonus        = (float)($_POST['bonus'] ?? 0);
$deductions   = (float)($_POST['deductions'] ?? 0);
$method       = trim($_POST['method'] ?? 'Cash');
$remarks      = trim($_POST['remarks'] ?? '');
$payment_date = date('Y-m-d');
$created_at   = date('Y-m-d H:i:s');
$created_by   = $_SESSION['user_id'] ?? null;

if ($teacher_id <= 0 || $base_salary <= 0 || $month_year === '') {
  echo json_encode(['success' => false, 'message' => 'Invalid salary data.']);
  exit;
}

// 🔍 Check for duplicate month
$dupCheck = $conn->prepare("SELECT id FROM teacher_payments WHERE teacher_id=? AND month_year=?");
$dupCheck->bind_param("is", $teacher_id, $month_year);
$dupCheck->execute();
if ($dupCheck->get_result()->num_rows > 0) {
  echo json_encode(['success' => false, 'message' => 'Salary already recorded for this month.']);
  exit;
}

$total_paid = ($base_salary + $bonus) - $deductions;

// 💾 Insert into teacher_payments
$stmt = $conn->prepare("
  INSERT INTO teacher_payments
  (teacher_id, month_year, base_salary, bonus, deductions, total_paid, method, remarks, payment_date, created_by, created_at)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
  "isddddsssds",
  $teacher_id,
  $month_year,
  $base_salary,
  $bonus,
  $deductions,
  $total_paid,
  $method,
  $remarks,
  $payment_date,
  $created_by,
  $created_at
);
$stmt->execute();
$payment_id = $conn->insert_id;

// 🔍 Get teacher info
$tq = $conn->prepare("SELECT first_name, last_name FROM teachers WHERE id=?");
$tq->bind_param("i", $teacher_id);
$tq->execute();
$t = $tq->get_result()->fetch_assoc();
$teacher_name = $t ? ($t['first_name'] . ' ' . $t['last_name']) : 'Unknown Teacher';

// 💡 Get or create expense category "Teacher Salary"
$catCheck = $conn->prepare("SELECT id FROM expense_categories WHERE name='Teacher Salary'");
$catCheck->execute();
$res = $catCheck->get_result();
if ($res->num_rows > 0) {
  $cat_id = $res->fetch_assoc()['id'];
} else {
  $insCat = $conn->prepare("INSERT INTO expense_categories (name, description, created_at) VALUES ('Teacher Salary', 'Monthly teacher salary payments', NOW())");
  $insCat->execute();
  $cat_id = $conn->insert_id;
}

// 💰 Insert into expenses table
$expense_title = "Salary payment for $teacher_name ($month_year)";
$exp = $conn->prepare("
  INSERT INTO expenses (category_id, title, amount, expense_date, payment_method, remarks, created_by, created_at)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$exp->bind_param(
  "isdsssis",
  $cat_id,
  $expense_title,
  $total_paid,
  $payment_date,
  $method,
  $remarks,
  $created_by,
  $created_at
);
$exp->execute();

echo json_encode([
  'success' => true,
  'message' => "✅ Salary payment recorded and added to expenses successfully for $teacher_name!",
  'redirect' => BASE_URL . "admin/teacher-salary.php?success=1"
]);
