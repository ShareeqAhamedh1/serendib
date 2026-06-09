<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

$teacher_id = (int)($_GET['id'] ?? 0);
if ($teacher_id <= 0) {
    echo "<p style='color:red;'>Invalid teacher ID.</p>";
    exit;
}

// ✅ Fetch teacher details
$q = "
  SELECT t.*, s.subject_name
  FROM teachers t
  LEFT JOIN subjects s ON t.subject_id = s.id
  WHERE t.id = ?
";
$stmt = $conn->prepare($q);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();

if (!$teacher) {
    echo "<p style='color:red;'>Teacher not found.</p>";
    exit;
}

// ✅ Fetch attendance summary
$att = $conn->query("
    SELECT 
        SUM(status='Present') AS present_days,
        SUM(status='Absent') AS absent_days
    FROM attendance
    WHERE entity_type='teacher' AND entity_id=$teacher_id
")->fetch_assoc();

// ✅ Fetch salary summary
// ✅ Salary summary
$salarySummary = $conn->query("
    SELECT 
      SUM(base_salary) AS total_base,
      SUM(bonus) AS total_bonus,
      SUM(deductions) AS total_deductions,
      SUM(base_salary + bonus - deductions) AS total_net
    FROM teacher_payments
    WHERE teacher_id = $teacher_id
")->fetch_assoc();

$paidTotal = $salarySummary['paid_total'] ?? 0;

// ✅ Recent payments
$recentPayments = $conn->query("
    SELECT 
        month_year,
        base_salary,
        bonus,
        deductions,
        (base_salary + bonus - deductions) AS net_salary,
        payment_date,
        method
    FROM teacher_payments
    WHERE teacher_id = $teacher_id
    ORDER BY payment_date DESC
    LIMIT 10
");


?>

<style>
.profile-card {
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 1px 5px rgba(0,0,0,0.1);
    max-width:900px;
    margin-bottom:25px;
}
.section-title {
    margin-top:25px;
    font-size:20px;
    font-weight:bold;
}
.info-table th { width:180px; text-align:left; color:#333; }
.info-table td { color:#555; }
.badge { padding:5px 10px; border-radius:6px; }
.badge-green { background:#d1e7dd; color:#0f5132; }
</style>

<h2>👨‍🏫 Teacher Profile</h2>

<div class="profile-card">

    <!-- ✅ Header -->
    <div style="display:flex; align-items:center; gap:20px;">
        <img src="<?= BASE_URL ?>uploads/<?= $teacher['photo'] ?: 'default_teacher.png' ?>"
             style="width:90px;height:90px;border-radius:8px;object-fit:cover;">

        <div>
            <h2 style="margin:0;"><?= esc($teacher['first_name'].' '.$teacher['last_name']) ?></h2>
            <p style="margin:3px 0;color:#666;">Teacher Code: <b><?= esc($teacher['teacher_code']) ?></b></p>
            <span class="badge badge-green"><?= esc($teacher['subject_name']) ?></span>
        </div>

        <div style="margin-left:auto;">
            <a href="add-teacher.php?id=<?= $teacher_id ?>" class="btn btn-sm btn-primary">✏ Edit</a>
            <a href="<?= BASE_URL ?>backend/teachers.php?action=delete&id=<?= $teacher_id ?>"
               onclick="return confirm('Delete this teacher?')"
               class="btn btn-sm btn-danger">🗑 Delete</a>
        </div>
    </div>

    <hr>

    <!-- ✅ Basic Information -->
    <h3 class="section-title">📄 Basic Information</h3>
    <table class="info-table" cellpadding="8">
        <tr><th>Gender:</th><td><?= esc($teacher['gender']) ?></td></tr>
        <tr><th>Email:</th><td><?= esc($teacher['email'] ?: '-') ?></td></tr>
        <tr><th>Phone:</th><td><?= esc($teacher['phone'] ?: '-') ?></td></tr>
        <tr><th>Join Date:</th><td><?= esc($teacher['join_date']) ?></td></tr>
        <tr><th>Status:</th><td><?= esc($teacher['status']) ?></td></tr>
    </table>

    <!-- ✅ Attendance Summary -->
    <h3 class="section-title">📅 Attendance Summary</h3>
    <table class="info-table" cellpadding="8">
        <tr><th>Present Days:</th><td><?= (int)$att['present_days'] ?></td></tr>
        <tr><th>Absent Days:</th><td><?= (int)$att['absent_days'] ?></td></tr>
    </table>

<h3 class="section-title">🧾 Salary Payment History</h3>
<table cellpadding="8" style="width:100%;border-collapse:collapse;">
    <thead>
    <tr style="background:#007bff;color:white;">
        <th>Month</th>
        <th>Base</th>
        <th>Bonus</th>
        <th>Deductions</th>
        <th>Net Salary</th>
        <th>Method</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!$recentPayments || $recentPayments->num_rows == 0): ?>
        <tr><td colspan="7" align="center" style="color:gray;">No past payments.</td></tr>
    <?php else: ?>
        <?php while($p = $recentPayments->fetch_assoc()): ?>
            <tr>
                <td><?= esc($p['month_year']) ?></td>
                <td><?= number_format($p['base_salary'],2) ?></td>
                <td><?= number_format($p['bonus'],2) ?></td>
                <td><?= number_format($p['deductions'],2) ?></td>
                <td><b><?= number_format($p['net_salary'],2) ?></b></td>
                <td><?= esc($p['method']) ?></td>
                <td><?= esc($p['payment_date']) ?></td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
    </tbody>
</table>




</div>

<p><a href="teachers.php" style="color:#007bff;">⬅ Back to Teacher List</a></p>

<?php include 'partials/footer.php'; ?>
