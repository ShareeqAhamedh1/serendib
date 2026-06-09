<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

if (!isset($_GET['id'])) {
    echo "<p style='color:red;'>Invalid student.</p>";
    include '../partials/portal_footer.php';
    exit;
}

$student_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

/* ---------------------------------------------------------
   ✅ Verify that teacher has access to this student
----------------------------------------------------------- */
$q = $conn->query("
    SELECT tc.class_id, tc.section_id
    FROM teacher_classes tc
    JOIN teachers t ON t.id = tc.teacher_id
    WHERE t.user_id = $user_id
    LIMIT 1
");
$classData = $q->fetch_assoc();

if (!$classData) {
    echo "<p style='color:red;'>No assigned class.</p>";
    include '../partials/portal_footer.php';
    exit;
}

$class_id = $classData['class_id'];
$section_id = $classData['section_id'];

// ✅ Fetch student, but only if they belong to teacher's class
$stu = $conn->query("
    SELECT s.*, c.class_name, sec.section_name
    FROM students s
    JOIN classes c ON c.id = s.class_id
    JOIN sections sec ON sec.id = s.section_id
    WHERE s.id = $student_id
      AND s.class_id = $class_id
      AND s.section_id = $section_id
    LIMIT 1
")->fetch_assoc();

if (!$stu) {
    echo "<p style='color:red;'>You are not allowed to view this student.</p>";
    include '../partials/portal_footer.php';
    exit;
}

/* ---------------------------------------------------------
   ✅ Attendance Summary
----------------------------------------------------------- */
$att = $conn->query("
    SELECT 
      SUM(LOWER(status)='present') AS present_days,
      SUM(LOWER(status)='absent') AS absent_days
    FROM attendance
    WHERE entity_type='student' AND entity_id=$student_id
")->fetch_assoc();


/* ---------------------------------------------------------
   ✅ Latest 5 Exam Marks
----------------------------------------------------------- */
$marks = $conn->query("
    SELECT 
        e.exam_name,
        e.term,
        s.subject_name,
        m.marks_obtained,
        m.grade,
        m.status
    FROM exam_marks m
    JOIN exams e ON e.id = m.exam_id
    JOIN subjects s ON s.id = m.subject_id
    WHERE m.student_id = $student_id
    ORDER BY e.start_date DESC
    LIMIT 5
");

?>

<style>
.card{background:#fff;padding:22px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.08);max-width:900px;margin:auto;}
.header{display:flex;align-items:center;gap:20px;}
.header img{width:100px;height:100px;border-radius:12px;object-fit:cover;}
.kv{width:100%;border-collapse:collapse;margin-top:10px;}
.kv td{padding:8px;border-bottom:1px solid #eee;}
.kv td:first-child{font-weight:bold;width:180px;color:#333;}
.section-title{margin-top:25px;font-size:20px;font-weight:bold;}
</style>

<h2>👁 Student Details</h2>

<div class="card">

    <!-- ✅ Basic Header -->
    <div class="header">
        <img src="../uploads/<?= $stu['photo'] ?: 'default.png' ?>">
        <div>
            <h3 style="margin:0;"><?= esc($stu['first_name'].' '.$stu['last_name']) ?></h3>
            <div>Admission No: <b><?= esc($stu['admission_no']) ?></b></div>
            <div><?= esc($stu['class_name']) ?> - <?= esc($stu['section_name']) ?></div>
        </div>
    </div>

    <!-- ✅ Basic Info -->
    <h3 class="section-title">📄 Basic Info</h3>
    <table class="kv">
        <tr><td>Gender</td><td><?= esc(ucfirst($stu['gender'])) ?></td></tr>
        <tr><td>DOB</td><td><?= esc($stu['dob']) ?></td></tr>
        <tr><td>Address</td><td><?= esc($stu['address']) ?></td></tr>
        <tr><td>Status</td><td><?= esc($stu['status']) ?></td></tr>
    </table>

    <!-- ✅ Attendance -->
    <h3 class="section-title">📅 Attendance Summary</h3>
    <table class="kv">
        <tr><td>Present Days</td><td><?= (int)$att['present_days'] ?></td></tr>
        <tr><td>Absent Days</td><td><?= (int)$att['absent_days'] ?></td></tr>
    </table>

    <!-- ✅ Latest Marks -->
    <h3 class="section-title">📝 Recent Marks</h3>
    <table class="kv">
        <?php if ($marks->num_rows == 0): ?>
            <tr><td colspan="2"><i>No marks available.</i></td></tr>
        <?php else: ?>
            <?php while($m = $marks->fetch_assoc()): ?>
                <tr>
                    <td>
                        <b><?= esc($m['subject_name']) ?></b><br>
                        <span style="color:#666"><?= esc($m['exam_name']) ?> (<?= esc($m['term']) ?>)</span>
                    </td>
                    <td>
                        <?= esc($m['marks_obtained']) ?> — <b><?= esc($m['grade']) ?></b>
                        <?php if ($m['status'] == 'Pass'): ?>
                            <span style="color:green">✔ Pass</span>
                        <?php else: ?>
                            <span style="color:red">✘ Fail</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>

</div>

<p style="margin-top:20px;">
    <a class="btn-sm" href="class-students.php">⬅ Back to My Students</a>
</p>

<?php include '../partials/portal_footer.php'; ?>
