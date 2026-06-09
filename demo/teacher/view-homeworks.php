<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// ✅ Logged-in teacher
$user_id = $_SESSION['user_id'];
$t = $conn->query("SELECT id FROM teachers WHERE user_id=$user_id LIMIT 1")->fetch_assoc();
$teacher_id = $t['id'];

/* -------------------------------
   Filters
-------------------------------- */
$filterSubject = $_GET['subject_id'] ?? '';
$filterClass   = $_GET['class_id'] ?? '';
$filterDue     = $_GET['due_date'] ?? '';

/* -------------------------------
   Dropdown data
-------------------------------- */
$subjects = $conn->query("
    SELECT DISTINCT s.id, s.subject_name
    FROM homeworks h
    JOIN subjects s ON s.id = h.subject_id
    WHERE h.teacher_id = $teacher_id
");

$classes = $conn->query("
    SELECT DISTINCT c.id, c.class_name
    FROM homeworks h
    JOIN classes c ON c.id = h.class_id
    WHERE h.teacher_id = $teacher_id
");

/* -------------------------------
   Build WHERE
-------------------------------- */
$where = " WHERE h.teacher_id = $teacher_id ";

if ($filterSubject !== '') {
    $where .= " AND h.subject_id = " . (int)$filterSubject;
}

if ($filterClass !== '') {
    $where .= " AND h.class_id = " . (int)$filterClass;
}

if ($filterDue !== '') {
    $where .= " AND h.due_date = '" . $conn->real_escape_string($filterDue) . "'";
}

/* -------------------------------
   Fetch homework
-------------------------------- */
$homeworks = $conn->query("
    SELECT 
        h.*,
        s.subject_name,
        c.class_name,
        sec.section_name
    FROM homeworks h
    JOIN subjects s ON s.id = h.subject_id
    JOIN classes c ON c.id = h.class_id
    JOIN sections sec ON sec.id = h.section_id
    $where
    ORDER BY h.created_at DESC
");
?>

<style>
:root {
    --primary:#007bff;
    --bg:#f4f6fb;
    --card:#ffffff;
    --text:#333;
    --muted:#666;
    --radius:14px;
}

h2 {
    margin-bottom:15px;
}

/* ---------- FILTER BOX ---------- */
.filter-box {
    background:var(--card);
    padding:16px;
    border-radius:var(--radius);
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    margin-bottom:22px;
}

.filter-box form {
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(180px,1fr));
    gap:12px;
}

.filter-box select,
.filter-box input {
    padding:12px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:14px;
}

.filter-box button,
.filter-box a {
    padding:12px;
    border-radius:10px;
    border:none;
    background:var(--primary);
    color:white;
    text-decoration:none;
    cursor:pointer;
    font-weight:600;
    text-align:center;
}

.filter-box a {
    background:#6c757d;
}

/* ---------- TABLE ---------- */
.table-wrap {
    overflow-x:auto;
}

.hw-table {
    width:100%;
    border-collapse:collapse;
    background:var(--card);
    border-radius:var(--radius);
    overflow:hidden;
}

.hw-table th {
    background:var(--primary);
    color:white;
    padding:14px;
    font-size:14px;
}

.hw-table td {
    padding:14px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.hw-table tr:last-child td {
    border-bottom:none;
}

/* ---------- ACTION BUTTONS ---------- */
.action-links a {
    display:inline-block;
    padding:6px 10px;
    margin-right:6px;
    border-radius:8px;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
}

.btn-edit {
    background:#e7f1ff;
    color:#0056b3;
}

.btn-view {
    background:#e6f9ec;
    color:#0f5132;
}

/* ---------- MOBILE CARDS ---------- */
.hw-cards {
    display:none;
}

.hw-card {
    background:var(--card);
    padding:16px;
    border-radius:var(--radius);
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    margin-bottom:16px;
}

.hw-card h4 {
    margin-bottom:6px;
    font-size:17px;
}

.hw-meta {
    font-size:14px;
    color:var(--muted);
    line-height:1.5;
}

.hw-due {
    margin-top:8px;
    font-weight:600;
}

.hw-actions {
    margin-top:12px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.hw-actions a {
    padding:8px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
}

.hw-actions .btn-edit {
    background:#e7f1ff;
}

.hw-actions .btn-view {
    background:#e6f9ec;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 768px) {
    .hw-table {
        display:none;
    }
    .hw-cards {
        display:block;
    }
}
</style>


<h2>📚 Assigned Homeworks</h2>

<!-- FILTERS -->
<div class="filter-box">
<form method="get">

    <select name="subject_id">
        <option value="">All Subjects</option>
        <?php while($s = $subjects->fetch_assoc()): ?>
            <option value="<?= $s['id'] ?>" <?= $filterSubject == $s['id'] ? 'selected' : '' ?>>
                <?= esc($s['subject_name']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <select name="class_id">
        <option value="">All Classes</option>
        <?php while($c = $classes->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>" <?= $filterClass == $c['id'] ? 'selected' : '' ?>>
                <?= esc($c['class_name']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="date" name="due_date" value="<?= esc($filterDue) ?>">

    <button type="submit">Filter</button>
    <a href="view-homeworks.php">Reset</a>

</form>
</div>

<?php if ($homeworks->num_rows == 0): ?>
<p style="color:#777;">No homework found.</p>
<?php else: ?>

<!-- DESKTOP TABLE -->
<div class="table-wrap">
<table class="hw-table">
<thead>
<tr>
    <th>Title</th>
    <th>Subject</th>
    <th>Class</th>
    <th>Due Date</th>
    <th>Attachment</th>
    <th>Actions</th>

</tr>
</thead>
<tbody>
<?php while($hw = $homeworks->fetch_assoc()): ?>
<tr>
    <td><?= esc($hw['title']) ?></td>
    <td><?= esc($hw['subject_name']) ?></td>
    <td><?= esc($hw['class_name']) ?> - <?= esc($hw['section_name']) ?></td>
    <td><?= esc($hw['due_date']) ?></td>
    <td>
        <?php if ($hw['attachment']): ?>
            <a href="../<?= esc($hw['attachment']) ?>" target="_blank">View</a>
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
    <td>
    <a href="edit-homework.php?id=<?= $hw['id'] ?>">✏️ Edit</a>
    <a href="homework-submissions.php?homework_id=<?= $hw['id'] ?>">
    📥 View Submissions
</a>

    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<!-- MOBILE CARDS -->
<div class="hw-cards">
<?php
$homeworks->data_seek(0);
while($hw = $homeworks->fetch_assoc()):
?>
<div class="hw-card">
    <h4><?= esc($hw['title']) ?></h4>
    <div class="hw-meta">
        📘 <?= esc($hw['subject_name']) ?><br>
        🏫 <?= esc($hw['class_name']) ?> - <?= esc($hw['section_name']) ?>
    </div>
    <div class="hw-due">📅 Due: <?= esc($hw['due_date']) ?></div>
    <?php if ($hw['attachment']): ?>
        <a href="../<?= esc($hw['attachment']) ?>" target="_blank">📎 View Attachment</a>
        <a href="edit-homework.php?id=<?= $hw['id'] ?>" style="display:inline-block;margin-top:8px;">
✏️ Edit Homework
</a>
<a href="homework-submissions.php?homework_id=<?= $hw['id'] ?>">
    📥 View Submissions
</a>


    <?php endif; ?>
</div>
<?php endwhile; ?>
</div>

<?php endif; ?>

<?php include '../partials/portal_footer.php'; ?>
