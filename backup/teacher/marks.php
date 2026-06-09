<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

// Get exams for teacher's class
$user_id = $_SESSION['user_id'];

$q = $conn->query("
    SELECT tc.class_id 
    FROM teacher_classes tc
    JOIN teachers t ON tc.teacher_id = t.id
    WHERE t.user_id=$user_id LIMIT 1
");

$c = $q->fetch_assoc();
$class_id = $c['class_id'];

$exams = $conn->query("SELECT id, exam_name, term FROM exams ORDER BY id DESC");
?>

<h2>📝 Marks Management</h2>

<div style="background:white;padding:20px;border-radius:10px;max-width:600px">

<label><b>Select Exam</b></label>
<select id="examSelect" style="padding:10px;width:100%;">
    <option value="">-- Select Exam --</option>
    <?php while($e = $exams->fetch_assoc()): ?>
        <option value="<?= $e['id'] ?>">
            <?= $e['exam_name'] ?> (Term <?= $e['term'] ?>)
        </option>
    <?php endwhile; ?>
</select>

<br><br>

<div id="actionButtons" style="display:none;">
    <a id="enterMarksBtn" class="btn" 
       style="padding:10px 15px;background:#007bff;color:white;border-radius:6px;text-decoration:none;">
       ➕ Enter Marks
    </a>

    <a id="viewMarksBtn" class="btn" 
       style="padding:10px 15px;background:#28a745;color:white;border-radius:6px;text-decoration:none;">
       📊 View Marks
    </a>
</div>

</div>

<script>
document.getElementById("examSelect").addEventListener("change", function() {
    let examId = this.value;

    if (examId === "") {
        document.getElementById("actionButtons").style.display = "none";
        return;
    }

    document.getElementById("actionButtons").style.display = "block";

    document.getElementById("enterMarksBtn").href = "enter-marks.php?exam_id=" + examId;
    document.getElementById("viewMarksBtn").href  = "view-marks.php?exam_id=" + examId;
});
</script>

<?php include '../partials/portal_footer.php'; ?>
