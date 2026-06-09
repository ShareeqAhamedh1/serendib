<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

// Fetch dropdown data
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY subject_name");
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
?>

<h2>Mark Attendance</h2>

<div style="margin:20px 0; padding:15px; background:#f9f9f9; border-radius:8px;">
  <form id="attendanceForm" method="post" action="">
    <label>Class:</label>
    <select id="classSelect" name="class_id" required>
      <option value="">-- Select Class --</option>
      <?php while($c=$classes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Section:</label>
    <select id="sectionSelect" name="section_id">
      <option value="">-- Select Section --</option>
    </select>

    <label>Subject:</label>
    <select id="subjectSelect" name="subject_id">
      <option value="">-- Select Subject --</option>
      <?php while($s=$subjects->fetch_assoc()): ?>
        <option value="<?= $s['id'] ?>"><?= esc($s['subject_name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Date:</label>
    <input type="date" id="attDate" name="date" required value="<?= date('Y-m-d') ?>">

    <label>Period:</label>
    <select id="periodSelect" name="period_number">
      <option value="">-- Select Period --</option>
      <?php for($i=1; $i<=8; $i++): ?>
        <option value="<?= $i ?>">Period <?= $i ?></option>
      <?php endfor; ?>
    </select>

    <button type="button" id="loadStudents">Load Students</button>
  </form>
</div>

<!-- Student List -->
<div id="studentList" style="margin-top:20px;"></div>

<script>
// Fetch sections dynamically
document.getElementById('classSelect').addEventListener('change', function() {
  const classId = this.value;
  const sectionDropdown = document.getElementById('sectionSelect');
  sectionDropdown.innerHTML = '<option value="">-- Select Section --</option>';
  if (!classId) return;

  fetch(`<?= BASE_URL ?>backend/fetch_sections.php?class_id=${classId}`)
    .then(res => res.json())
    .then(data => {
      data.forEach(s => {
        const opt = document.createElement('option');
        opt.value = s.id;
        opt.textContent = s.section_name;
        sectionDropdown.appendChild(opt);
      });
    });
});

// Load students for class/section
document.getElementById('loadStudents').addEventListener('click', function() {
  const classId = document.getElementById('classSelect').value;
  const sectionId = document.getElementById('sectionSelect').value;
  const date = document.getElementById('attDate').value;
  const subjectId = document.getElementById('subjectSelect').value;
  const period = document.getElementById('periodSelect').value;

  if (!classId || !date) {
    alert('Please select at least class and date');
    return;
  }

  fetch(`<?= BASE_URL ?>backend/fetch_students_for_attendance.php?class_id=${classId}&section_id=${sectionId}&subject_id=${subjectId}&period=${period}&date=${date}`)
    .then(res => res.text())
    .then(html => {
      document.getElementById('studentList').innerHTML = html;
    });
});
</script>

<?php include 'partials/footer.php'; ?>
