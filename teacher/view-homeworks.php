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
   Pagination
-------------------------------- */
$limit = 10;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

/* -------------------------------
   Total records
-------------------------------- */
$totalQ = $conn->query("
    SELECT COUNT(*) as total
    FROM homeworks h
    $where
");

$totalRow = $totalQ->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

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
    LIMIT $limit OFFSET $offset
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
/* ---------- ACTION BUTTONS ---------- */
.action-links{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.action-links a{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:8px 14px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
    transition:.2s ease;
}

.btn-edit{
    background:#eef4ff;
    color:#0d6efd;
    border:1px solid #cfe2ff;
}

.btn-edit:hover{
    background:#0d6efd;
    color:#fff;
    transform:translateY(-2px);
}

.btn-view{
    background:#ecfdf3;
    color:#198754;
    border:1px solid #c7f1d9;
}

.btn-view:hover{
    background:#198754;
    color:#fff;
    transform:translateY(-2px);
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

/* ---------- MOBILE ACTION BUTTONS ---------- */
.hw-actions{
    margin-top:16px;
    display:flex;
    flex-direction:column;
    gap:10px;
}

.hw-actions a{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    width:100%;
    padding:12px;
    border-radius:14px;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    transition:.25s ease;
    color:#fff;
}

/* VIEW */
.hw-actions .btn-attachment{
    background:linear-gradient(135deg,#0d6efd,#0b5ed7);
    box-shadow:0 6px 16px rgba(13,110,253,.25);
}

/* EDIT */
.hw-actions .btn-edit{
    background:linear-gradient(135deg,#198754,#157347);
    box-shadow:0 6px 16px rgba(25,135,84,.25);
    color:#fff;
}

/* SUBMISSION */
.hw-actions .btn-view{
    background:linear-gradient(135deg,#fd7e14,#e8590c);
    box-shadow:0 6px 16px rgba(253,126,20,.25);
    color:#fff;
}

.hw-actions a:hover{
    transform:translateY(-2px);
    color:#fff;
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
/* ---------- PAGINATION ---------- */
.pagination-wrap{
    margin-top:25px;
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:8px;
}

.pagination-wrap a{
    width:40px;
    height:40px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    background:white;
    color:#333;
    text-decoration:none;
    font-weight:600;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    transition:.2s;
}

.pagination-wrap a:hover{
    background:#007bff;
    color:white;
    transform:translateY(-2px);
}

.active-page{
    background:#007bff !important;
    color:white !important;
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
    <div class="action-links">

        <a href="edit-homework.php?id=<?= $hw['id'] ?>" class="btn-edit">
            <i class="fas fa-pen"></i> Edit
        </a>

        <a href="homework-submissions.php?homework_id=<?= $hw['id'] ?>" class="btn-view">
            <i class="fas fa-file-upload"></i> Submissions
        </a>

    </div>
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
<div class="hw-actions">

    <?php if ($hw['attachment']): ?>

        <a href="../<?= esc($hw['attachment']) ?>"
           target="_blank"
           class="btn-attachment">

           <i class="fas fa-paperclip"></i>
           View Attachment

        </a>

    <?php endif; ?>

    <a href="edit-homework.php?id=<?= $hw['id'] ?>"
       class="btn-edit">

       <i class="fas fa-pen"></i>
       Edit Homework

    </a>

    <a href="homework-submissions.php?homework_id=<?= $hw['id'] ?>"
       class="btn-view">

       <i class="fas fa-file-upload"></i>
       View Submissions

    </a>

</div>
</div>
<?php endwhile; ?>
</div>

<?php endif; ?>
<?php if($totalPages > 1): ?>

<div class="pagination-wrap">

    <?php for($i = 1; $i <= $totalPages; $i++): ?>

        <a href="?page=<?= $i ?>
        &subject_id=<?= urlencode($filterSubject) ?>
        &class_id=<?= urlencode($filterClass) ?>
        &due_date=<?= urlencode($filterDue) ?>"

        class="<?= $page == $i ? 'active-page' : '' ?>">

            <?= $i ?>

        </a>

    <?php endfor; ?>

</div>

<?php endif; ?>
<?php include '../partials/portal_footer.php'; ?>
