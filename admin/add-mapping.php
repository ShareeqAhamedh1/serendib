<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$map = ['id'=>0,'class_id'=>'','subject_id'=>'','teacher_id'=>''];

if ($id) {
  $stmt = $conn->prepare("SELECT * FROM class_subject_teacher WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $map = $stmt->get_result()->fetch_assoc();
}

$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY subject_name");
$teachers = $conn->query("SELECT id, first_name, last_name FROM teachers ORDER BY first_name");
?>
<h2><?= $id ? 'Edit' : 'Add' ?> Class–Subject–Teacher Mapping</h2>

<form method="post" action="<?= BASE_URL ?>backend/mappings.php?action=<?= $id ? 'update' : 'create' ?>">
  <?= csrf_field() ?>
  <?php if($id): ?><input type="hidden" name="id" value="<?= $map['id'] ?>"><?php endif; ?>

  <label>Class</label>
  <select name="class_id" required>
    <option value="">-- Select Class --</option>
    <?php while($c = $classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>" <?= ($map['class_id']==$c['id'])?'selected':'' ?>><?= esc($c['class_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Subject</label>
  <select name="subject_id" required>
    <option value="">-- Select Subject --</option>
    <?php while($s = $subjects->fetch_assoc()): ?>
      <option value="<?= $s['id'] ?>" <?= ($map['subject_id']==$s['id'])?'selected':'' ?>><?= esc($s['subject_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Teacher</label>
  <select name="teacher_id" required>
    <option value="">-- Select Teacher --</option>
    <?php while($t = $teachers->fetch_assoc()): ?>
      <option value="<?= $t['id'] ?>" <?= ($map['teacher_id']==$t['id'])?'selected':'' ?>>
        <?= esc($t['first_name'] . ' ' . $t['last_name']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <button type="submit"><?= $id ? 'Save' : 'Add' ?> Mapping</button>
</form>

<?php include 'partials/footer.php'; ?>
