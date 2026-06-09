<?php 
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

// fetch classes
$res = $conn->query("SELECT * FROM classes ORDER BY id");
?>
<h2>Classes</h2>

<a href="<?= BASE_URL ?>admin/add-class.php">Add Class</a>

<?php if(isset($_GET['created'])): ?><p style="color:green">Class created</p><?php endif; ?>
<?php if(isset($_GET['updated'])): ?><p style="color:green">Class updated</p><?php endif; ?>
<?php if(isset($_GET['deleted'])): ?><p style="color:green">Class deleted</p><?php endif; ?>

<table border="1" cellpadding="6">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php 
    $count = 1;
    while($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?= $count++ ?></td>
        <td><?= esc($r['class_name']) ?></td>
        <td><?= esc($r['description']) ?></td>
        <td>
          <a href="<?= BASE_URL ?>admin/add-class.php?id=<?= $r['id'] ?>">Edit</a> |
          <a href="<?= BASE_URL ?>backend/classes.php?action=delete&id=<?= $r['id'] ?>" 
             onclick="return confirm('Delete class?')">
             Delete
          </a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include 'partials/footer.php'; ?>
