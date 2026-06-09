<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Logged-in parent
$parent = $conn->query("
    SELECT id FROM parents 
    WHERE user_id = {$_SESSION['user_id']} 
    LIMIT 1
")->fetch_assoc();

$parent_id = $parent['id'] ?? 0;

// Student ID
$student_id = (int)($_GET['student_id'] ?? 0);

// Verify student belongs to this parent
$student = $conn->query("
    SELECT s.*, c.class_name, sec.section_name
    FROM students s
    JOIN classes c ON c.id = s.class_id
    JOIN sections sec ON sec.id = s.section_id
    WHERE s.id = $student_id
      AND s.parent_id = $parent_id
    LIMIT 1
")->fetch_assoc();

if (!$student) {
    echo "<p style='color:red;'>Invalid student.</p>";
    include '../partials/portal_footer.php';
    exit;
}

// Fetch homeworks
$homeworks = $conn->query("
    SELECT 
        h.*,
        sub.id AS submission_id,
        sub.submitted_at,
        sub.file_path
    FROM homeworks h
    LEFT JOIN homework_submissions sub
        ON sub.homework_id = h.id
       AND sub.student_id = $student_id
    WHERE h.class_id = {$student['class_id']}
      AND h.section_id = {$student['section_id']}
    ORDER BY h.due_date DESC
");
?>

<style>
/* ---------- PAGE ---------- */
.hw-container {
    max-width:1100px;
    margin:auto;
    padding:15px;
}

/* ---------- TABLE ---------- */
.hw-table {
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
}

.hw-table th {
    background:#004080;
    color:white;
    padding:12px;
}

.hw-table td {
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

/* ---------- STATUS ---------- */
.status {
    padding:6px 12px;
    border-radius:20px;
    font-weight:600;
    font-size:13px;
    display:inline-block;
}

.status.pending { background:#fff3cd; color:#664d03; }
.status.overdue { background:#fdecea; color:#842029; }
.status.submitted { background:#e6f9ec; color:#0f5132; }

/* ---------- MOBILE CARDS ---------- */
.hw-cards {
    display:none;
}

.hw-card {
    background:white;
    padding:16px;
    border-radius:14px;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    margin-bottom:15px;
}

.hw-card h4 {
    margin-bottom:6px;
}

.hw-meta {
    font-size:14px;
    color:#555;
    margin-bottom:8px;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width:768px) {
    .hw-table { display:none; }
    .hw-cards { display:block; }
}
</style>

<div class="hw-container">

<h2>📚 Homework – <?= esc($student['first_name'].' '.$student['last_name']) ?></h2>
<p style="color:#555;">
    Class: <?= esc($student['class_name'].' '.$student['section_name']) ?>
</p>

<?php if ($homeworks->num_rows == 0): ?>
    <p style="color:#777;">No homework assigned.</p>

<?php else: ?>

<!-- ================= DESKTOP TABLE ================= -->
<table class="hw-table">
<thead>
<tr>
    <th>Title</th>
    <th>Due Date</th>
    <th>Status</th>
    <th>Attachment</th>
</tr>
</thead>
<tbody>
<?php while($hw = $homeworks->fetch_assoc()):
    if ($hw['submission_id']) {
        $status = '<span class="status submitted">Submitted</span>';
    } elseif ($hw['due_date'] < date('Y-m-d')) {
        $status = '<span class="status overdue">Overdue</span>';
    } else {
        $status = '<span class="status pending">Pending</span>';
    }
?>
<tr>
    <td><?= esc($hw['title']) ?></td>
    <td><?= esc($hw['due_date']) ?></td>
    <td><?= $status ?></td>
    <td>
        <?php if ($hw['attachment']): ?>
            <a href="../<?= esc($hw['attachment']) ?>" target="_blank">View</a>
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- ================= MOBILE CARDS ================= -->
<div class="hw-cards">
<?php
$homeworks->data_seek(0);
while($hw = $homeworks->fetch_assoc()):
    if ($hw['submission_id']) {
        $statusText = 'Submitted';
        $statusClass = 'submitted';
    } elseif ($hw['due_date'] < date('Y-m-d')) {
        $statusText = 'Overdue';
        $statusClass = 'overdue';
    } else {
        $statusText = 'Pending';
        $statusClass = 'pending';
    }
?>
<div class="hw-card">
    <h4><?= esc($hw['title']) ?></h4>
    <div class="hw-meta">📅 Due: <?= esc($hw['due_date']) ?></div>
    <span class="status <?= $statusClass ?>"><?= $statusText ?></span>

    <?php if ($hw['attachment']): ?>
        <div style="margin-top:10px;">
            <a href="../<?= esc($hw['attachment']) ?>" target="_blank">📎 View Attachment</a>
        </div>
    <?php endif; ?>
</div>
<?php endwhile; ?>
</div>

<?php endif; ?>

</div>

<?php include '../partials/portal_footer.php'; ?>
