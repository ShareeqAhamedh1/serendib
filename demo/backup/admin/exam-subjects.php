<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$q = "
SELECT es.id, e.exam_name, c.class_name, s.subject_name, es.max_marks, es.pass_marks
FROM exam_subjects es
JOIN exams e ON es.exam_id=e.id
JOIN classes c ON es.class_id=c.id
JOIN subjects s ON es.subject_id=s.id
ORDER BY e.exam_name, c.class_name, s.subject_name
";
$res = $conn->query($q);
?>
<h2>🧾 Exam - Subject Mapping</h2>

<a href="add-exam-subject.php" class="btn">➕ Assign Subject</a>

<?php if(isset($_GET['created'])) echo "<p style='color:green'>Mapping added successfully!</p>"; ?>
<?php if(isset($_GET['deleted'])) echo "<p style='color:green'>Mapping deleted successfully!</p>"; ?>

<table border="1" cellpadding="6" style="width:100%; border-collapse:collapse; background:#fff;">
  <thead style="background:#007bff; color:white;">
    <tr>
      <th>Exam</th>
      <th>Class</th>
      <th>Subject</th>
      <th>Max Marks</th>
      <th>Pass Marks</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php while($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?= esc($r['exam_name']) ?></td>
      <td><?= esc($r['class_name']) ?></td>
      <td><?= esc($r['subject_name']) ?></td>
      <td><?= esc($r['max_marks']) ?></td>
      <td><?= esc($r['pass_marks']) ?></td>
      <td>
        <a href="../backend/exam_subjects.php?action=delete&id=<?= $r['id'] ?>" 
           onclick="return confirm('Delete this subject mapping?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>

<?php include 'partials/footer.php'; ?>
