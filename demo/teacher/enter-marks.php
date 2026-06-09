<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

/* ---------------------------------------
   VALIDATE EXAM
--------------------------------------- */
$exam_id = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
if (!$exam_id) {
    echo "<h3 style='color:red;'>No exam selected.</h3>";
    include '../partials/portal_footer.php';
    exit;
}

$user_id = $_SESSION['user_id'];

/* ---------------------------------------
   GET TEACHER CLASS & SECTION
--------------------------------------- */
$stmt = $conn->prepare("
    SELECT tc.class_id, tc.section_id
    FROM teacher_classes tc
    JOIN teachers t ON tc.teacher_id = t.id
    WHERE t.user_id = ?
    LIMIT 1
");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$res = $stmt->get_result();
$teacherClass = $res->fetch_assoc();
$res->free();
$stmt->close();

if (!$teacherClass) {
    echo "<h3 style='color:red;'>No class assigned to this teacher.</h3>";
    include '../partials/portal_footer.php';
    exit;
}

$class_id   = (int)$teacherClass['class_id'];
$section_id = (int)$teacherClass['section_id'];

/* ---------------------------------------
   GET SUBJECTS FOR EXAM + CLASS
--------------------------------------- */
$stmt = $conn->prepare("
    SELECT es.subject_id, s.subject_name, es.max_marks, es.pass_marks
    FROM exam_subjects es
    JOIN subjects s ON s.id = es.subject_id
    WHERE es.exam_id = ? AND es.class_id = ?
");
$stmt->bind_param('ii', $exam_id, $class_id);
$stmt->execute();
$subjects = $stmt->get_result();

if ($subjects->num_rows === 0) {
    echo "<h3 style='color:red;'>No subjects found for this exam and class.</h3>";
    include '../partials/portal_footer.php';
    exit;
}

/* ---------------------------------------
   GET STUDENTS
--------------------------------------- */
$stmt2 = $conn->prepare("
    SELECT id, admission_no, first_name, last_name
    FROM students
    WHERE class_id = ? AND section_id = ?
    ORDER BY first_name
");
$stmt2->bind_param('ii', $class_id, $section_id);
$stmt2->execute();
$students = $stmt2->get_result();

if ($students->num_rows === 0) {
    echo "<h3 style='color:red;'>No students found for this class.</h3>";
    include '../partials/portal_footer.php';
    exit;
}
?>

<h2>📝 Enter Marks</h2>

<div style="background:white;padding:20px;border-radius:10px;max-width:900px">

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
            <?= esc($s['subject_name']) ?> (Max: <?= $s['max_marks'] ?>)
        </option>
    <?php endwhile; ?>
</select>

<br><br>

<div id="marksArea" style="margin-top:15px;"></div>

</form>
</div>

<script>
document.getElementById("subjectSelect").addEventListener("change", function () {
    let subjectId = this.value;
    if (!subjectId) {
        document.getElementById("marksArea").innerHTML = "";
        return;
    }

    fetch(
        "backend/load_marks.php?exam_id=<?= $exam_id ?>&class_id=<?= $class_id ?>&section_id=<?= $section_id ?>&subject_id=" + subjectId
    )
    .then(response => response.text())
    .then(html => {
        document.getElementById("marksArea").innerHTML = html;
    })
    .catch(err => {
        document.getElementById("marksArea").innerHTML =
            "<p style='color:red;'>Failed to load marks.</p>";
    });
});
</script>

<?php
$subjects->free();
$students->free();
$stmt2->close();
include '../partials/portal_footer.php';
?>
