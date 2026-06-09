<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

date_default_timezone_set('Asia/Colombo');

/* ===============================
   LOGGED-IN TEACHER
================================ */
$user_id = $_SESSION['user_id'];

$t = $conn->query("
    SELECT id, first_name, last_name
    FROM teachers
    WHERE user_id = $user_id
    LIMIT 1
")->fetch_assoc();

if (!$t) {
    echo "<p style='color:red'>Teacher not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

$teacher_id = (int)$t['id'];

/* ===============================
   MONTH FILTER
================================ */
$month = $_GET['month'] ?? date('Y-m');

/* ===============================
   FETCH SALARY
================================ */
$stmt = $conn->prepare("
    SELECT *
    FROM teacher_payments
    WHERE teacher_id = ?
      AND month_year = ?
    LIMIT 1
");
$stmt->bind_param("is", $teacher_id, $month);
$stmt->execute();
$salary = $stmt->get_result()->fetch_assoc();
?>

<style>
.salary-container{
    max-width:900px;
    margin:auto;
    padding:15px;
}

/* ---------- FILTER ---------- */
.filter-box{
    background:white;
    padding:16px;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
}

/* ---------- CARD ---------- */
.salary-card{
    background:white;
    padding:22px;
    border-radius:18px;
    box-shadow:0 8px 22px rgba(0,0,0,.08);
    margin-top:20px;
}

.salary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
}

.salary-box{
    background:#f8f9fa;
    padding:16px;
    border-radius:14px;
}

.salary-box h4{
    margin-bottom:6px;
    color:#004080;
}

.amount{
    font-size:22px;
    font-weight:700;
}

.plus{ color:#198754; }
.minus{ color:#dc3545; }

.status{
    padding:6px 14px;
    border-radius:14px;
    font-weight:600;
    font-size:14px;
    display:inline-block;
}

.status.paid{
    background:#e6f9ec;
    color:#0f5132;
}

.status.pending{
    background:#fff3cd;
    color:#664d03;
}

.meta{
    margin-top:12px;
    color:#555;
}

/* ---------- MOBILE ---------- */
@media(max-width:600px){
    .salary-card{padding:18px}
}
</style>

<div class="salary-container">

<h2>💰 My Salary</h2>
<p style="color:#555;">
    View your monthly salary details.
</p>

<!-- ================= FILTER ================= -->
<div class="filter-box">
<form method="get">
    <label><b>Select Month</b></label><br>
    <input type="month" name="month" value="<?= esc($month) ?>">
    <button style="margin-left:10px;">View</button>
</form>
</div>

<?php if(!$salary): ?>

<div class="salary-card">
    <p style="color:#777;">
        No salary record found for
        <b><?= date('F Y', strtotime($month.'-01')) ?></b>.
    </p>
</div>

<?php else: ?>

<!-- ================= SALARY CARD ================= -->
<div class="salary-card">

<h3>📅 <?= date('F Y', strtotime($salary['month_year'].'-01')) ?></h3>

<div class="salary-grid">

<div class="salary-box">
    <h4>Base Salary</h4>
    <div class="amount">
        Rs. <?= number_format($salary['base_salary'],2) ?>
    </div>
</div>

<div class="salary-box">
    <h4>Bonus</h4>
    <div class="amount plus">
        + Rs. <?= number_format($salary['bonus'],2) ?>
    </div>
</div>

<div class="salary-box">
    <h4>Deductions</h4>
    <div class="amount minus">
        - Rs. <?= number_format($salary['deductions'],2) ?>
    </div>
</div>

<div class="salary-box">
    <h4>Net Salary</h4>
    <div class="amount">
        Rs. <?= number_format($salary['net_salary'],2) ?>
    </div>
</div>

</div>

<br>

<b>Status:</b>
<span class="status <?= $salary['payment_date'] ? 'paid' : 'pending' ?>">
    <?= $salary['payment_date'] ? 'Paid' : 'Pending' ?>
</span>

<?php if($salary['payment_date']): ?>
<div class="meta">
    <b>Paid On:</b> <?= date('d M Y', strtotime($salary['payment_date'])) ?><br>
    <b>Method:</b> <?= esc($salary['method'] ?? '-') ?><br>
<?php endif; ?>

<?php if(!empty($salary['remarks'])): ?>
    <div class="meta">
        <b>Remarks:</b> <?= esc($salary['remarks']) ?>
    </div>
<?php endif; ?>

</div>

<?php endif; ?>

</div>

<?php include '../partials/portal_footer.php'; ?>
