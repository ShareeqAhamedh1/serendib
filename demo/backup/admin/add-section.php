<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$section = ['id'=>0,'class_id'=>null,'section_name'=>''];
if ($id) {
  $stmt = $conn->prepare("SELECT * FROM sections WHERE id = ?");
  $stmt->bind_param("i",$id); $stmt->execute();
  $section = $stmt->get_result()->fetch_assoc();
}
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
?>
<h2><?= $id ? 'Edit' : 'Add' ?> Section</h2>

<form method="post" action="<?= BASE_URL ?>backend/sections.php?action=<?= $id ? 'update' : 'create' ?>">
  <?= csrf_field() ?>
  <?php if($id): ?><input type="hidden" name="id" value="<?= $section['id'] ?>"><?php endif; ?>
  <label>Class</label>
  <select name="class_id" required>
    <option value="">-- Select Class --</option>
    <?php while($c = $classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>" <?= ($section['class_id']==$c['id'])?'selected':'' ?>><?= esc($c['class_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Section Name</label>
  <input name="section_name" required value="<?= esc($section['section_name']) ?>">

  <button type="submit"><?= $id ? 'Save' : 'Add' ?></button>
</form>

<?php include 'partials/footer.php'; ?>
