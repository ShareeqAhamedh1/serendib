<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

$student_id = (int)($_GET['id'] ?? 0);
if ($student_id <= 0) {
    echo "<p style='color:red;'>Invalid student ID.</p>";
    exit;
}

// ✅ Fetch student details
$q = "
  SELECT s.*, 
         c.class_name, sec.section_name, 
         p.full_name AS parent_name, p.email AS parent_email, p.phone AS parent_phone
  FROM students s
  LEFT JOIN classes c ON s.class_id = c.id
  LEFT JOIN sections sec ON s.section_id = sec.id
  LEFT JOIN parents p ON s.parent_id = p.id
  WHERE s.id = ?
";
$stmt = $conn->prepare($q);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    echo "<p style='color:red;'>Student not found.</p>";
    exit;
}

// ✅ Fetch fees summary
$feeSummary = $conn->query("
    SELECT 
      SUM(sf.amount) AS total_fee,
      SUM(fp.paid_amount) AS total_paid
    FROM student_fees sf
    LEFT JOIN fee_payments fp ON sf.id = fp.student_fee_id
    WHERE sf.student_id = $student_id
")->fetch_assoc();

$totalFee = $feeSummary['total_fee'] ?? 0;
$totalPaid = $feeSummary['total_paid'] ?? 0;
$totalBalance = $totalFee - $totalPaid;

// ✅ Fetch attendance summary
$att = $conn->query("
    SELECT 
      SUM(LOWER(TRIM(status)) = 'present') AS present_days,
      SUM(LOWER(TRIM(status)) = 'absent') AS absent_days
    FROM attendance
    WHERE entity_type='student' AND entity_id=$student_id
")->fetch_assoc();


// ✅ Fetch latest exam marks
$marks = $conn->query("
    SELECT 
        e.exam_name,
        e.term,
        e.start_date,
        s.subject_name,
        m.marks_obtained,
        es.max_marks,
        es.pass_marks
    FROM exam_marks m
    JOIN exams e 
        ON m.exam_id = e.id
    JOIN subjects s 
        ON m.subject_id = s.id
    LEFT JOIN exam_subjects es 
        ON es.exam_id = m.exam_id 
        AND es.subject_id = m.subject_id
        AND es.class_id = m.class_id  -- ✅ Missing earlier!
    WHERE m.student_id = $student_id
    ORDER BY e.start_date DESC
    LIMIT 5
");


?>

<style>
.profile-card {
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 1px 5px rgba(0,0,0,0.1);
    max-width:900px;
    margin-bottom:25px;
}
.section-title {
    margin-top:25px;
    font-size:20px;
    font-weight:bold;
}
.info-table th { width:180px; text-align:left; color:#333; }
.info-table td { color:#555; }
.badge { padding:5px 10px; border-radius:6px; }
.badge-green { background:#d4edda; color:#155724; }
.badge-red { background:#f8d7da; color:#721c24; }
</style>


<h2>👨‍🎓 Student Profile</h2>

<div class="profile-card">

    <!-- ✅ Student Header -->
    <div style="display:flex; align-items:center; gap:20px;">
        <img src="<?= BASE_URL ?>uploads/<?= $student['photo'] ?: 'default.png' ?>" 
             style="width:90px;height:90px;border-radius:8px;object-fit:cover;">
        
        <div>
            <h2 style="margin:0;"><?= esc($student['first_name'].' '.$student['last_name']) ?></h2>
            <p style="margin:3px 0;color:#666;">Admission No: <b><?= esc($student['admission_no']) ?></b></p>
            <span class="badge badge-green"><?= esc($student['class_name']) ?> - <?= esc($student['section_name']) ?></span>
        </div>

        <div style="margin-left:auto;">
            <a href="edit-student.php?id=<?= $student_id ?>" class="btn btn-sm btn-primary">✏ Edit</a>
            <a href="<?= BASE_URL ?>backend/students.php?action=delete&id=<?= $student_id ?>"
               onclick="return confirm('Delete this student?')" 
               class="btn btn-sm btn-danger">🗑 Delete</a>
        </div>
    </div>

    <hr>

    <!-- ✅ Basic Info -->
    <h3 class="section-title">📄 Basic Information</h3>
    <table class="info-table" cellpadding="8">
        <tr><th>Gender:</th><td><?= esc($student['gender']) ?></td></tr>
        <tr><th>DOB:</th><td><?= esc($student['dob']) ?></td></tr>
        <tr><th>Address:</th><td><?= esc($student['address']) ?></td></tr>
    </table>

    <!-- ✅ Parent Info -->
    <h3 class="section-title">👨‍👩‍👧 Parent Details</h3>
    <table class="info-table" cellpadding="8">
        <tr><th>Name:</th><td><?= esc($student['parent_name'] ?: '-') ?></td></tr>
        <tr><th>Email:</th><td><?= esc($student['parent_email'] ?: '-') ?></td></tr>
        <tr><th>Phone:</th><td><?= esc($student['parent_phone'] ?: '-') ?></td></tr>
    </table>

    <!-- ✅ Fee Summary -->
    <h3 class="section-title">💰 Fee Summary</h3>
    <table class="info-table" cellpadding="8">
        <tr><th>Total Fees:</th><td><b><?= number_format($totalFee,2) ?></b></td></tr>
        <tr><th>Total Paid:</th><td><?= number_format($totalPaid,2) ?></td></tr>
        <tr><th>Balance:</th><td style="color:red;"><b><?= number_format($totalBalance,2) ?></b></td></tr>
    </table>

    <!-- ✅ Attendance Summary -->
    <h3 class="section-title">📅 Attendance</h3>
    <table class="info-table" cellpadding="8">
        <tr><th>Present Days:</th><td><?= (int)$att['present_days'] ?></td></tr>
        <tr><th>Absent Days:</th><td><?= (int)$att['absent_days'] ?></td></tr>
    </table>

<!-- ✅ Last Few Marks -->
<h3 class="section-title">📝 Recent Marks</h3>
<table cellpadding="8" style="width:100%;border-collapse:collapse;">
    <thead>
    <tr style="background:#007bff;color:white;">
        <th>Exam</th>
        <th>Term</th>
        <th>Subject</th>
        <th>Marks</th>
        <th>Max Marks</th>
        <th>Pass Marks</th>
    </tr>
    </thead>

    <tbody>
    <?php if (!$marks || $marks->num_rows == 0): ?>
        <tr><td colspan="6" align="center" style="color:gray;">No marks available.</td></tr>

    <?php else: ?>
        <?php while($m = $marks->fetch_assoc()): ?>

            <?php
            // Format term
$termRaw = strtolower(trim($m['term']));

$termLabel = "-";
if ($termRaw === "term 1") $termLabel = "Term 1";
if ($termRaw === "term 2") $termLabel = "Term 2";
if ($termRaw === "term 3") $termLabel = "Term 3";

            ?>

            <tr>
                <td><?= esc($m['exam_name']) ?></td>
                <td><?= $termLabel ?></td>
                <td><?= esc($m['subject_name']) ?></td>
                <td><?= esc($m['marks_obtained']) ?></td>
                <td><?= esc($m['max_marks'] ?: '-') ?></td>
                <td><?= esc($m['pass_marks'] ?: '-') ?></td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
    </tbody>

</table>



</div>

<p><a href="students.php" style="color:#007bff;">⬅ Back to Student List</a></p>

<?php include 'partials/footer.php'; ?>
