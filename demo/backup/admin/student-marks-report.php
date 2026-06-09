<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$exams = $conn->query("SELECT id, exam_name FROM exams ORDER BY exam_name");
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY subject_name");
?>

<h2>📘 Student Marks Report</h2>
<p>View all student marks with filters and search.</p>

<div style="background:#f9f9f9; padding:15px; border-radius:10px; margin-bottom:20px;">
  <form id="filterForm">
    <label>Exam:</label>
    <select name="exam_id" id="exam_id">
      <option value="">All</option>
      <?php while($e = $exams->fetch_assoc()): ?>
        <option value="<?= $e['id'] ?>"><?= esc($e['exam_name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Class:</label>
    <select name="class_id" id="class_id">
      <option value="">All</option>
      <?php while($c = $classes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Section:</label>
    <select name="section_id" id="section_id">
      <option value="">All</option>
    </select>

    <label>Subject:</label>
    <select name="subject_id" id="subject_id">
      <option value="">All</option>
      <?php while($s = $subjects->fetch_assoc()): ?>
        <option value="<?= $s['id'] ?>"><?= esc($s['subject_name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Search (Admission No):</label>
    <input type="text" name="admission_no" id="admission_no" placeholder="e.g., S001" style="width:150px;">

    <button type="button" id="applyFilter">Apply</button>
    <button type="button" id="resetFilter">Reset</button>
  </form>
</div>

<div style="margin:10px 0;">
  <button id="exportExcel">📗 Export to Excel</button>
</div>

<div id="resultsContainer">
  <p>Waiting for selection...</p>
</div>

<script>
// Load sections when class changes
document.getElementById('class_id').addEventListener('change', function(){
  const classId = this.value;
  const sectionSelect = document.getElementById('section_id');
  sectionSelect.innerHTML = '<option>Loading...</option>';
  fetch(`<?= BASE_URL ?>backend/get_sections.php?class_id=${classId}`)
    .then(res => res.json())
    .then(data => {
      sectionSelect.innerHTML = '<option value="">All</option>';
      data.forEach(sec => sectionSelect.innerHTML += `<option value="${sec.id}">${sec.section_name}</option>`);
    });
});

// --- FUNCTION: Load Marks Report ---
function loadReport() {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  fetch(`<?= BASE_URL ?>backend/fetch_student_marks_report.php?${params.toString()}`)
    .then(res => res.text())
    .then(html => document.getElementById('resultsContainer').innerHTML = html)
    .catch(err => {
      document.getElementById('resultsContainer').innerHTML = '<p style="color:red;">Error loading report.</p>';
      console.error(err);
    });
}

// --- When user clicks Apply Filter ---
document.getElementById('applyFilter').addEventListener('click', loadReport);

// --- Reset filters ---
document.getElementById('resetFilter').addEventListener('click', () => {
  document.getElementById('filterForm').reset();
  loadReport(); // reload all marks
});

// --- Export to Excel ---
document.getElementById('exportExcel').addEventListener('click', () => {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  window.location.href = `<?= BASE_URL ?>backend/export_student_marks_excel.php?${params.toString()}`;
});

// --- 🚀 AUTO LOAD when page opens ---
window.addEventListener('DOMContentLoaded', loadReport);
</script>


<?php include 'partials/footer.php'; ?>
