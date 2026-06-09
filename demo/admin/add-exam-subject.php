<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

// Fetch dropdown data
$exams = $conn->query("SELECT id, exam_name FROM exams WHERE status='Active' ORDER BY exam_name");
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY subject_name");
?>

<h2>Assign Subject to Exam</h2>

<form method="post" action="../backend/exam_subjects.php?action=create">
  <?= csrf_field() ?>

  <label>Exam:</label>
  <select name="exam_id" required>
    <option value="">-- Select Exam --</option>
    <?php while($e = $exams->fetch_assoc()): ?>
      <option value="<?= $e['id'] ?>"><?= esc($e['exam_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Class:</label>
  <select name="class_id" required>
    <option value="">-- Select Class --</option>
    <?php while($c = $classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Subject:</label>
  <select name="subject_id" required>
    <option value="">-- Select Subject --</option>
    <?php while($s = $subjects->fetch_assoc()): ?>
      <option value="<?= $s['id'] ?>"><?= esc($s['subject_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Maximum Marks</label>
  <input type="number" name="max_marks" value="100" required>

  <label>Passing Marks</label>
  <input type="number" name="pass_marks" value="35" required>

  <br><br>
  <button type="submit">Save</button>
</form>

<?php include 'partials/footer.php'; ?>
