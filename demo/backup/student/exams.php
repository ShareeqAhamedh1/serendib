<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

// Get logged-in student ID
$user_id = $_SESSION['user_id'];

$stuRes = $conn->query("SELECT id FROM students WHERE user_id = $user_id");
$stu = $stuRes->fetch_assoc();
$student_id = $stu['id'] ?? 0;

if (!$student_id) {
    echo "<p style='color:red;'>Student record not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

// ✅ Fetch exam marks using your REAL table structure
$sql = "
SELECT 
    em.marks_obtained,
    em.grade,
    em.status AS mark_status,
    s.subject_name,

    e.exam_name,
    e.term,
    e.start_date,
    e.end_date

FROM exam_marks em

JOIN exams e 
    ON em.exam_id = e.id

JOIN exam_subjects es
    ON es.exam_id = em.exam_id 
    AND es.subject_id = em.subject_id 
    AND es.class_id = em.class_id

JOIN subjects s
    ON es.subject_id = s.id

WHERE em.student_id = $student_id
ORDER BY e.start_date DESC, s.subject_name ASC
";

$results = $conn->query($sql);
?>

<h2>📝 Exam Results</h2>

<div style="margin-top:20px;">

<table border="1" cellpadding="8" cellspacing="0" style="width:100%; background:white; border-collapse:collapse;">
    <thead style="background:#007bff; color:white;">
        <tr>
            <th>Exam</th>
            <th>Term</th>
            <th>Dates</th>
            <th>Subject</th>
            <th>Marks</th>
            <th>Grade</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!$results || $results->num_rows == 0): ?>
            <tr>
                <td colspan="7" align="center" style="color:gray;">No exam results available.</td>
            </tr>
        <?php else: ?>
            <?php while($r = $results->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($r['exam_name']) ?></td>
                    <td><?= htmlspecialchars($r['term']) ?></td>
                    <td>
                        <?= htmlspecialchars($r['start_date']) ?> <br>
                        <small>to</small><br>
                        <?= htmlspecialchars($r['end_date']) ?>
                    </td>
                    <td><?= htmlspecialchars($r['subject_name']) ?></td>
                    <td><b><?= htmlspecialchars($r['marks_obtained']) ?></b></td>
                    <td><?= htmlspecialchars($r['grade']) ?></td>
<td>
    <?php 
        $status = strtolower(trim($r['mark_status']));

        if ($status === 'pass' || $status === 'passed' || $status === 'p') {
            echo '<span style="color:green; font-weight:bold;">Pass</span>';
        } else {
            echo '<span style="color:red; font-weight:bold;">Fail</span>';
        }
    ?>
</td>

                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </tbody>
</table>

</div>

<?php include '../partials/portal_footer.php'; ?>
