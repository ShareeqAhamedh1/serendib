<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Logged-in teacher
$user_id = $_SESSION['user_id'];
$t = $conn->query("SELECT id FROM teachers WHERE user_id=$user_id LIMIT 1")->fetch_assoc();
$teacher_id = $t['id'];

// Homework ID
$hw_id = (int)($_GET['homework_id'] ?? 0);

// Fetch teacher's homework list (dropdown)
$hwList = $conn->query("
    SELECT id, title
    FROM homeworks
    WHERE teacher_id = $teacher_id
    ORDER BY created_at DESC
");

// Fetch selected homework
$homework = null;
if ($hw_id) {
    $homework = $conn->query("
        SELECT *
        FROM homeworks
        WHERE id = $hw_id AND teacher_id = $teacher_id
        LIMIT 1
    ")->fetch_assoc();
}

$submissions = null;
$students = null;

if ($homework) {

    // Submitted students
    $submissions = $conn->query("
        SELECT 
            s.first_name,
            s.last_name,
            sub.file_path,
            sub.note,
            sub.submitted_at
        FROM homework_submissions sub
        JOIN students s ON s.id = sub.student_id
        WHERE sub.homework_id = $hw_id
        ORDER BY sub.submitted_at DESC
    ");

    // Students who did NOT submit
    $students = $conn->query("
        SELECT s.first_name, s.last_name
        FROM students s
        WHERE s.class_id = {$homework['class_id']}
          AND s.section_id = {$homework['section_id']}
          AND s.id NOT IN (
              SELECT student_id
              FROM homework_submissions
              WHERE homework_id = $hw_id
          )
        ORDER BY s.first_name
    ");
}
?>

<style>
.hw-wrap {
    max-width: 1000px;
    margin: auto;
}

.filter-box {
    background:white;
    padding:16px;
    border-radius:14px;
    box-shadow:0 4px 14px rgba(0,0,0,.08);
    margin-bottom:22px;
}

.filter-box select {
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
    width:100%;
    max-width:400px;
}

.section-title {
    margin:20px 0 10px;
}

.table-wrap {
    overflow-x:auto;
}

.sub-table {
    width:100%;
    border-collapse:collapse;
    background:white;
}

.sub-table th {
    background:#007bff;
    color:white;
    padding:12px;
}

.sub-table td {
    padding:12px;
    border-bottom:1px solid #eee;
}

.status-ok {
    color:#0f5132;
    font-weight:600;
}

.status-pending {
    color:#842029;
    font-weight:600;
}

/* Mobile cards */
.sub-cards {
    display:none;
}

.sub-card {
    background:white;
    padding:16px;
    border-radius:14px;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    margin-bottom:14px;
}

@media (max-width:768px) {
    .sub-table { display:none; }
    .sub-cards { display:block; }
}
</style>

<div class="hw-wrap">

<h2>📥 Homework Submissions</h2>

<!-- Homework selector -->
<div class="filter-box">
<form method="get">
    <label><b>Select Homework</b></label><br>
    <select name="homework_id" onchange="this.form.submit()">
        <option value="">-- Select Homework --</option>
        <?php while($h = $hwList->fetch_assoc()): ?>
            <option value="<?= $h['id'] ?>" <?= $hw_id == $h['id'] ? 'selected' : '' ?>>
                <?= esc($h['title']) ?>
            </option>
        <?php endwhile; ?>
    </select>
</form>
</div>

<?php if ($homework): ?>

<h3 class="section-title">✅ Submitted</h3>

<?php if ($submissions->num_rows == 0): ?>
<p style="color:#777;">No submissions yet.</p>
<?php else: ?>

<!-- Desktop -->
<div class="table-wrap">
<table class="sub-table">
<thead>
<tr>
    <th>Student</th>
    <th>Submitted At</th>
    <th>File</th>
    <th>Note</th>
</tr>
</thead>
<tbody>
<?php while($s = $submissions->fetch_assoc()): ?>
<tr>
    <td><?= esc($s['first_name'].' '.$s['last_name']) ?></td>
    <td><?= esc($s['submitted_at']) ?></td>
    <td>
        <a href="../<?= esc($s['file_path']) ?>" target="_blank">View</a>
    </td>
    <td><?= esc($s['note']) ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<!-- Mobile -->
<div class="sub-cards">
<?php
$submissions->data_seek(0);
while($s = $submissions->fetch_assoc()):
?>
<div class="sub-card">
    <b><?= esc($s['first_name'].' '.$s['last_name']) ?></b><br>
    📅 <?= esc($s['submitted_at']) ?><br>
    📎 <a href="../<?= esc($s['file_path']) ?>" target="_blank">View File</a><br>
    <?php if ($s['note']): ?>
        📝 <?= esc($s['note']) ?>
    <?php endif; ?>
</div>
<?php endwhile; ?>
</div>

<?php endif; ?>

<h3 class="section-title">❌ Not Submitted</h3>

<?php if ($students->num_rows == 0): ?>
<p class="status-ok">All students have submitted 🎉</p>
<?php else: ?>
<ul>
<?php while($st = $students->fetch_assoc()): ?>
    <li class="status-pending"><?= esc($st['first_name'].' '.$st['last_name']) ?></li>
<?php endwhile; ?>
</ul>
<?php endif; ?>

<?php endif; ?>

</div>

<?php include '../partials/portal_footer.php'; ?>
