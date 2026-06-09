<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Fetch expense categories
$cats = $conn->query("SELECT id, name FROM expense_categories ORDER BY name");
?>

<h2>💵 Add New Expense</h2>
<p>Record a new school expense below.</p>

<div style="background:#f9f9f9; padding:20px; border-radius:10px; max-width:600px;">
  <form id="expenseForm" method="POST" action="<?= BASE_URL ?>backend/save_expense.php">
    <?= csrf_field() ?>

    <label><b>Title:</b></label><br>
    <input type="text" name="title" required style="width:100%; margin-bottom:10px;"><br>

    <label><b>Category:</b></label><br>
    <select name="category_id" required style="width:100%; margin-bottom:10px;">
      <option value="">Select Category</option>
      <?php while($c = $cats->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= esc($c['name']) ?></option>
      <?php endwhile; ?>
    </select><br>

    <label><b>Amount:</b></label><br>
    <input type="number" step="0.01" name="amount" required style="width:100%; margin-bottom:10px;"><br>

    <label><b>Date:</b></label><br>
    <input type="date" name="expense_date" value="<?= date('Y-m-d') ?>" required style="width:100%; margin-bottom:10px;"><br>

    <label><b>Payment Method:</b></label><br>
    <select name="payment_method" style="width:100%; margin-bottom:10px;">
      <option value="Cash">Cash</option>
      <option value="Card">Card</option>
      <option value="Bank Transfer">Bank Transfer</option>
      <option value="Online">Online</option>
    </select><br>

    <label><b>Remarks:</b></label><br>
    <textarea name="remarks" style="width:100%; height:80px;"></textarea><br>

    <div style="text-align:right;">
      <button type="submit" style="background:#007bff; color:white; border:none; padding:8px 12px; border-radius:5px;">
        💾 Save Expense
      </button>
    </div>
  </form>
</div>

<?php include 'partials/footer.php'; ?>
