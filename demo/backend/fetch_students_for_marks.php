<?php
require 'conn.php';
require 'helpers.php';

$exam_id = (int)($_GET['exam_id'] ?? 0);
$class_id = (int)($_GET['class_id'] ?? 0);
$section_id = (int)($_GET['section_id'] ?? 0);
$subject_id = (int)($_GET['subject_id'] ?? 0);

if(!$exam_id || !$class_id || !$section_id || !$subject_id){
  echo "<p style='color:red;'>Please select all fields.</p>"; exit;
}

$q = "
SELECT s.id, s.first_name, s.last_name, s.admission_no,
       em.marks_obtained, em.grade, em.status
FROM students s
LEFT JOIN exam_marks em 
  ON em.student_id=s.id 
  AND em.exam_id=$exam_id 
  AND em.subject_id=$subject_id
WHERE s.class_id=$class_id 
  AND s.section_id=$section_id
  AND s.isSchool = 1
ORDER BY s.first_name
";
$res = $conn->query($q);

if($res->num_rows == 0){
  echo "<p style='color:gray;'>No students found for this class/section.</p>"; exit;
}
?>

<form method="post" action="<?= BASE_URL ?>backend/save_marks.php">

  <?= csrf_field() ?>
  <input type="hidden" name="exam_id" value="<?= $exam_id ?>">
  <input type="hidden" name="class_id" value="<?= $class_id ?>">
  <input type="hidden" name="section_id" value="<?= $section_id ?>">
  <input type="hidden" name="subject_id" value="<?= $subject_id ?>">

  <table border="1" cellpadding="6" style="width:100%; border-collapse:collapse;">
    <thead style="background:#007bff; color:white;">
      <tr><th>Admission No</th><th>Name</th><th>Marks</th><th>Grade</th><th>Status</th></tr>
    </thead>
    <tbody>
      <?php while($r=$res->fetch_assoc()): ?>
        <tr>
          <td><?= esc($r['admission_no']) ?></td>
          <td><?= esc($r['first_name'].' '.$r['last_name']) ?></td>
          <td><input type="number" name="marks[<?= $r['id'] ?>]" value="<?= esc($r['marks_obtained'] ?? '') ?>" min="0" max="100" step="0.5"></td>
          <td><?= esc($r['grade'] ?? '-') ?></td>
          <td><?= esc($r['status'] ?? '-') ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <br>
  <button type="submit">💾 Save Marks</button>
</form>
