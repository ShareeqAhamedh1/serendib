<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

if (isset($_GET['success'])) {
  echo "<div id='msgBox' style='background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:10px;'>
          ✅ Salary payment recorded successfully.
        </div>";
}
?>

<h2>💰 Teacher Salary Management</h2>
<p>Manage and record salary payments for each teacher. You can also add bonuses or deductions.</p>

<div style="background:#f9f9f9; padding:15px; border-radius:10px; margin-bottom:20px;">
  <form id="filterForm">
    <label>Search:</label>
    <input type="text" name="search" id="search" placeholder="Name, Subject or Code" style="margin-right:10px;">
    <label>Month:</label>
    <input type="month" name="month" id="month" value="<?= date('Y-m') ?>" style="margin-right:10px;">
    <button type="button" id="applyFilter">🔍 Apply</button>
    <button type="button" id="resetFilter">🔄 Reset</button>
  </form>
</div>

<div id="teacherContainer">
  <p style="color:gray;">Loading teachers...</p>
</div>

<!-- Payment Modal -->
<div id="payModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;">
  <div style="
    background:#fff;
    width:420px;
    max-height:85vh;
    margin:60px auto;
    padding:0;
    border-radius:8px;
    display:flex;
    flex-direction:column;
">

    
    <div style="padding:15px; border-bottom:1px solid #eee;">
  <h3 style="margin:0;">💵 Record Teacher Payment</h3>
</div>

<div style="padding:15px; overflow-y:auto;">
<form id="paymentForm">

      <input type="hidden" name="teacher_id" id="teacher_id">
      <label>Teacher:</label>
      <input type="text" id="teacher_name" readonly style="width:100%; margin-bottom:10px;">
      <label>Month:</label>
      <input type="text" name="month_year" id="month_year" readonly style="width:100%; margin-bottom:10px;">
      <label>Base Salary:</label>
      <input type="number" name="base_salary" required step="0.01" style="width:100%; margin-bottom:10px;">
      <label>Bonus:</label>
      <input type="number" name="bonus" step="0.01" value="0" style="width:100%; margin-bottom:10px;">
      <label>Deductions:</label>
      <input type="number" name="deductions" step="0.01" value="0" style="width:100%; margin-bottom:10px;">
      <label>Payment Method:</label>
      <select name="method" style="width:100%; margin-bottom:10px;">
        <option value="Cash">Cash</option>
        <option value="Bank Transfer">Bank Transfer</option>
        <option value="Cheque">Cheque</option>
      </select>
      <label>Remarks:</label>
      <textarea name="remarks" style="width:100%; margin-bottom:10px;"></textarea>
<div style="
  position:sticky;
  bottom:0;
  background:#fff;
  padding:10px;
  border-top:1px solid #eee;
  text-align:right;
">
  <button type="button" id="cancelPay">Cancel</button>
  <button type="submit">💾 Save</button>
</div>

    </form>
</div>

  </div>
</div>

<script>
// ✅ Load teacher data dynamically
function loadTeachers() {
  const form = new FormData(document.getElementById('filterForm'));
  fetch('<?= BASE_URL ?>backend/fetch_teacher_salary_list.php', {
    method: 'POST',
    body: form
  })
  .then(res => res.text())
  .then(html => {
    document.getElementById('teacherContainer').innerHTML = html;
  })
  .catch(err => {
    document.getElementById('teacherContainer').innerHTML = '<p style="color:red;">Error loading teachers.</p>';
    console.error(err);
  });
}

// Apply / Reset filters
document.getElementById('applyFilter').addEventListener('click', loadTeachers);
document.getElementById('resetFilter').addEventListener('click', () => {
  document.getElementById('filterForm').reset();
  loadTeachers();
});

// Open modal
document.addEventListener('click', e => {
  if (e.target.classList.contains('payBtn')) {
    const btn = e.target;
    document.getElementById('teacher_id').value = btn.dataset.id;
    document.getElementById('teacher_name').value = btn.dataset.name;
    document.getElementById('month_year').value = document.getElementById('month').value 
      ? new Date(document.getElementById('month').value + "-01").toLocaleString('default', { month: 'short', year: 'numeric' })
      : "<?= date('M-Y') ?>";
    document.getElementById('payModal').style.display = 'block';
  }
});

// Close modal
document.getElementById('cancelPay').addEventListener('click', () => {
  document.getElementById('payModal').style.display = 'none';
});

// Save payment
document.getElementById('paymentForm').addEventListener('submit', e => {
  e.preventDefault();
  const formData = new FormData(e.target);

  fetch('<?= BASE_URL ?>backend/save_teacher_payment.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.success && data.redirect) {
      window.location.href = data.redirect;
    } else if (data.success) {
      document.getElementById('payModal').style.display = 'none';
      loadTeachers();
    }
  })
  .catch(err => {
    console.error(err);
    alert('Error saving payment.');
  });
});

// Hide success message after 2.5s
setTimeout(() => {
  const msg = document.getElementById('msgBox');
  if (msg) msg.style.display = 'none';
}, 2500);

// Clean up URL (remove ?success=1)
if (window.location.search.includes('success=1')) {
  const cleanUrl = window.location.href.split('?')[0];
  window.history.replaceState({}, document.title, cleanUrl);
}

// ✅ Load teacher data dynamically
function loadTeachers(page = 1) {
  const form = new FormData(document.getElementById('filterForm'));
  form.append('page', page);

  fetch('<?= BASE_URL ?>backend/fetch_teacher_salary_list.php', {
    method: 'POST',
    body: form
  })
  .then(res => res.text())
  .then(html => {
    const [tablePart, paginationPart] = html.split('<!--PAGE_SPLIT-->');
    document.getElementById('teacherContainer').innerHTML = tablePart;
    if (paginationPart)
      document.getElementById('teacherContainer').innerHTML += paginationPart;
  })
  .catch(err => {
    document.getElementById('teacherContainer').innerHTML = '<p style="color:red;">Error loading teachers.</p>';
    console.error(err);
  });
}

// Pagination click
document.addEventListener('click', e => {
  if (e.target.classList.contains('page-link')) {
    e.preventDefault();
    loadTeachers(e.target.dataset.page);
  }
});

// Excel export
document.getElementById('exportExcel')?.addEventListener('click', () => {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  window.location.href = `<?= BASE_URL ?>backend/export_teacher_salary_list_excel.php?${params.toString()}`;
});

// Load teachers initially
window.addEventListener('DOMContentLoaded', loadTeachers);
</script>

<?php include 'partials/footer.php'; ?>
