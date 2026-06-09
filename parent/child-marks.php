<?php
include '../partials/portal_header.php';
require_once __DIR__ . '../../backend/conn.php';

$student_id = isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0;

if (!$student_id) {
    echo "<p style='color:red;'>No student selected.</p>";
    include '../partials/portal_footer.php';
    exit;
}

/* Student info */
$student = $conn->query("
    SELECT first_name, last_name 
    FROM students 
    WHERE id = $student_id
")->fetch_assoc();
?>

<style>
/* ---------- LAYOUT ---------- */
.marks-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 15px;
}

/* ---------- EXAM TITLE ---------- */
.exam-title {
    margin-top: 25px;
    color: #004080;
}

/* ---------- TABLE ---------- */
.marks-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    margin-top: 10px;
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

/* ---------- MOBILE CARDS ---------- */
.mobile-cards {
    display: none;
}

.subject-card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.subject-card h4 {
    color: #004080;
    margin-bottom: 8px;
}

.subject-card p {
    margin: 4px 0;
}

/* ---------- BADGE ---------- */
.grade-badge {
    padding: 4px 10px;
    border-radius: 10px;
    font-weight: bold;
    font-size: 13px;
    background: #e0f2fe;
    color: #075985;
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

<h2>📘 Marks Report</h2>
<h3>👦 <?= esc($student['first_name'].' '.$student['last_name']) ?></h3>

<?php
/* ---------------------------------------
   Get exams for this student
--------------------------------------- */
$examStmt = $conn->prepare("
    SELECT DISTINCT e.id, e.exam_name
    FROM exam_marks m
    JOIN exams e ON m.exam_id = e.id
    WHERE m.student_id = ?
    ORDER BY e.id
");
$examStmt->bind_param('i', $student_id);
$examStmt->execute();
$examRes = $examStmt->get_result();

/* NO EXAMS */
if ($examRes->num_rows === 0):
?>
    <p style="color:#555; margin-top:15px;">
        ❌ No exams found for this student.
    </p>
<?php
else:
while ($exam = $examRes->fetch_assoc()):
?>

<h4 class="exam-title">📌 <?= esc($exam['exam_name']) ?></h4>

<?php
$marksStmt = $conn->prepare("
    SELECT 
        sub.subject_name,
        m.marks_obtained,
        m.grade
    FROM exam_marks m
    JOIN subjects sub ON m.subject_id = sub.id
    WHERE m.student_id = ? AND m.exam_id = ?
");
$marksStmt->bind_param('ii', $student_id, $exam['id']);
$marksStmt->execute();
$marksRes = $marksStmt->get_result();

/* NO SUBJECTS */
if ($marksRes->num_rows === 0):
?>
    <p style="color:#777; margin-left:10px;">
        ⚠️ No subjects available for this exam.
    </p>
<?php
else:
?>

<!-- ================= DESKTOP TABLE ================= -->
<table class="marks-table">
<tr>
    <th>Subject</th>
    <th>Marks</th>
    <th>Grade</th>
</tr>

<?php
$total = 0;
$count = 0;

while ($row = $marksRes->fetch_assoc()):
    $total += $row['marks_obtained'];
    $count++;
?>
<tr>
    <td><?= esc($row['subject_name']) ?></td>
    <td><?= $row['marks_obtained'] ?></td>
    <td><span class="grade-badge"><?= esc($row['grade']) ?></span></td>
</tr>
<?php endwhile; ?>

<tr style="font-weight:bold;background:#f3f4f6;">
    <td>Average</td>
    <td colspan="2"><?= $count ? round($total / $count, 1) : 0 ?></td>
</tr>
</table>

<!-- ================= MOBILE CARDS ================= -->
<div class="mobile-cards">
<?php
$marksRes->data_seek(0);
$total = 0;
$count = 0;

while ($row = $marksRes->fetch_assoc()):
    $total += $row['marks_obtained'];
    $count++;
?>
<div class="subject-card">
    <h4><?= esc($row['subject_name']) ?></h4>
    <p>🧮 Marks: <strong><?= $row['marks_obtained'] ?></strong></p>
    <p>🎓 Grade: <span class="grade-badge"><?= esc($row['grade']) ?></span></p>
</div>
<?php endwhile; ?>

<div class="subject-card" style="background:#f3f4f6;">
    <strong>Average:</strong> <?= $count ? round($total / $count, 1) : 0 ?>
</div>
</div>

<?php
endif;

$marksRes->free();
$marksStmt->close();

endwhile;
endif;

$examRes->free();
$examStmt->close();
?>

</div>

<?php include '../partials/portal_footer.php'; ?>
