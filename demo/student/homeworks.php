<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// ✅ Logged-in student
$user_id = $_SESSION['user_id'];

$student = $conn->query("
    SELECT id, class_id, section_id
    FROM students
    WHERE user_id = $user_id
    LIMIT 1
")->fetch_assoc();

$class_id   = $student['class_id'];
$section_id = $student['section_id'];

/* -----------------------------
   Fetch homework
------------------------------ */
$homeworks = $conn->query("
    SELECT 
        h.*,
        s.subject_name,
        t.first_name,
        t.last_name,
        sub.submitted_at
    FROM homeworks h
    JOIN subjects s ON s.id = h.subject_id
    JOIN teachers t ON t.id = h.teacher_id
    LEFT JOIN homework_submissions sub
        ON sub.homework_id = h.id
       AND sub.student_id = {$student['id']}
    WHERE h.class_id = $class_id
      AND h.section_id = $section_id
    ORDER BY h.due_date ASC
");

?>

<style>
/* ---------- TABLE ---------- */
.hw-table {
    width:100%;
    border-collapse:collapse;
    background:white;
}

.hw-table th {
    background:#007bff;
    color:white;
    padding:12px;
}

.hw-table td {
    padding:12px;
    border-bottom:1px solid #eee;
}

/* ---------- STATUS ---------- */
.hw-status {
    padding:6px 12px;
    border-radius:20px;
    font-weight:600;
    font-size:13px;
}

.hw-pending {
    background:#fff3cd;
    color:#664d03;
}

.hw-overdue {
    background:#fdecea;
    color:#842029;
}

/* ---------- MOBILE CARDS ---------- */
.hw-cards {
    display:none;
}

.hw-card {
    background:white;
    padding:16px;
    border-radius:14px;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    margin-bottom:16px;
}

.hw-card h4 {
    margin-bottom:6px;
}

.hw-meta {
    font-size:14px;
    color:#555;
}

.hw-actions {
    margin-top:10px;
}

.hw-actions a {
    display:inline-block;
    margin-right:10px;
    color:#007bff;
    font-weight:600;
    text-decoration:none;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width:768px) {
    .hw-table { display:none; }
    .hw-cards { display:block; }
}
.hw-submitted {
    background:#e6f9ec;
    color:#0f5132;
}

</style>

<h2>📘 My Homework</h2>
<p style="color:#555;">Here are all homework assignments for your class.</p>

<?php if ($homeworks->num_rows == 0): ?>
<p style="color:#777;">🎉 No homework assigned yet.</p>
<?php else: ?>

<!-- DESKTOP TABLE -->
<table class="hw-table">
<thead>
<tr>
    <th>Title</th>
    <th>Subject</th>
    <th>Teacher</th>
    <th>Due Date</th>
    <th>Status</th>
    <th>Attachment</th>
</tr>
</thead>
<tbody>
<?php while($hw = $homeworks->fetch_assoc()): 
    if ($hw['submitted_at']) {
    $status = 'submitted';
} elseif ($hw['due_date'] < date('Y-m-d')) {
    $status = 'overdue';
} else {
    $status = 'pending';
}

?>
<tr>
    <td><?= esc($hw['title']) ?></td>
    <td><?= esc($hw['subject_name']) ?></td>
    <td><?= esc($hw['first_name'].' '.$hw['last_name']) ?></td>
    <td><?= esc($hw['due_date']) ?></td>
<td>
<?php if ($status === 'submitted'): ?>
    <span class="hw-status hw-submitted">Submitted</span>
<?php elseif ($status === 'overdue'): ?>
    <span class="hw-status hw-overdue">Overdue</span>
<?php else: ?>
    <span class="hw-status hw-pending">Pending</span>
<?php endif; ?>
</td>

    <td>
        <?php if ($hw['attachment']): ?>
            <a href="../<?= esc($hw['attachment']) ?>" target="_blank">Download</a>
            <a href="homework-view.php?id=<?= $hw['id'] ?>">VIew</a>

        <?php else: ?>
            —
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- MOBILE CARDS -->
<div class="hw-cards">
<?php
$homeworks->data_seek(0);
while($hw = $homeworks->fetch_assoc()):

    if ($hw['submitted_at']) {
        $status = 'submitted';
    } elseif ($hw['due_date'] < date('Y-m-d')) {
        $status = 'overdue';
    } else {
        $status = 'pending';
    }

?>
<div class="hw-card">
    <h4><?= esc($hw['title']) ?></h4>
    <div class="hw-meta">
        📘 <?= esc($hw['subject_name']) ?><br>
        👩‍🏫 <?= esc($hw['first_name'].' '.$hw['last_name']) ?><br>
        📅 Due: <?= esc($hw['due_date']) ?>
    </div>

    <div style="margin-top:8px;">
        <span class="hw-status hw-<?= $status ?>">
    <?= ucfirst($status) ?>
</span>

    </div>

    <div class="hw-actions">
        <?php if ($hw['attachment']): ?>
            <a href="homework-view.php?id=<?= $hw['id'] ?>" class="card-button">
    View Details →
</a>
        <?php endif; ?>
    </div>
</div>
<?php endwhile; ?>
</div>

<?php endif; ?>

<?php include '../partials/portal_footer.php'; ?>
