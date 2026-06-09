<?php include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$res = $conn->query("SELECT * FROM subjects ORDER BY subject_code");
?>
<h2>Subjects</h2>
<a href="<?= BASE_URL ?>admin/add-subject.php">Add Subject</a>
<?php if(isset($_GET['created'])) echo "<p style='color:green'>Created</p>"; ?>
<table border="1" cellpadding="6">
<thead><tr><th>#</th><th>Subject</th><th>Code</th><th>Actions</th></tr></thead>
<tbody>
  <?php
  $count = 1;
  while($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?= $count++ ?></td>
      <td><?= esc($r['subject_name']) ?></td>
      <td><?= esc($r['subject_code']) ?></td>
      <td>
        <a href="<?= BASE_URL ?>admin/add-subject.php?id=<?= $r['id'] ?>">Edit</a> |
        <a href="<?= BASE_URL ?>backend/subjects.php?action=delete&id=<?= $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</tbody>
</table>

<?php include 'partials/footer.php'; ?>
