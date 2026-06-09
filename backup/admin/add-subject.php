<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$subject = ['id'=>0,'subject_name'=>'','subject_code'=>''];
if ($id) {
  $stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
  $stmt->bind_param("i",$id); $stmt->execute();
  $subject = $stmt->get_result()->fetch_assoc();
}
?>
<h2><?= $id ? 'Edit' : 'Add' ?> Subject</h2>

<form method="post" action="<?= BASE_URL ?>backend/subjects.php?action=<?= $id ? 'update' : 'create' ?>">
  <?= csrf_field() ?>
  <?php if($id): ?><input type="hidden" name="id" value="<?= $subject['id'] ?>"><?php endif; ?>
  <label>Subject Name</label>
  <input name="subject_name" required value="<?= esc($subject['subject_name']) ?>">
  <label>Subject Code</label>
  <input name="subject_code" value="<?= esc($subject['subject_code']) ?>">
  <button type="submit"><?= $id ? 'Save' : 'Add' ?></button>
</form>

<?php include 'partials/footer.php'; ?>
