<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$exams = $conn->query("SELECT id, exam_name FROM exams ORDER BY exam_name");
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
?>

<h2>📊 Student Report Cards (Excel Export)</h2>
<p>Filter by exam, class, or section and export results as Excel.</p>

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

    <button type="button" id="applyFilter">Apply</button>
    <button type="button" id="resetFilter">Reset</button>
  </form>
</div>

<div style="margin:10px 0;">
  <button id="exportExcel">📗 Export to Excel</button>
</div>

<div id="reportContainer">
  <p>Loading report...</p>
</div>

<script>
// Load sections dynamically
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

// Load report
function loadReport() {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  fetch(`<?= BASE_URL ?>backend/fetch_report_card.php?${params.toString()}`)
    .then(res => res.text())
    .then(html => document.getElementById('reportContainer').innerHTML = html)
    .catch(err => {
      document.getElementById('reportContainer').innerHTML = '<p style="color:red;">Error loading report.</p>';
      console.error(err);
    });
}

document.getElementById('applyFilter').addEventListener('click', loadReport);
document.getElementById('resetFilter').addEventListener('click', () => {
  document.getElementById('filterForm').reset();
  loadReport();
});

document.getElementById('exportExcel').addEventListener('click', () => {
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
  window.location.href = `<?= BASE_URL ?>backend/export_report_card_excel.php?${params.toString()}`;
});

// Auto load initially
window.addEventListener('DOMContentLoaded', loadReport);

document.addEventListener('click', e => {
  if(e.target.classList.contains('viewBtn')) {
    const studentId = e.target.dataset.student;
    const examId = e.target.dataset.exam;
    const row = e.target.closest('tr');

    // Create / locate detail row
    let detailRow = row.nextElementSibling;
    if(detailRow && detailRow.classList.contains('detailRow')) {
      detailRow.remove(); // toggle off if already open
      return;
    }

    fetch(`<?= BASE_URL ?>backend/fetch_student_marks.php?student_id=${studentId}&exam_id=${examId}`)
      .then(res => res.text())
      .then(html => {
        const newRow = document.createElement('tr');
        newRow.classList.add('detailRow');
        newRow.innerHTML = `<td colspan="9" style="background:#f9f9f9;">${html}</td>`;
        row.insertAdjacentElement('afterend', newRow);
      })
      .catch(err => console.error(err));
  }
});
</script>

<?php include 'partials/footer.php'; ?>
