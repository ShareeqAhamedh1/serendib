<?php 
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

// ✅ Get logged-in student's user_id
$user_id = $_SESSION['user_id'];

// ✅ Fetch student record
$stu = $conn->query("SELECT id FROM students WHERE user_id = $user_id")->fetch_assoc();
$student_id = $stu['id'] ?? 0;

if (!$student_id) {
    echo "<p style='color:red'>Student record not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

// ✅ Fetch attendance summary
$summary = $conn->query("
    SELECT 
        SUM(status='Present') AS present_days,
        SUM(status='Absent') AS absent_days
    FROM attendance 
    WHERE entity_type='student' AND entity_id=$student_id
")->fetch_assoc();

$present = (int)$summary['present_days'];
$absent  = (int)$summary['absent_days'];
$total   = $present + $absent;
$percent = ($total > 0) ? round(($present / $total) * 100, 1) : 0;

// ✅ Fetch all attendance records
$records = $conn->query("
    SELECT date, status 
    FROM attendance
    WHERE entity_type='student' AND entity_id=$student_id
    ORDER BY date DESC
");
?>

<h2>📅 Attendance</h2>

<div style="display:flex; gap:20px; margin-bottom:20px; flex-wrap:wrap;">

    <div style="flex:1; min-width:200px; background:white; padding:20px; border-radius:10px;">
        <h3>✅ Present Days</h3>
        <p style="font-size:24px; font-weight:bold;"><?= $present ?></p>
    </div>

    <div style="flex:1; min-width:200px; background:white; padding:20px; border-radius:10px;">
        <h3>❌ Absent Days</h3>
        <p style="font-size:24px; font-weight:bold;"><?= $absent ?></p>
    </div>

    <div style="flex:1; min-width:200px; background:white; padding:20px; border-radius:10px;">
        <h3>📊 Attendance %</h3>
        <p style="font-size:24px; font-weight:bold;"><?= $percent ?>%</p>
    </div>

</div>

<h3>📝 Attendance Records</h3>

<table border="1" cellpadding="8" cellspacing="0" style="width:100%; background:white; border-collapse:collapse;">
    <thead style="background:#007bff; color:white;">
        <tr>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($records->num_rows == 0): ?>
            <tr><td colspan="2" align="center" style="color:gray;">No attendance records found.</td></tr>
        <?php else: ?>
            <?php while($row = $records->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['date'] ?></td>
                    <td style="color:<?= $row['status']=='Present'?'green':'red' ?>;">
                        <?= $row['status'] ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../partials/portal_footer.php'; ?>
