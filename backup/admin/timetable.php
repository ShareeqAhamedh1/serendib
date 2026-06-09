<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

// Fetch dropdown data
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
$teachers = $conn->query("SELECT id, CONCAT(first_name,' ',last_name) AS teacher_name FROM teachers ORDER BY first_name");
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
?>

<h2>Class Timetable</h2>
<a href="<?= BASE_URL ?>admin/add-timetable.php" class="btn">➕ Add Period</a>

<!-- ✅ FILTERS -->
<div style="margin:20px 0; padding:10px; background:#f2f2f2; border-radius:6px;">
  <form id="filterForm" method="get" action="">
    <label>Class:</label>
    <select id="classFilter" name="class_id">
      <option value="">All Classes</option>
      <?php while($c = $classes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Section:</label>
    <select id="sectionFilter" name="section_id">
      <option value="">All Sections</option>
    </select>

    <label>Teacher:</label>
    <select id="teacherFilter" name="teacher_id">
      <option value="">All Teachers</option>
      <?php while($t = $teachers->fetch_assoc()): ?>
        <option value="<?= $t['id'] ?>"><?= esc($t['teacher_name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Day:</label>
    <select id="dayFilter" name="day">
      <option value="">All Days</option>
      <?php foreach($days as $d): ?>
        <option value="<?= $d ?>"><?= $d ?></option>
      <?php endforeach; ?>
    </select>

    <button type="button" id="applyFilter">Apply Filter</button>
    <button type="button" id="clearFilter">Clear</button>
  </form>
</div>

<!-- ✅ TIMETABLE TABLE -->
<div id="timetableContainer">
  <p>Loading timetable...</p>
</div>
<div id="periodCount" style="margin-top:10px; font-weight:bold;"></div>

<script>
// Fetch sections dynamically when class changes
document.getElementById('classFilter').addEventListener('change', function() {
  const classId = this.value;
  const sectionDropdown = document.getElementById('sectionFilter');
  sectionDropdown.innerHTML = '<option value="">All Sections</option>';
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

// Fetch filtered timetable dynamically
function loadTimetable() {
  const classId = document.getElementById('classFilter').value;
  const sectionId = document.getElementById('sectionFilter').value;
  const teacherId = document.getElementById('teacherFilter').value;
  const day = document.getElementById('dayFilter').value;

  const params = new URLSearchParams({
    class_id: classId,
    section_id: sectionId,
    teacher_id: teacherId,
    day: day
  });

  fetch(`<?= BASE_URL ?>backend/fetch_timetable.php?${params.toString()}`)
    .then(res => res.text())
    .then(html => {
      document.getElementById('timetableContainer').innerHTML = html;

      // ✅ Extract the count text from the response (if it exists)
      const match = html.match(/Showing (\d+) period/);
      const periodCountDiv = document.getElementById('periodCount');
      if (match) {
        periodCountDiv.textContent = `Total: ${match[1]} ${match[1] == 1 ? 'period' : 'periods'}`;
      } else {
        periodCountDiv.textContent = '';
      }
    })
    .catch(err => {
      document.getElementById('timetableContainer').innerHTML = `<p style='color:red'>Error loading timetable</p>`;
      console.error(err);
    });
}

// Initial load
window.addEventListener('DOMContentLoaded', loadTimetable);

// Handle filter buttons
document.getElementById('applyFilter').addEventListener('click', loadTimetable);
document.getElementById('clearFilter').addEventListener('click', () => {
  document.getElementById('filterForm').reset();
  loadTimetable();
});
</script>


<?php include 'partials/footer.php'; ?>
