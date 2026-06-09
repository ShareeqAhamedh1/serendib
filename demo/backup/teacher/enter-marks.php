<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

if (!isset($_GET['exam_id'])) {
    echo "<h3 style='color:red;'>No exam selected.</h3>";
    include '../partials/portal_footer.php';
    exit;
}

$exam_id = (int)$_GET['exam_id'];
$user_id = $_SESSION['user_id'];

// Teacher class
$q = $conn->query("
    SELECT tc.class_id, tc.section_id
    FROM teacher_classes tc
    JOIN teachers t ON tc.teacher_id = t.id
    WHERE t.user_id = $user_id LIMIT 1
");
$c = $q->fetch_assoc();
$class_id = $c['class_id'];
$section_id = $c['section_id'];

// Subjects for this exam
$subjects = $conn->query("
    SELECT es.subject_id, s.subject_name, es.max_marks, es.pass_marks
    FROM exam_subjects es
    JOIN subjects s ON s.id = es.subject_id
    WHERE es.exam_id=$exam_id AND es.class_id=$class_id
");

// Students
$students = $conn->query("
    SELECT id, admission_no, first_name, last_name
    FROM students
    WHERE class_id=$class_id AND section_id=$section_id
    ORDER BY first_name
");

?>
<h2>📝 Enter Marks</h2>

<div style="background:white;padding:20px;border-radius:10px">

<form method="post" action="backend/save_marks.php">

<?= csrf_field() ?>
<input type="hidden" name="exam_id" value="<?= $exam_id ?>">
<input type="hidden" name="class_id" value="<?= $class_id ?>">
<input type="hidden" name="section_id" value="<?= $section_id ?>">

<label><b>Select Subject</b></label>
<select name="subject_id" required style="padding:8px;width:100%;" id="subjectSelect">
    <option value="">-- Select Subject --</option>
    <?php while($s = $subjects->fetch_assoc()): ?>
        <option value="<?= $s['subject_id'] ?>">
            <?= $s['subject_name'] ?> (Max: <?= $s['max_marks'] ?>)
        </option>
    <?php endwhile; ?>
</select>

<br><br>

<div id="marksArea"></div>

</form>
</div>

<script>
// Load marks automatically when subject changes
document.getElementById("subjectSelect").addEventListener("change", function() {
    let sid = this.value;
    if (sid === "") return;

    fetch("backend/load_marks.php?exam_id=<?= $exam_id ?>&subject_id=" + sid)
    .then(res => res.text())
    .then(html => {
        document.getElementById("marksArea").innerHTML = html;
    });
});
</script>

<?php include '../partials/portal_footer.php'; ?>
