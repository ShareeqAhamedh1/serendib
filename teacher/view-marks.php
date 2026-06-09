<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

if (!isset($_GET['exam_id'])) {
    echo "<p style='color:red;'>No exam selected.</p>";
    include '../partials/portal_footer.php';
    exit;
}

$exam_id = (int)$_GET['exam_id'];
$user_id = $_SESSION['user_id'];

// Teacher's class_id + section_id
$tc = $conn->query("
    SELECT tc.class_id, tc.section_id 
    FROM teacher_classes tc 
    JOIN teachers t ON t.id = tc.teacher_id
    WHERE t.user_id=$user_id
")->fetch_assoc();

$class_id   = $tc['class_id'];
$section_id = $tc['section_id'];

// Fetch exam info
$exam = $conn->query("SELECT * FROM exams WHERE id=$exam_id")->fetch_assoc();

// Fetch subjects in this exam for this class
$subjects = $conn->query("
    SELECT es.subject_id, s.subject_name
    FROM exam_subjects es
    JOIN subjects s ON s.id=es.subject_id
    WHERE es.exam_id=$exam_id AND es.class_id=$class_id
");
?>

<h2>📊 Exam Marks – <?= htmlspecialchars($exam['exam_name']) ?></h2>

<div style="background:white;padding:20px;border-radius:10px">

<label><b>Select Subject</b></label>
<select id="subjectSelect" style="padding:8px;width:100%;">
    <option value="">-- Select Subject --</option>
    <?php while($s = $subjects->fetch_assoc()): ?>
        <option value="<?= $s['subject_id'] ?>">
            <?= htmlspecialchars($s['subject_name']) ?>
        </option>
    <?php endwhile; ?>
</select>

<br><br>

<div id="marksTable"></div>

</div>

<script>
document.getElementById("subjectSelect").addEventListener("change", function () {
    let sid = this.value;
    if (!sid) return;

    fetch("backend/view_marks_loader.php?exam_id=<?= $exam_id ?>&subject_id=" + sid)
        .then(res => res.text())
        .then(html => {
            document.getElementById("marksTable").innerHTML = html;
        });
});
</script>

<?php include '../partials/portal_footer.php'; ?>
