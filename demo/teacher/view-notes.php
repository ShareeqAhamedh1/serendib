<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

/* ===============================
   LOGGED-IN TEACHER
================================ */
$user_id = $_SESSION['user_id'];
$t = $conn->query("SELECT id FROM teachers WHERE user_id=$user_id")->fetch_assoc();
$teacher_id = (int)$t['id'];

/* ===============================
   FILTER INPUT
================================ */
$filterClass   = $_GET['class_id'] ?? '';
$filterSubject = $_GET['subject_id'] ?? '';
$page          = max(1, (int)($_GET['page'] ?? 1));
$limit         = 8;
$offset        = ($page - 1) * $limit;

/* ===============================
   FILTER DATA
================================ */
$classes = $conn->query("
    SELECT DISTINCT c.id, c.class_name
    FROM subject_notes n
    JOIN classes c ON c.id = n.class_id
    WHERE n.teacher_id = $teacher_id
");

$subjects = $conn->query("
    SELECT DISTINCT s.id, s.subject_name
    FROM subject_notes n
    JOIN subjects s ON s.id = n.subject_id
    WHERE n.teacher_id = $teacher_id
");

/* ===============================
   BUILD WHERE
================================ */
$where = "WHERE n.teacher_id = $teacher_id";

if ($filterClass !== '') {
    $where .= " AND n.class_id = " . (int)$filterClass;
}
if ($filterSubject !== '') {
    $where .= " AND n.subject_id = " . (int)$filterSubject;
}

/* ===============================
   TOTAL COUNT
================================ */
$totalRow = $conn->query("
    SELECT COUNT(*) AS total
    FROM subject_notes n
    $where
")->fetch_assoc();

$totalNotes = (int)$totalRow['total'];
$totalPages = max(1, ceil($totalNotes / $limit));

/* ===============================
   FETCH NOTES (PAGINATED)
================================ */
$notes = $conn->query("
    SELECT 
        n.*,
        c.class_name,
        s.subject_name
    FROM subject_notes n
    JOIN classes c ON c.id = n.class_id
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
    padding:18px;
    border-radius:16px;
    box-shadow:0 8px 22px rgba(0,0,0,.08);
    margin-bottom:24px
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
    background:#f1f3f5;
    color:#333;
    text-decoration:none
}

/* ---------- TABLE ---------- */
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
    padding:14px;
    text-align:left
}
.notes-table td{
    padding:14px;
    border-bottom:1px solid #eee;
    vertical-align:top
}

/* ---------- ACTION LINKS ---------- */
.action-links a{
    display:inline-block;
    margin:4px 0;
    font-size:13px;
    font-weight:600;
    text-decoration:none
}
.action-preview{color:#0d6efd}
.action-edit{color:#198754}
.action-delete{color:#dc3545}

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
    margin:26px 0;
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
    color:#fff;
    font-weight:600
}
.pagination a:hover{background:#cfe2ff}

/* ---------- RESPONSIVE ---------- */
@media(max-width:768px){
    .notes-table{display:none}
    .note-cards{display:block}
    .filter-box form{flex-direction:column}
    .filter-box button,
    .filter-box a{width:100%;text-align:center}
}
</style>

<h2>📚 My Uploaded Notes</h2>
<p style="color:#555;">View, preview, and manage notes you have uploaded.</p>

<!-- FILTER -->
<div class="filter-box">
<form method="get">

<select name="class_id">
    <option value="">All Classes</option>
    <?php while($c=$classes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>" <?= $filterClass==$c['id']?'selected':'' ?>>
            <?= esc($c['class_name']) ?>
        </option>
    <?php endwhile; ?>
</select>

<select name="subject_id">
    <option value="">All Subjects</option>
    <?php while($s=$subjects->fetch_assoc()): ?>
        <option value="<?= $s['id'] ?>" <?= $filterSubject==$s['id']?'selected':'' ?>>
            <?= esc($s['subject_name']) ?>
        </option>
    <?php endwhile; ?>
</select>

<button>Apply Filter</button>
<a href="view-notes.php">Reset</a>

</form>
</div>

<?php if($notes->num_rows===0): ?>
<p style="color:#777;">No notes found.</p>
<?php else: ?>

<!-- ================= DESKTOP ================= -->
<table class="notes-table">
<thead>
<tr>
    <th>Title</th>
    <th>Class</th>
    <th>Subject</th>
    <th>Files</th>
    <th>Date</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>

<?php while($n=$notes->fetch_assoc()): ?>
<?php
$files=$conn->query("
    SELECT drive_link 
    FROM subject_note_files 
    WHERE note_id={$n['id']}
");
?>
<tr>
<td><?= esc($n['title']) ?></td>
<td><?= esc($n['class_name']) ?></td>
<td><?= esc($n['subject_name']) ?></td>
<td>
<?php while($f=$files->fetch_assoc()): ?>
<a href="<?= esc($f['drive_link']) ?>" target="_blank">📎 View</a><br>
<?php endwhile; ?>
</td>
<td><?= date('d M Y',strtotime($n['created_at'])) ?></td>
<td class="action-links">
<a class="action-preview" href="note-preview.php?id=<?= $n['id'] ?>" target="_blank">👁 Preview</a><br>
<a class="action-edit" href="edit-note.php?id=<?= $n['id'] ?>">✏️ Edit</a><br>
<a class="action-delete"
   href="delete-note.php?id=<?= $n['id'] ?>"
   onclick="return confirm('Delete this note and all files?')">🗑 Delete</a>
</td>
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
🎓 <?= esc($n['class_name']) ?><br>
📘 <?= esc($n['subject_name']) ?><br>
📅 <?= date('d M Y',strtotime($n['created_at'])) ?>
</div>
<a class="action-preview" href="note-preview.php?id=<?= $n['id'] ?>" target="_blank">👁 Preview</a> |
<a class="action-edit" href="edit-note.php?id=<?= $n['id'] ?>">✏️ Edit</a> |
<a class="action-delete" href="delete-note.php?id=<?= $n['id'] ?>"
   onclick="return confirm('Delete this note?')">🗑</a>
</div>
<?php endwhile; ?>
</div>

<!-- ================= PAGINATION ================= -->
<div class="pagination">
<?php
$q=$_GET;
for($p=1;$p<=$totalPages;$p++):
$q['page']=$p;
?>
<a href="?<?= http_build_query($q) ?>" class="<?= $p==$page?'active':'' ?>">
<?= $p ?>
</a>
<?php endfor; ?>
</div>

<?php endif; ?>

<?php include '../partials/portal_footer.php'; ?>
