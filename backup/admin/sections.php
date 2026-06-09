<?php include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$res = $conn->query("SELECT s.id, s.section_name, s.class_id, c.class_name
                     FROM sections s LEFT JOIN classes c ON s.class_id = c.id
                     ORDER BY c.id, s.section_name");
?>
<h2>Sections</h2>
<a href="<?= BASE_URL ?>admin/add-section.php">Add Section</a>
<?php if(isset($_GET['created'])) echo "<p style='color:green'>Created</p>"; ?>
<table border="1" cellpadding="6">
  <thead><tr><th>#</th><th>Section</th><th>Class</th><th>Actions</th></tr></thead>
  <tbody>
    <?php 
    $count = 1;
    while($r = $res->fetch_assoc()): ?>
      <tr>
        <td><?= $count++ ?></td>
        <td><?= esc($r['section_name']) ?></td>
        <td><?= esc($r['class_name']) ?></td>
        <td>
          <a href="<?= BASE_URL ?>admin/add-section.php?id=<?= $r['id'] ?>">Edit</a> |
          <a href="<?= BASE_URL ?>backend/sections.php?action=delete&id=<?= $r['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include 'partials/footer.php'; ?>
