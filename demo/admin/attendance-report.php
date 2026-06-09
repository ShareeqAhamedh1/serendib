<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

// Get filter options
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
$sections = $conn->query("SELECT id, section_name FROM sections ORDER BY section_name");

$dateToday = date('Y-m-d');
?>

<h2>📊 Attendance Report</h2>

<div style="margin:20px 0; background:#f8f8f8; padding:15px; border-radius:10px;">
  <form id="filterForm">
    <label>Date:</label>
    <input type="date" id="dateFilter" name="date" value="<?= $dateToday ?>">

    <label>Type:</label>
    <select id="typeFilter" name="type">
      <option value="">All</option>
      <option value="student">Students</option>
      <option value="teacher">Teachers</option>
    </select>

    <label>Class:</label>
    <select id="classFilter" name="class_id">
      <option value="">All</option>
      <?php while($c = $classes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Section:</label>
    <select id="sectionFilter" name="section_id">
      <option value="">All</option>
      <?php while($s = $sections->fetch_assoc()): ?>
        <option value="<?= $s['id'] ?>"><?= esc($s['section_name']) ?></option>
      <?php endwhile; ?>
    </select>

    <button type="button" id="applyFilter">Apply</button>
    <button type="button" id="resetFilter">Reset</button>
  </form>
</div>
<div style="margin:15px 0;">
  <button id="exportExcel">📗 Export to Excel</button>
  <!-- <button id="exportPDF">📘 Export to PDF</button> -->
</div>


<div id="reportContainer">
  <p>Loading attendance...</p>
</div>

<div id="summaryBox" style="margin-top:15px; font-weight:bold; color:#333;"></div>

<script>
function loadReport() {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  
  fetch(`<?= BASE_URL ?>backend/fetch_attendance_report.php?${params.toString()}`)
    .then(res => res.text())
    .then(html => {
      document.getElementById('reportContainer').innerHTML = html;

      // Calculate summary
      let present = document.querySelectorAll('td.status-cell.present').length;
      let absent = document.querySelectorAll('td.status-cell.absent').length;
      document.getElementById('summaryBox').innerHTML = 
        `🟢 Present: ${present} | 🔴 Absent: ${absent}`;
    })
    .catch(err => {
      console.error(err);
      document.getElementById('reportContainer').innerHTML = '<p style="color:red;">Error loading report.</p>';
    });
}

document.getElementById('applyFilter').addEventListener('click', loadReport);
document.getElementById('resetFilter').addEventListener('click', () => {
  document.getElementById('filterForm').reset();
  loadReport();
});
// --- Export to Excel ---
document.getElementById('exportExcel').addEventListener('click', () => {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  window.location.href = `<?= BASE_URL ?>backend/export_attendance_excel.php?${params.toString()}`;
});
window.addEventListener('DOMContentLoaded', loadReport);
// --- Export to PDF ---
document.getElementById('exportPDF').addEventListener('click', () => {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  window.location.href = `<?= BASE_URL ?>backend/export_attendance_pdf.php?${params.toString()}`;
});


</script>


<?php include 'partials/footer.php'; ?>
