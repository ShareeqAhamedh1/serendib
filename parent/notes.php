<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

/* ===============================
   LOGGED-IN PARENT
================================ */
$user_id = $_SESSION['user_id'];

$parent = $conn->query("
    SELECT id 
    FROM parents 
    WHERE user_id = $user_id
    LIMIT 1
")->fetch_assoc();

$parent_id = $parent['id'] ?? 0;

/* ===============================
   CHILDREN
================================ */
$children = $conn->query("
    SELECT id, first_name, last_name, class_id
    FROM students
    WHERE parent_id = $parent_id
");

/* ===============================
   FILTER INPUT
================================ */
$student_id = (int)($_GET['student_id'] ?? 0);
$subject_id = (int)($_GET['subject_id'] ?? 0);

/* ===============================
   GET SELECTED CHILD
================================ */
$child = null;
$class_id = 0;

if ($student_id) {
    $child = $conn->query("
        SELECT id, first_name, last_name, class_id
        FROM students
        WHERE id = $student_id
          AND parent_id = $parent_id
        LIMIT 1
    ")->fetch_assoc();

    $class_id = $child['class_id'] ?? 0;
}

/* ===============================
   SUBJECTS (CLASS BASED)
================================ */
$subjects = [];
if ($class_id) {
    $subjects = $conn->query("
        SELECT DISTINCT s.id, s.subject_name
        FROM subject_notes n
        JOIN subjects s ON s.id = n.subject_id
        WHERE n.class_id = $class_id
    ");
}

/* ===============================
   NOTES
================================ */
$notes = null;
if ($class_id) {

    $where = "WHERE n.class_id = $class_id";

    if ($subject_id) {
        $where .= " AND n.subject_id = $subject_id";
    }

    $notes = $conn->query("
        SELECT 
            n.*, s.subject_name
        FROM subject_notes n
        JOIN subjects s ON s.id = n.subject_id
        $where
        ORDER BY n.created_at DESC
    ");
}
?>

<style>
/* ===============================
   FILTER BOX
================================ */
.filter-box{
    background:white;
    padding:16px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    margin-bottom:20px
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
    background:#004080;
    color:white;
    border:none;
    font-weight:600
}
.filter-box a{
    background:#e9ecef;
    color:#333;
    text-decoration:none
}

/* ===============================
   TABLE
================================ */
.notes-table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 8px 22px rgba(0,0,0,.08)
}
.notes-table th{
    background:#004080;
    color:white;
    padding:14px
}
.notes-table td{
    padding:14px;
    border-bottom:1px solid #eee
}

/* ===============================
   MOBILE CARDS
================================ */
.note-cards{display:none}

.note-card{
    background:white;
    padding:18px;
    border-radius:18px;
    box-shadow:0 8px 22px rgba(0,0,0,.08);
    margin-bottom:16px
}
.note-card h4{
    color:#004080;
    margin-bottom:6px
}
.note-meta{
    font-size:14px;
    color:#555;
    margin-bottom:10px
}
.note-actions a{
    display:inline-block;
    margin-top:8px;
    background:#004080;
    color:white;
    padding:8px 14px;
    border-radius:20px;
    font-size:13px;
    text-decoration:none
}

/* ===============================
   RESPONSIVE
================================ */
@media(max-width:768px){
    .notes-table{display:none}
    .note-cards{display:block}
    .filter-box form{flex-direction:column}
    .filter-box button,
    .filter-box a{width:100%;text-align:center}
}
</style>

<h2>📘 Children Notes</h2>
<p style="color:#555;">Study materials shared by teachers.</p>

<!-- ================= FILTER ================= -->
<div class="filter-box">
<form method="get">

<select name="student_id" required>
    <option value="">Select Child</option>
    <?php while($c = $children->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>" <?= $student_id==$c['id']?'selected':'' ?>>
            <?= esc($c['first_name'].' '.$c['last_name']) ?>
        </option>
    <?php endwhile; ?>
</select>

<select name="subject_id">
    <option value="">All Subjects</option>
    <?php if ($subjects): while($s=$subjects->fetch_assoc()): ?>
        <option value="<?= $s['id'] ?>" <?= $subject_id==$s['id']?'selected':'' ?>>
            <?= esc($s['subject_name']) ?>
        </option>
    <?php endwhile; endif; ?>
</select>

<button>Filter</button>
<a href="notes.php">Reset</a>

</form>
</div>

<?php if (!$student_id): ?>
<p style="color:#777;">Select a child to view notes.</p>

<?php elseif (!$notes || $notes->num_rows === 0): ?>
<p style="color:#777;">No notes available.</p>

<?php else: ?>

<!-- ================= DESKTOP TABLE ================= -->
<table class="notes-table">
<thead>
<tr>
    <th>Title</th>
    <th>Subject</th>
    <th>Date</th>
    <th>Action</th>
</tr>
</thead>
<tbody>

<?php while($n = $notes->fetch_assoc()): ?>
<tr>
    <td><?= esc($n['title']) ?></td>
    <td><?= esc($n['subject_name']) ?></td>
    <td><?= date('d M Y', strtotime($n['created_at'])) ?></td>
    <td>
        <a href="note-preview.php?id=<?= $n['id'] ?>" target="_blank">
            👁 Preview
        </a>
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
        📘 <?= esc($n['subject_name']) ?><br>
        📅 <?= date('d M Y', strtotime($n['created_at'])) ?>
    </div>
    <div class="note-actions">
        <a href="note-preview.php?id=<?= $n['id'] ?>" target="_blank">
            👁 Preview
        </a>
    </div>
</div>
<?php endwhile; ?>
</div>

<?php endif; ?>

<?php include '../partials/portal_footer.php'; ?>
