<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

$user_id = $_SESSION['user_id'];

/* ---------------------------------------
   GET TEACHER CLASS
--------------------------------------- */
$stmt = $conn->prepare("
    SELECT tc.class_id
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

/* ❌ NO CLASS ASSIGNED */
if (!$teacherClass) {
    echo "
        <h2>📝 Marks Management</h2>
        <div style='background:white;padding:20px;border-radius:10px;max-width:600px'>
            <p style='color:red; font-weight:bold;'>
                ⚠️ You are not assigned to any class yet.
            </p>
            <p>Please contact the administrator.</p>
        </div>
    ";
    include '../partials/portal_footer.php';
    exit;
}

$class_id = (int)$teacherClass['class_id'];

/* ---------------------------------------
   GET EXAMS
--------------------------------------- */
$exams = $conn->query("
    SELECT id, exam_name, term 
    FROM exams 
    ORDER BY id DESC
");
?>

<h2>📝 Marks Management</h2>

<div style="background:white;padding:20px;border-radius:10px;max-width:600px">

<label><b>Select Exam</b></label>
<select id="examSelect" style="padding:10px;width:100%;">
    <option value="">-- Select Exam --</option>
    <?php while ($e = $exams->fetch_assoc()): ?>
        <option value="<?= $e['id'] ?>">
            <?= esc($e['exam_name']) ?> (Term <?= esc($e['term']) ?>)
        </option>
    <?php endwhile; ?>
</select>

<br><br>

<div id="actionButtons" style="display:none;">
    <a id="enterMarksBtn"
       style="padding:10px 15px;background:#007bff;color:white;border-radius:6px;text-decoration:none;display:inline-block;margin-right:10px;">
       ➕ Enter Marks
    </a>

    <a id="viewMarksBtn"
       style="padding:10px 15px;background:#28a745;color:white;border-radius:6px;text-decoration:none;display:inline-block;">
       📊 View Marks
    </a>
</div>

</div>

<script>
document.getElementById("examSelect").addEventListener("change", function () {
    let examId = this.value;

    if (!examId) {
        document.getElementById("actionButtons").style.display = "none";
        return;
    }

    document.getElementById("actionButtons").style.display = "block";

    document.getElementById("enterMarksBtn").href =
        "enter-marks.php?exam_id=" + examId;

    document.getElementById("viewMarksBtn").href =
        "view-marks.php?exam_id=" + examId;
});
</script>

<?php include '../partials/portal_footer.php'; ?>
