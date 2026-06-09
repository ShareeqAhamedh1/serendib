<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$exam = ['id'=>0,'exam_name'=>'','term'=>'','start_date'=>'','end_date'=>'','status'=>'Active'];

if ($id) {
  $stmt = $conn->prepare("SELECT * FROM exams WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $exam = $stmt->get_result()->fetch_assoc();
}
?>
<h2><?= $id ? 'Edit Exam' : 'Add Exam' ?></h2>

<form method="post" action="../backend/exams.php?action=<?= $id ? 'update' : 'create' ?>">
  <?= csrf_field() ?>
  <?php if($id): ?><input type="hidden" name="id" value="<?= $exam['id'] ?>"><?php endif; ?>

  <label>Exam Name</label>
  <input type="text" name="exam_name" required value="<?= esc($exam['exam_name']) ?>">

  <label>Term</label>
  <input type="text" name="term" placeholder="e.g., Term 1 / Semester 2"
         value="<?= esc($exam['term']) ?>">

  <label>Start Date</label>
  <input type="date" name="start_date" value="<?= esc($exam['start_date']) ?>">

  <label>End Date</label>
  <input type="date" name="end_date" value="<?= esc($exam['end_date']) ?>">

  <label>Status</label>
  <select name="status">
    <option value="Active" <?= $exam['status']=='Active'?'selected':'' ?>>Active</option>
    <option value="Closed" <?= $exam['status']=='Closed'?'selected':'' ?>>Closed</option>
  </select>

  <br><br>
  <button type="submit"><?= $id ? 'Save Changes' : 'Add Exam' ?></button>
</form>

<?php include 'partials/footer.php'; ?>
