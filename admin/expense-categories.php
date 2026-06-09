<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// 🟢 Handle Add Category
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
  $name = trim($_POST['name'] ?? '');
  $description = trim($_POST['description'] ?? '');
  if ($name !== '') {
    $stmt = $conn->prepare("INSERT INTO expense_categories (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $description);
    $stmt->execute();
    $message = "✅ Category added successfully!";
  } else {
    $message = "⚠️ Please enter a category name.";
  }
}

// 🔴 Handle Delete Category
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $id = (int)$_GET['delete'];

  // Check if category has related expenses
  $check = $conn->prepare("SELECT COUNT(*) AS cnt FROM expenses WHERE category_id = ?");
  $check->bind_param("i", $id);
  $check->execute();
  $cnt = $check->get_result()->fetch_assoc()['cnt'];

  if ($cnt > 0) {
    $message = "⚠️ Cannot delete — this category is used in existing expenses.";
  } else {
    $del = $conn->prepare("DELETE FROM expense_categories WHERE id = ?");
    $del->bind_param("i", $id);
    $del->execute();
    $message = "🗑️ Category deleted successfully!";
  }
}

// 🧾 Fetch all categories
$res = $conn->query("SELECT * FROM expense_categories ORDER BY name");
?>

<h2>📂 Expense Categories</h2>

<?php if ($message): ?>
  <div id="msgBox" style="background:#e7f4ff; padding:10px; border-left:5px solid #007bff; margin-bottom:15px;">
    <?= esc($message) ?>
  </div>
<?php endif; ?>

<div style="background:#f9f9f9; padding:15px; border-radius:10px; max-width:600px; margin-bottom:30px;">
  <form method="POST">
    <label><b>Category Name:</b></label><br>
    <input type="text" name="name" required style="width:100%; margin-bottom:10px;"><br>

    <label><b>Description:</b></label><br>
    <textarea name="description" style="width:100%; height:70px;"></textarea><br>

    <button type="submit" name="add_category" style="background:#007bff; color:white; border:none; padding:8px 12px; border-radius:5px;">
      ➕ Add Category
    </button>
  </form>
</div>

<h3>📋 Existing Categories</h3>
<table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; width:100%; background:white;">
  <thead style="background:#007bff; color:white;">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Description</th>
      <th>Created At</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($res->num_rows == 0): ?>
      <tr><td colspan="5" style="text-align:center; color:gray;">No categories added yet.</td></tr>
    <?php else: ?>
      <?php while($row = $res->fetch_assoc()): ?>
        <tr>
          <td><?= esc($row['id']) ?></td>
          <td><?= esc($row['name']) ?></td>
          <td><?= esc($row['description']) ?></td>
          <td><?= esc($row['created_at']) ?></td>
          <td>
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this category?')" 
               style="color:red; text-decoration:none;">🗑️ Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php endif; ?>
  </tbody>
</table>

<script>
// Auto-hide success/error message after 3 seconds
setTimeout(() => {
  const msg = document.getElementById('msgBox');
  if (msg) msg.style.display = 'none';
}, 3000);
</script>

<?php include 'partials/footer.php'; ?>
