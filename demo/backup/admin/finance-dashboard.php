<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// ======== SUMMARY DATA ======== //
$totalIncomeRes = $conn->query("SELECT SUM(paid_amount) AS total_income FROM fee_payments");
$totalIncome = (float)($totalIncomeRes->fetch_assoc()['total_income'] ?? 0);

$totalExpenseRes = $conn->query("SELECT SUM(amount) AS total_expense FROM expenses");
$totalExpense = (float)($totalExpenseRes->fetch_assoc()['total_expense'] ?? 0);

$totalDueRes = $conn->query("
  SELECT SUM(amount - IFNULL(paid.total_paid, 0)) AS total_due
  FROM student_fees sf
  LEFT JOIN (
    SELECT student_fee_id, SUM(paid_amount) AS total_paid 
    FROM fee_payments 
    GROUP BY student_fee_id
  ) paid ON sf.id = paid.student_fee_id
");
$totalDue = (float)($totalDueRes->fetch_assoc()['total_due'] ?? 0);
$netBalance = $totalIncome - $totalExpense;

// ======== MONTHLY DATA ======== //
$monthlyIncome = [];
$monthlyExpense = [];

for ($i = 1; $i <= 12; $i++) {
  $monthLabel = date('M', mktime(0, 0, 0, $i, 1));

  // Income per month
  $res1 = $conn->query("SELECT SUM(paid_amount) AS total FROM fee_payments WHERE MONTH(payment_date) = $i");
  $monthlyIncome[$monthLabel] = (float)($res1->fetch_assoc()['total'] ?? 0);

  // Expense per month
  $res2 = $conn->query("SELECT SUM(amount) AS total FROM expenses WHERE MONTH(expense_date) = $i");
  $monthlyExpense[$monthLabel] = (float)($res2->fetch_assoc()['total'] ?? 0);
}

// ======== RECENT TRANSACTIONS ======== //
$recentExpenses = $conn->query("
  SELECT e.title, e.amount, e.expense_date, c.name AS category 
  FROM expenses e
  LEFT JOIN expense_categories c ON e.category_id = c.id
  ORDER BY e.expense_date DESC
  LIMIT 5
");

$recentPayments = $conn->query("
  SELECT fp.paid_amount, fp.payment_date, fp.method, s.first_name, s.last_name, s.admission_no
  FROM fee_payments fp
  LEFT JOIN student_fees sf ON fp.student_fee_id = sf.id
  LEFT JOIN students s ON sf.student_id = s.id
  ORDER BY fp.payment_date DESC
  LIMIT 5
");
?>

<h2>💹 Finance Dashboard</h2>
<p>Comprehensive view of income, expenses, and balance with visual insights.</p>

<!-- ===== SUMMARY BOXES ===== -->
<div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:20px;">
  <div style="flex:1; min-width:220px; background:#e8f5e9; padding:15px; border-radius:8px; border-left:5px solid #4caf50;">
    <h3>💵 Total Collected Fees</h3>
    <p style="font-size:22px; color:#2e7d32; font-weight:bold;"><?= number_format($totalIncome,2) ?> LKR</p>
  </div>
  <div style="flex:1; min-width:220px; background:#fff3e0; padding:15px; border-radius:8px; border-left:5px solid #fb8c00;">
    <h3>📉 Outstanding Fees</h3>
    <p style="font-size:22px; color:#e65100; font-weight:bold;"><?= number_format($totalDue,2) ?> LKR</p>
  </div>
  <div style="flex:1; min-width:220px; background:#ffebee; padding:15px; border-radius:8px; border-left:5px solid #f44336;">
    <h3>💸 Total Expenses</h3>
    <p style="font-size:22px; color:#b71c1c; font-weight:bold;"><?= number_format($totalExpense,2) ?> LKR</p>
  </div>
  <div style="flex:1; min-width:220px; background:#e3f2fd; padding:15px; border-radius:8px; border-left:5px solid #2196f3;">
    <h3>🏦 Net Balance</h3>
    <p style="font-size:22px; color:#0d47a1; font-weight:bold;"><?= number_format($netBalance,2) ?> LKR</p>
  </div>
</div>

<hr style="margin:30px 0;">

<!-- ===== CHARTS ===== -->
<h3>📊 Financial Trends</h3>
<div style="display:flex; flex-wrap:wrap; gap:30px; margin-bottom:40px;">
  <div style="flex:1; min-width:400px;">
    <canvas id="incomeChart"></canvas>
  </div>
  <div style="flex:1; min-width:400px;">
    <canvas id="expenseChart"></canvas>
  </div>
</div>

<div style="margin-bottom:40px;">
  <canvas id="comparisonChart"></canvas>
</div>

<!-- ===== RECENT TRANSACTIONS ===== -->
<div style="display:flex; flex-wrap:wrap; gap:30px;">
  <div style="flex:1; min-width:400px;">
    <h3>🧾 Recent Expenses</h3>
    <table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse:collapse; background:white;">
      <thead style="background:#007bff; color:white;">
        <tr><th>Date</th><th>Title</th><th>Category</th><th>Amount</th></tr>
      </thead>
      <tbody>
        <?php if ($recentExpenses->num_rows == 0): ?>
          <tr><td colspan="4" style="text-align:center; color:gray;">No recent expenses.</td></tr>
        <?php else: while($exp = $recentExpenses->fetch_assoc()): ?>
          <tr>
            <td><?= esc($exp['expense_date']) ?></td>
            <td><?= esc($exp['title']) ?></td>
            <td><?= esc($exp['category']) ?></td>
            <td align="right"><?= number_format($exp['amount'],2) ?></td>
          </tr>
        <?php endwhile; endif; ?>
      </tbody>
    </table>
  </div>

  <div style="flex:1; min-width:400px;">
    <h3>💰 Recent Fee Payments</h3>
    <table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse:collapse; background:white;">
      <thead style="background:#007bff; color:white;">
        <tr><th>Date</th><th>Student</th><th>Amount</th><th>Method</th></tr>
      </thead>
      <tbody>
        <?php if ($recentPayments->num_rows == 0): ?>
          <tr><td colspan="4" style="text-align:center; color:gray;">No recent payments.</td></tr>
        <?php else: while($p = $recentPayments->fetch_assoc()): ?>
          <tr>
            <td><?= esc($p['payment_date']) ?></td>
            <td><?= esc($p['first_name'].' '.$p['last_name']) ?> (<?= esc($p['admission_no']) ?>)</td>
            <td align="right"><?= number_format($p['paid_amount'],2) ?></td>
            <td><?= esc($p['method']) ?></td>
          </tr>
        <?php endwhile; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ===== CHART.JS ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const months = <?= json_encode(array_keys($monthlyIncome)) ?>;
const incomeData = <?= json_encode(array_values($monthlyIncome)) ?>;
const expenseData = <?= json_encode(array_values($monthlyExpense)) ?>;

// Income Trend
new Chart(document.getElementById('incomeChart'), {
  type: 'line',
  data: {
    labels: months,
    datasets: [{
      label: 'Monthly Income',
      data: incomeData,
      borderColor: 'green',
      backgroundColor: 'rgba(76, 175, 80, 0.2)',
      tension: 0.3
    }]
  },
  options: { plugins: { legend: { display: true } } }
});

// Expense Trend
new Chart(document.getElementById('expenseChart'), {
  type: 'line',
  data: {
    labels: months,
    datasets: [{
      label: 'Monthly Expenses',
      data: expenseData,
      borderColor: 'red',
      backgroundColor: 'rgba(244, 67, 54, 0.2)',
      tension: 0.3
    }]
  },
  options: { plugins: { legend: { display: true } } }
});

// Comparison Bar Chart
new Chart(document.getElementById('comparisonChart'), {
  type: 'bar',
  data: {
    labels: months,
    datasets: [
      {
        label: 'Income',
        data: incomeData,
        backgroundColor: 'rgba(76, 175, 80, 0.7)',
      },
      {
        label: 'Expenses',
        data: expenseData,
        backgroundColor: 'rgba(244, 67, 54, 0.7)',
      }
    ]
  },
  options: {
    responsive: true,
    scales: { y: { beginAtZero: true } },
    plugins: { legend: { position: 'top' } }
  }
});
</script>

<?php include 'partials/footer.php'; ?>
