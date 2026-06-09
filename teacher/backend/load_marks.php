<?php
require_once __DIR__ . '/../../backend/conn.php';
require_once __DIR__ . '/../../backend/helpers.php';

if (!isset($_GET['exam_id']) || !isset($_GET['subject_id'])) {
    exit("<p style='color:red'>Invalid request.</p>");
}

$exam_id    = (int)$_GET['exam_id'];
$subject_id = (int)$_GET['subject_id'];

// Get teacher → class_id + section_id
$user_id = $_SESSION['user_id'];
$tq = $conn->query("
    SELECT tc.class_id, tc.section_id
    FROM teachers t 
    JOIN teacher_classes tc ON tc.teacher_id = t.id
    WHERE t.user_id=$user_id
    LIMIT 1
");

$tc = $tq->fetch_assoc();
$class_id   = $tc['class_id'];
$section_id = $tc['section_id'];

// Get max marks + pass marks
$subq = $conn->query("
    SELECT max_marks, pass_marks 
    FROM exam_subjects 
    WHERE exam_id=$exam_id 
    AND class_id=$class_id 
    AND subject_id=$subject_id
");
$ss = $subq->fetch_assoc();

$max = $ss['max_marks'];
$pass = $ss['pass_marks'];

// Get students
$stu = $conn->query("
    SELECT id, admission_no, first_name, last_name
    FROM students
    WHERE class_id=$class_id AND section_id=$section_id
    ORDER BY first_name
");

// Get existing marks
$marksQuery = $conn->query("
    SELECT student_id, marks_obtained
    FROM exam_marks
    WHERE exam_id=$exam_id AND subject_id=$subject_id
");
$existing = [];
while ($m = $marksQuery->fetch_assoc()) {
    $existing[$m['student_id']] = $m['marks_obtained'];
}
?>

<h3>Marks Entry</h3>
<p><b>Subject Max Marks:</b> <?= $max ?> | <b>Pass Marks:</b> <?= $pass ?></p>

<table border="1" cellpadding="8" style="width:100%;border-collapse:collapse;">
<thead style="background:#007bff;color:white;">
<tr>
  <th>#</th>
  <th>Admission No</th>
  <th>Name</th>
  <th>Marks (0 - <?= $max ?>)</th>
</tr>
</thead>
<tbody>

<?php 
$i=1; 
while($s = $stu->fetch_assoc()): 
    $sid = $s['id'];
    $prev = $existing[$sid] ?? "";
?>
<tr>
  <td><?= $i++ ?></td>
  <td><?= htmlspecialchars($s['admission_no']) ?></td>
  <td><?= htmlspecialchars($s['first_name'] . " " . $s['last_name']) ?></td>
  <td>
    <input 
      type="number" 
      name="marks[<?= $sid ?>]" 
      value="<?= $prev ?>" 
      min="0" 
      max="<?= $max ?>" 
      style="width:80px;padding:6px;"
    >
  </td>
</tr>
<?php endwhile; ?>

</tbody>
</table>

<br>
<button class="btn btn-primary" style="padding:10px 20px;">💾 Save Marks</button>
