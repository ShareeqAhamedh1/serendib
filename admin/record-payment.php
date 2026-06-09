<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Generate new CSRF token (if not set)
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];
?>

<h2>💰 Fee Collection Dashboard</h2>
<p>Manage and view student fee payments with filters, pagination, and export.</p>

<div style="background:#f9f9f9; padding:15px; border-radius:10px; margin-bottom:20px;">
  <form id="filterForm">
    <label>Search (Name or Admission No):</label>
    <input type="text" name="search" id="search" placeholder="e.g. S001 or Name" style="margin-right:10px;">

    <label>Status:</label>
    <select name="status" id="status" style="margin-right:10px;">
      <option value="">All</option>
      <option value="Pending">Pending</option>
      <option value="Partial">Partial</option>
      <option value="Paid">Paid</option>
      <option value="No Fees">No Fees Assigned</option>
    </select>

    <label>Limit:</label>
    <select name="limit" id="limit" style="margin-right:10px;">
      <option value="10">10</option>
      <option value="25">25</option>
      <option value="50">50</option>
    </select>

    <button type="button" id="applyFilter">🔍 Apply</button>
    <button type="button" id="resetFilter">🔄 Reset</button>
    <button type="button" id="exportExcel">📗 Export Excel</button>
  </form>
</div>

<div id="studentContainer">
  <p>Loading data...</p>
</div>

<div id="paginationControls" style="text-align:center; margin-top:15px;"></div>
<div id="summaryBox" style="margin-top:20px; padding:10px; background:#eaf4ff; border-radius:6px; font-weight:bold;"></div>

<script>
let currentPage = 1;

function loadFees(page = 1) {
  currentPage = page;
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  params.append('page', page);

  fetch(`<?= BASE_URL ?>backend/fetch_student_fees.php?${params.toString()}`)
    .then(res => res.text())
    .then(html => {
      const [tablePart, paginationPart, summaryPart] = html.split('<!--PAGE_SPLIT-->');
      document.getElementById('studentContainer').innerHTML = tablePart;
      document.getElementById('paginationControls').innerHTML = paginationPart || '';
      document.getElementById('summaryBox').innerHTML = summaryPart || '';
    })
    .catch(err => {
      document.getElementById('studentContainer').innerHTML = '<p style="color:red;">Error loading fees.</p>';
      console.error(err);
    });
}

document.getElementById('applyFilter').addEventListener('click', () => loadFees(1));
document.getElementById('resetFilter').addEventListener('click', () => {
  document.getElementById('filterForm').reset();
  loadFees(1);
});

document.getElementById('exportExcel').addEventListener('click', () => {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  window.location.href = `<?= BASE_URL ?>backend/export_fee_report_excel.php?${params.toString()}`;
});

// ✅ Inline Payment (AJAX)
document.addEventListener('submit', e => {
  if (e.target.classList.contains('paymentForm')) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    // Add CSRF token if not already present
    if (!formData.has('csrf_token')) {
      formData.append('csrf_token', '<?= $csrfToken ?>');
    }

    fetch('<?= BASE_URL ?>backend/record_payment.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("✅ Payment recorded successfully!");
        // Optionally redirect to receipt
        if (data.receipt_id) {
          window.open(`<?= BASE_URL ?>admin/fee-receipt.php?payment_id=${data.receipt_id}`, '_blank');
        }
        loadFees(currentPage);
      } else {
        alert("⚠️ " + data.message);
      }
    })
    .catch(err => {
      console.error(err);
      alert('❌ Error recording payment.');
    });
  }
});

document.addEventListener('click', e => {
  if (e.target.classList.contains('page-link')) {
    e.preventDefault();
    loadFees(e.target.dataset.page);
  }
});

window.addEventListener('DOMContentLoaded', () => loadFees());
</script>
<script>
let paymentsVisible = false;

function toggleAllPayments() {
    const blocks = document.querySelectorAll('.payment-history');
    const btn = document.getElementById('toggleAllBtn');

    paymentsVisible = !paymentsVisible;

    blocks.forEach(el => {
        el.style.display = paymentsVisible ? 'block' : 'none';
    });

    btn.innerHTML = paymentsVisible 
        ? '⬆️ Hide All Payments' 
        : '⬇️ View All Payments';
}
</script>

<?php include 'partials/footer.php'; ?>
