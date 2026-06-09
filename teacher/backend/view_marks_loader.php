<?php
require_once __DIR__ . '/../../backend/conn.php';

$exam_id    = (int)($_GET['exam_id'] ?? 0);
$subject_id = (int)($_GET['subject_id'] ?? 0);
$user_id    = $_SESSION['user_id'] ?? 0;

if ($exam_id == 0 || $subject_id == 0) {
    echo "<p style='color:red;'>Invalid exam or subject.</p>";
    exit;
}

// ✅ Teacher Class & Section
$cq = $conn->query("
    SELECT tc.class_id, tc.section_id
    FROM teacher_classes tc
    JOIN teachers t ON t.id = tc.teacher_id
    WHERE t.user_id = $user_id
")->fetch_assoc();

$class_id   = $cq['class_id'];
$section_id = $cq['section_id'];

// ✅ Subject Info
$sub = $conn->query("
    SELECT s.subject_name, es.max_marks, es.pass_marks
    FROM exam_subjects es
    JOIN subjects s ON es.subject_id = s.id
    WHERE es.exam_id = $exam_id 
      AND es.class_id = $class_id 
      AND es.subject_id = $subject_id
")->fetch_assoc();

$max  = $sub['max_marks'];
$pass = $sub['pass_marks'];

// ✅ Students + Marks
$marks = $conn->query("
    SELECT 
        st.id,
        st.admission_no,
        st.first_name, st.last_name,
        em.marks_obtained,
        em.grade,
        em.status
    FROM students st
    LEFT JOIN exam_marks em 
        ON em.student_id = st.id 
       AND em.exam_id = $exam_id 
       AND em.subject_id = $subject_id
    WHERE st.class_id = $class_id 
      AND st.section_id = $section_id
    ORDER BY st.first_name
");
?>

<h3>📘 <?= htmlspecialchars($sub['subject_name']) ?> — Mark Sheet</h3>

<p><b>Max Marks:</b> <?= $max ?> &nbsp; | &nbsp;
<b>Pass Marks:</b> <?= $pass ?></p>

<table border="1" cellpadding="8" style="width:100%;border-collapse:collapse;background:white;">
<thead style="background:#007bff;color:white;">
<tr>
    <th>Adm No</th>
    <th>Name</th>
    <th>Marks</th>
    <th>Grade</th>
    <th>Status</th>
</tr>
</thead>
<tbody>

<?php
$all = [];
while ($m = $marks->fetch_assoc()):
    $all[] = $m;

    // ✅ Normalize status (handle uppercase/lowercase from DB)
    $status = strtolower($m['status'] ?? '');
?>
<tr>
    <td><?= htmlspecialchars($m['admission_no']) ?></td>
    <td><?= htmlspecialchars($m['first_name'].' '.$m['last_name']) ?></td>
    <td><?= htmlspecialchars($m['marks_obtained'] ?? '-') ?></td>
    <td><?= htmlspecialchars($m['grade'] ?? '-') ?></td>
    <td>
        <?php if($status === 'pass'): ?>
            <span style="color:green;font-weight:bold">Pass</span>
        <?php elseif($status === 'fail'): ?>
            <span style="color:red;font-weight:bold">Fail</span>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<?php
// ✅ Summary analytics
$marksOnly = array_column($all, 'marks_obtained');
$marksOnly = array_filter($marksOnly, fn($v) => $v !== null && $v !== "");

if (count($marksOnly) > 0) {
    $highest = max($marksOnly);
    $average = round(array_sum($marksOnly) / count($marksOnly), 2);

    // ✅ Count passes using lowercase compare
    $passCount = count(array_filter($all, fn($r) => strtolower($r['status'] ?? '') === 'pass'));

    $total = count($all);
    $passRate = $total > 0 ? round(($passCount / $total) * 100, 2) : 0;
?>
<br>

<h3>📈 Performance Summary</h3>
<table cellpadding="6">
<tr><td><b>Highest Marks</b></td><td><?= $highest ?></td></tr>
<tr><td><b>Class Average</b></td><td><?= $average ?></td></tr>
<tr><td><b>Pass Rate</b></td><td><?= $passRate ?>%</td></tr>
</table>

<?php } ?>
