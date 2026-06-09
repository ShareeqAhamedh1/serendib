<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Fetch categories for filter
$cats = $conn->query("SELECT id, name FROM expense_categories ORDER BY name");
?>

<h2>📊 Expense List</h2>
<p>View and manage all recorded expenses.</p>

<div style="background:#f9f9f9; padding:15px; border-radius:10px; margin-bottom:20px;">
  <form id="filterForm">
    <label>Category:</label>
    <select name="category_id" id="category_id" style="margin-right:10px;">
      <option value="">All</option>
      <?php while($c = $cats->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= esc($c['name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Payment Method:</label>
    <select name="method" id="method" style="margin-right:10px;">
      <option value="">All</option>
      <option value="Cash">Cash</option>
      <option value="Card">Card</option>
      <option value="Bank Transfer">Bank Transfer</option>
      <option value="Online">Online</option>
    </select>

    <label>Date Range:</label>
    <input type="date" name="from_date" id="from_date">
    <input type="date" name="to_date" id="to_date" style="margin-right:10px;">

    <button type="button" id="applyFilter">🔍 Apply</button>
    <button type="button" id="exportExcel">📗 Export Excel</button>
  </form>
</div>

<div id="expenseContainer">
  <p>Loading expenses...</p>
</div>

<script>
function loadExpenses() {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  fetch(`<?= BASE_URL ?>backend/fetch_expenses.php?${params.toString()}`)
    .then(res => res.text())
    .then(html => document.getElementById('expenseContainer').innerHTML = html)
    .catch(err => {
      document.getElementById('expenseContainer').innerHTML = '<p style="color:red;">Error loading expenses.</p>';
      console.error(err);
    });
}

document.getElementById('applyFilter').addEventListener('click', loadExpenses);

document.getElementById('exportExcel').addEventListener('click', () => {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  window.location.href = `<?= BASE_URL ?>backend/export_expense_excel.php?${params.toString()}`;
});

window.addEventListener('DOMContentLoaded', loadExpenses);
</script>

<?php include 'partials/footer.php'; ?>
