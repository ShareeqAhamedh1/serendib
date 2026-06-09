<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$query = "
SELECT m.id, c.class_name, s.subject_name, CONCAT(t.first_name, ' ', t.last_name) AS teacher_name
FROM class_subject_teacher m
LEFT JOIN classes c ON m.class_id = c.id
LEFT JOIN subjects s ON m.subject_id = s.id
LEFT JOIN teachers t ON m.teacher_id = t.id
ORDER BY c.class_name, s.subject_name
";
$res = $conn->query($query);
?>
<h2>Class–Subject–Teacher Mapping</h2>
<a href="<?= BASE_URL ?>admin/add-mapping.php">Add Mapping</a>

<?php if(isset($_GET['created'])) echo "<p style='color:green'>Mapping created successfully!</p>"; ?>
<?php if(isset($_GET['updated'])) echo "<p style='color:green'>Mapping updated successfully!</p>"; ?>
<?php if(isset($_GET['deleted'])) echo "<p style='color:green'>Mapping deleted successfully!</p>"; ?>
<?php if(isset($_GET['exists'])) echo "<p style='color:red'>Mapping already exists!</p>"; ?>

<table border="1" cellpadding="6">
  <thead>
    <tr>
      <th>ID</th>
      <th>Class</th>
      <th>Subject</th>
      <th>Teacher</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $i=1;
    while($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?= $i; ?></td>
        <td><?= esc($row['class_name']) ?></td>
        <td><?= esc($row['subject_name']) ?></td>
        <td><?= esc($row['teacher_name']) ?></td>
        <td>
          <a href="<?= BASE_URL ?>admin/add-mapping.php?id=<?= $row['id'] ?>">Edit</a> |
          <a href="<?= BASE_URL ?>backend/mappings.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Delete mapping?')">Delete</a>
        </td>
      </tr>
    <?php
    $i++;
    endwhile; ?>
  </tbody>
</table>

<?php include 'partials/footer.php'; ?>
