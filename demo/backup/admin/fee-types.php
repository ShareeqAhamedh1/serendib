<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
?>

<h2>💰 Fee Types</h2>
<p>Manage all types of student fees (Tuition, Transport, Exam Fee, etc.)</p>

<div style="background:#f9f9f9; padding:15px; border-radius:10px; margin-bottom:20px;">
  <form id="feeTypeForm" method="post" action="<?= BASE_URL ?>backend/fee_types.php?action=create">
    <?= csrf_field() ?>
    <label>Fee Type Name:</label>
    <input type="text" name="name" placeholder="e.g., Tuition Fee" required>

    <label>Description:</label>
    <input type="text" name="description" placeholder="optional">

    <label>Default Amount (LKR):</label>
    <input type="number" name="default_amount" step="0.01" min="0" required>

    <button type="submit">➕ Add Fee Type</button>
  </form>
</div>

<hr>

<h3>Existing Fee Types</h3>
<table border="1" cellpadding="8" style="width:100%; border-collapse:collapse; background:#fff;">
  <thead style="background:#007bff; color:white;">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Description</th>
      <th>Default Amount</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $res = $conn->query("SELECT * FROM fee_types ORDER BY id DESC");
  if ($res->num_rows == 0): ?>
    <tr><td colspan="5" style="text-align:center;">No fee types found.</td></tr>
  <?php else:
  $count = 1;
    while ($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?= $count ++ ?></td>
        <td><?= esc($row['name']) ?></td>
        <td><?= esc($row['description'] ?? '-') ?></td>
        <td><?= number_format($row['default_amount'], 2) ?></td>
        <td>
          <a href="<?= BASE_URL ?>backend/fee_types.php?action=delete&id=<?= $row['id'] ?>"
             onclick="return confirm('Delete this fee type?')" style="color:red;">🗑 Delete</a>
        </td>
      </tr>
    <?php endwhile;
  endif; ?>
  </tbody>
</table>

<?php include 'partials/footer.php'; ?>
