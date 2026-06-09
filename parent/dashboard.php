<?php
include '../partials/portal_header.php';
require_once __DIR__ . '../../backend/conn.php';

// fetch parent record
$parent = $conn->query("
    SELECT id, full_name 
    FROM parents 
    WHERE user_id = {$_SESSION['user_id']}
    LIMIT 1
")->fetch_assoc();

$parent_id = $parent['id'] ?? 0;

// count children
$childCount = $conn->query("
    SELECT COUNT(*) AS total 
    FROM students 
    WHERE parent_id = $parent_id
")->fetch_assoc()['total'] ?? 0;

/* -------------------------------------------------
   Homework alerts for parent
-------------------------------------------------- */

// Pending homework (not submitted, not overdue)
$pendingHW = $conn->query("
    SELECT COUNT(*) AS total
    FROM homeworks h
    JOIN students s ON s.class_id = h.class_id
                  AND s.section_id = h.section_id
    LEFT JOIN homework_submissions sub
        ON sub.homework_id = h.id
       AND sub.student_id = s.id
    WHERE s.parent_id = $parent_id
      AND sub.id IS NULL
      AND h.due_date >= CURDATE()
")->fetch_assoc()['total'] ?? 0;

// Overdue homework (not submitted & due date passed)
$overdueHW = $conn->query("
    SELECT COUNT(*) AS total
    FROM homeworks h
    JOIN students s ON s.class_id = h.class_id
                  AND s.section_id = h.section_id
    LEFT JOIN homework_submissions sub
        ON sub.homework_id = h.id
       AND sub.student_id = s.id
    WHERE s.parent_id = $parent_id
      AND sub.id IS NULL
      AND h.due_date < CURDATE()
")->fetch_assoc()['total'] ?? 0;


/* -------------------------------------------------
   Fee alerts for parent (MATCHES fees.php)
-------------------------------------------------- */

// Pending fees (not overdue)
$pendingFees = $conn->query("
    SELECT COUNT(*) AS total
    FROM student_fees sf
    JOIN students s ON s.id = sf.student_id
    WHERE s.parent_id = $parent_id
      AND sf.status IN ('Pending','Partial')
      AND sf.due_date >= CURDATE()
")->fetch_assoc()['total'] ?? 0;

// Overdue fees
$overdueFees = $conn->query("
    SELECT COUNT(*) AS total
    FROM student_fees sf
    JOIN students s ON s.id = sf.student_id
    WHERE s.parent_id = $parent_id
      AND sf.status IN ('Pending','Partial')
      AND sf.due_date < CURDATE()
")->fetch_assoc()['total'] ?? 0;

?>

<style>
/* ---------- DASHBOARD LAYOUT ---------- */
.dashboard-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 15px;
}

.dashboard-header {
    margin-bottom: 20px;
}

.dashboard-header h2 {
    color: #004080;
}

/* ---------- CARD GRID ---------- */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

/* ---------- CARD ---------- */
.dashboard-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.12);
}

.dashboard-card h3 {
    margin-bottom: 10px;
    color: #004080;
}

.dashboard-card p {
    color: #555;
    margin-bottom: 15px;
}

/* ---------- LINK BUTTON ---------- */
.dashboard-card a {
    display: inline-block;
    text-decoration: none;
    background: #004080;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    font-size: 14px;
}

.dashboard-card a:hover {
    background: #003060;
}

/* ---------- MOBILE ---------- */
@media (max-width: 600px) {
    .dashboard-header h2 {
        font-size: 20px;
    }
}
/* ---------- HOMEWORK ALERTS ---------- */
.hw-alert {
    border-radius:12px;
    padding:14px 16px;
    margin-bottom:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    font-size:15px;
}

.hw-alert.pending {
    background:#fff3cd;
    color:#664d03;
}

.hw-alert.overdue {
    background:#fdecea;
    color:#842029;
    border-left:6px solid #dc3545;
}

.hw-alert a {
    text-decoration:none;
    padding:6px 14px;
    border-radius:20px;
    font-weight:600;
    font-size:14px;
}

.hw-alert.pending a {
    background:#ff9800;
    color:white;
}

.hw-alert.overdue a {
    background:#dc3545;
    color:white;
}

/* Mobile stacking */
@media (max-width:600px) {
    .hw-alert {
        flex-direction:column;
        align-items:flex-start;
    }
}

/* ---------- FEE ALERTS ---------- */
.fee-alert {
    border-radius:12px;
    padding:14px 16px;
    margin-bottom:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    font-size:15px;
}

.fee-alert.pending {
    background:#e7f1ff;
    color:#084298;
}

.fee-alert.overdue {
    background:#fdecea;
    color:#842029;
    border-left:6px solid #dc3545;
}

.fee-alert a {
    text-decoration:none;
    padding:6px 14px;
    border-radius:20px;
    font-weight:600;
    font-size:14px;
}

.fee-alert.pending a {
    background:#0d6efd;
    color:white;
}

.fee-alert.overdue a {
    background:#dc3545;
    color:white;
}

/* Mobile */
@media (max-width:600px) {
    .fee-alert {
        flex-direction:column;
        align-items:flex-start;
    }
}


</style>

<div class="dashboard-container">

    <div class="dashboard-header">
        <h2>👨‍👩‍👦 Parent Dashboard</h2>
        <p>Welcome, <strong><?= esc($parent['full_name']) ?></strong></p>
    </div>

    <?php if ($overdueHW > 0): ?>
<div class="hw-alert overdue">
    ⏰ <strong><?= $overdueHW ?></strong> homework item<?= $overdueHW > 1 ? 's are' : ' is' ?> overdue and not submitted.
    <a href="children.php">View</a>
</div>
<?php endif; ?>

<?php if ($pendingHW > 0): ?>
<div class="hw-alert pending">
    📚 <strong><?= $pendingHW ?></strong> homework item<?= $pendingHW > 1 ? 's are' : ' is' ?> pending.
    <a href="children.php">View</a>
</div>
<?php endif; ?>
<?php if ($overdueFees > 0): ?>
<div class="fee-alert overdue">
    💰 <strong><?= $overdueFees ?></strong> fee payment<?= $overdueFees > 1 ? 's are' : ' is' ?> overdue.
    <a href="fees.php">Pay Now</a>
</div>
<?php endif; ?>

<?php if ($pendingFees > 0): ?>
<div class="fee-alert pending">
    💳 <strong><?= $pendingFees ?></strong> fee payment<?= $pendingFees > 1 ? 's are' : ' is' ?> pending.
    <a href="fees.php">View</a>
</div>
<?php endif; ?>

    <div class="dashboard-grid">

        <div class="dashboard-card">
            <h3>👦 My Children</h3>
            <p>Total linked students: <strong><?= $childCount ?></strong></p>
            <a href="children.php">View Children →</a>
        </div>

        <!--<div class="dashboard-card">-->
        <!--    <h3>📅 Attendance</h3>-->
        <!--    <p>Track daily attendance records.</p>-->
        <!--    <a href="attendance.php">View Attendance →</a>-->
        <!--</div>-->

<div class="dashboard-card">
    <h3>💰 Fees</h3>

    <?php if ($overdueFees > 0): ?>
        <p style="color:#dc3545;font-weight:700;">
            <?= $overdueFees ?> overdue payment<?= $overdueFees > 1 ? 's' : '' ?>
        </p>
    <?php elseif ($pendingFees > 0): ?>
        <p style="color:#0d6efd;font-weight:600;">
            <?= $pendingFees ?> pending payment<?= $pendingFees > 1 ? 's' : '' ?>
        </p>
    <?php else: ?>
        <p>No outstanding fees 🎉</p>
    <?php endif; ?>

    <a href="fees.php">View Fees →</a>
</div>


        <div class="dashboard-card">
    <h3>📚 Homework</h3>
    <?php if ($overdueHW > 0): ?>
        <p style="color:#dc3545;font-weight:600;">
            <?= $overdueHW ?> overdue homework
        </p>
    <?php elseif ($pendingHW > 0): ?>
        <p style="color:#ff9800;font-weight:600;">
            <?= $pendingHW ?> pending homework
        </p>
    <?php else: ?>
        <p>No homework issues 🎉</p>
    <?php endif; ?>
    <a href="children.php">View Details →</a>
</div>

    </div>
</div>

<?php include '../partials/portal_footer.php'; ?>
