<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

/* ===============================
   LOGGED-IN STUDENT
================================ */
$user_id = $_SESSION['user_id'];

$student = $conn->query("
    SELECT id, class_id 
    FROM students 
    WHERE user_id = $user_id
    LIMIT 1
")->fetch_assoc();

$class_id = (int)$student['class_id'];

/* ===============================
   FILTER
================================ */
$filterSubject = $_GET['subject_id'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 8;
$offset = ($page - 1) * $limit;

/* ===============================
   SUBJECT LIST
================================ */
$subjects = $conn->query("
    SELECT DISTINCT s.id, s.subject_name
    FROM subject_notes n
    JOIN subjects s ON s.id = n.subject_id
    WHERE n.class_id = $class_id
");

/* ===============================
   WHERE CLAUSE
================================ */
$where = "WHERE n.class_id = $class_id";
if ($filterSubject !== '') {
    $where .= " AND n.subject_id = " . (int)$filterSubject;
}

/* ===============================
   TOTAL COUNT (for pagination)
================================ */
$totalRow = $conn->query("
    SELECT COUNT(*) AS total
    FROM subject_notes n
    $where
")->fetch_assoc();

$totalNotes = (int)$totalRow['total'];
$totalPages = max(1, ceil($totalNotes / $limit));

/* ===============================
   NOTES QUERY (WITH LIMIT)
================================ */
$notes = $conn->query("
    SELECT n.*, s.subject_name
    FROM subject_notes n
    JOIN subjects s ON s.id = n.subject_id
    $where
    ORDER BY n.created_at DESC
    LIMIT $limit OFFSET $offset
");
?>

<style>
/* ---------- FILTER ---------- */
.filter-box{
    background:#fff;
    padding:16px;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    margin-bottom:22px
}
.filter-box form{
    display:flex;
    gap:12px;
    flex-wrap:wrap
}
.filter-box select,
.filter-box button,
.filter-box a{
    padding:10px 14px;
    border-radius:10px;
    font-size:14px
}
.filter-box button{
    background:#007bff;
    color:#fff;
    border:none;
    font-weight:600
}
.filter-box a{
    background:#e9ecef;
    color:#333;
    text-decoration:none
}

/* ---------- DESKTOP TABLE ---------- */
.notes-table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 8px 22px rgba(0,0,0,.08)
}
.notes-table th{
    background:#004080;
    color:#fff;
    padding:14px
}
.notes-table td{
    padding:14px;
    border-bottom:1px solid #eee
}

/* ---------- BUTTON ---------- */
.preview-btn{
    background:#007bff;
    color:white;
    padding:6px 12px;
    border-radius:16px;
    font-size:13px;
    text-decoration:none;
    display:inline-block
}

/* ---------- MOBILE ---------- */
.note-cards{display:none}

.note-card{
    background:#fff;
    padding:18px;
    border-radius:18px;
    box-shadow:0 8px 22px rgba(0,0,0,.08);
    margin-bottom:16px
}
.note-card h4{color:#004080;margin-bottom:6px}
.note-meta{font-size:14px;color:#555;margin-bottom:8px}

/* ---------- PAGINATION ---------- */
.pagination{
    display:flex;
    justify-content:center;
    gap:8px;
    margin:25px 0;
    flex-wrap:wrap
}
.pagination a{
    padding:8px 14px;
    border-radius:10px;
    background:#e9ecef;
    color:#333;
    text-decoration:none;
    font-size:14px
}
.pagination a.active{
    background:#007bff;
    color:white;
    font-weight:600
}
.pagination a:hover{
    background:#cfe2ff
}

/* ---------- RESPONSIVE ---------- */
@media(max-width:768px){
    .notes-table{display:none}
    .note-cards{display:block}
    .filter-box form{flex-direction:column}
}
</style>

<h2>📘 Class Notes</h2>
<p style="color:#555;">Notes shared by your teachers for your class.</p>

<!-- FILTER -->
<div class="filter-box">
<form method="get">
<select name="subject_id">
    <option value="">All Subjects</option>
    <?php while($s=$subjects->fetch_assoc()): ?>
        <option value="<?= $s['id'] ?>" <?= $filterSubject==$s['id']?'selected':'' ?>>
            <?= esc($s['subject_name']) ?>
        </option>
    <?php endwhile; ?>
</select>
<button>Filter</button>
<a href="notes.php">Reset</a>
</form>
</div>

<?php if($notes->num_rows===0): ?>
<p style="color:#777;">No notes available.</p>
<?php else: ?>

<!-- ================= DESKTOP ================= -->
<table class="notes-table">
<thead>
<tr>
    <th>Title</th>
    <th>Subject</th>
    <th>Preview</th>
    <th>Date</th>
</tr>
</thead>
<tbody>
<?php while($n=$notes->fetch_assoc()): ?>
<tr>
<td><?= esc($n['title']) ?></td>
<td><?= esc($n['subject_name']) ?></td>
<td>
<a class="preview-btn" href="note-preview.php?id=<?= $n['id'] ?>" target="_blank">
    👁 Preview
</a>
</td>
<td><?= date('d M Y',strtotime($n['created_at'])) ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- ================= MOBILE ================= -->
<div class="note-cards">
<?php
$notes->data_seek(0);
while($n=$notes->fetch_assoc()):
?>
<div class="note-card">
<h4><?= esc($n['title']) ?></h4>
<div class="note-meta">
📘 <?= esc($n['subject_name']) ?><br>
📅 <?= date('d M Y',strtotime($n['created_at'])) ?>
</div>
<a class="preview-btn" href="note-preview.php?id=<?= $n['id'] ?>" target="_blank">
    👁 Preview
</a>
</div>
<?php endwhile; ?>
</div>

<!-- ================= PAGINATION ================= -->
<div class="pagination">
<?php
$query = $_GET;
for ($p=1; $p<=$totalPages; $p++):
    $query['page'] = $p;
    $url = '?' . http_build_query($query);
?>
<a href="<?= $url ?>" class="<?= $p==$page?'active':'' ?>">
    <?= $p ?>
</a>
<?php endfor; ?>
</div>

<?php endif; ?>

<?php include '../partials/portal_footer.php'; ?>
