<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$class = ['id'=>0, 'class_name'=>'', 'description'=>''];
if ($id) {
  $stmt = $conn->prepare("SELECT * FROM classes WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $class = $stmt->get_result()->fetch_assoc();
}
?>
<h2><?= $id ? 'Edit' : 'Add' ?> Class</h2>

<form method="post" action="<?= BASE_URL ?>backend/classes.php?action=<?= $id ? 'update' : 'create' ?>">
  <?= csrf_field() ?>
  <?php if($id): ?><input type="hidden" name="id" value="<?= $class['id'] ?>"><?php endif; ?>
  <label>Class Name</label>
  <input name="class_name" required value="<?= esc($class['class_name']) ?>">
  <label>Description</label>
  <input name="description" value="<?= esc($class['description']) ?>">
  <button type="submit"><?= $id ? 'Save' : 'Add' ?></button>
</form>

<?php include 'partials/footer.php'; ?>
