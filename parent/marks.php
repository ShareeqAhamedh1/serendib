<?php
include '../partials/portal_header.php';
require_once __DIR__ . '../../backend/conn.php';

$parentRes = $conn->query("
    SELECT id FROM parents WHERE user_id = {$_SESSION['user_id']}
");
$parent_id = $parentRes->fetch_assoc()['id'];
$parentRes->free();

$students = $conn->query("
    SELECT id, first_name, last_name
    FROM students
    WHERE parent_id = $parent_id
");
?>

<style>
/* ---------- LAYOUT ---------- */
.marks-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 15px;
}

/* ---------- FILTER ---------- */
.child-select {
    margin-bottom: 20px;
}

.child-select select {
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 14px;
}

/* ---------- TABLE ---------- */
.marks-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.marks-table th {
    background: #004080;
    color: white;
    padding: 12px;
    text-align: left;
}

.marks-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

/* ---------- VIEW BUTTON ---------- */
.view-btn {
    text-decoration: none;
    background: #004080;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 14px;
}

.view-btn:hover {
    background: #003060;
}

/* ---------- MOBILE CARDS ---------- */
.mobile-cards {
    display: none;
}

.mark-card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.mark-card h4 {
    color: #004080;
    margin-bottom: 8px;
}

.mark-card p {
    margin: 4px 0;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 768px) {
    .marks-table {
        display: none;
    }
    .mobile-cards {
        display: block;
    }
}
</style>

<div class="marks-container">

<h2>📊 Children Marks Overview</h2>

<form method="get" action="child-marks.php" class="child-select">
    <label><strong>Select Child:</strong></label>
    <select name="student_id" onchange="this.form.submit()" required>
        <option value="">-- Select Child --</option>
        <?php while ($s = $students->fetch_assoc()): ?>
            <option value="<?= $s['id'] ?>">
                <?= esc($s['first_name'].' '.$s['last_name']) ?>
            </option>
        <?php endwhile; ?>
    </select>
</form>

<!-- ================= DESKTOP TABLE ================= -->
<table class="marks-table">
<tr>
    <th>Child</th>
    <th>Total Subjects</th>
    <th>Total Marks</th>
    <th>Average</th>
    <th>View</th>
</tr>

<?php
$students->data_seek(0);

while ($s = $students->fetch_assoc()):

$stmt = $conn->prepare("
    SELECT 
        COUNT(*) AS subjects,
        SUM(marks_obtained) AS total_marks,
        AVG(marks_obtained) AS avg_marks
    FROM exam_marks
    WHERE student_id = ?
");
$stmt->bind_param('i', $s['id']);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

$res->free();
$stmt->close();
?>
<tr>
    <td><?= esc($s['first_name'].' '.$s['last_name']) ?></td>
    <td><?= $data['subjects'] ?? 0 ?></td>
    <td><?= $data['total_marks'] ?? 0 ?></td>
    <td><?= $data['avg_marks'] ? round($data['avg_marks'],1) : 0 ?></td>
    <td>
        <a class="view-btn" href="child-marks.php?student_id=<?= $s['id'] ?>">
            View
        </a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<!-- ================= MOBILE CARDS ================= -->
<div class="mobile-cards">
<?php
$students->data_seek(0);

while ($s = $students->fetch_assoc()):

$stmt = $conn->prepare("
    SELECT 
        COUNT(*) AS subjects,
        SUM(marks_obtained) AS total_marks,
        AVG(marks_obtained) AS avg_marks
    FROM exam_marks
    WHERE student_id = ?
");
$stmt->bind_param('i', $s['id']);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

$res->free();
$stmt->close();
?>
<div class="mark-card">
    <h4><?= esc($s['first_name'].' '.$s['last_name']) ?></h4>
    <p>📚 Subjects: <strong><?= $data['subjects'] ?? 0 ?></strong></p>
    <p>🧮 Total Marks: <strong><?= $data['total_marks'] ?? 0 ?></strong></p>
    <p>📈 Average: <strong><?= $data['avg_marks'] ? round($data['avg_marks'],1) : 0 ?></strong></p>
    <a class="view-btn" href="child-marks.php?student_id=<?= $s['id'] ?>">
        View Marks →
    </a>
</div>
<?php endwhile; ?>
</div>

</div>

<?php
$students->free();
include '../partials/portal_footer.php';
?>
