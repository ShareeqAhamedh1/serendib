<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$res = $conn->query("SELECT * FROM exams ORDER BY start_date DESC");
?>
<h2>📘 Exams</h2>

<a href="<?= BASE_URL ?>admin/add-exam.php" class="btn">➕ Add Exam</a>

<?php if(isset($_GET['created'])) echo "<p style='color:green'>Exam added successfully!</p>"; ?>
<?php if(isset($_GET['updated'])) echo "<p style='color:green'>Exam updated successfully!</p>"; ?>
<?php if(isset($_GET['deleted'])) echo "<p style='color:green'>Exam deleted successfully!</p>"; ?>

<table border="1" cellpadding="6" style="border-collapse:collapse; width:100%; background:#fff;">
  <thead style="background:#007bff; color:#fff;">
    <tr>
      <th>Name</th>
      <th>Term</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php while($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?= esc($r['exam_name']) ?></td>
      <td><?= esc($r['term']) ?></td>
      <td><?= esc($r['start_date']) ?></td>
      <td><?= esc($r['end_date']) ?></td>
      <td><?= esc($r['status']) ?></td>
      <td>
        <a href="add-exam.php?id=<?= $r['id'] ?>">Edit</a> |
        <a href="../backend/exams.php?action=delete&id=<?= $r['id'] ?>"
           onclick="return confirm('Delete this exam?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>

<?php include 'partials/footer.php'; ?>
