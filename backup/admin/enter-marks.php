<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$exams = $conn->query("SELECT id, exam_name FROM exams WHERE status='Active' ORDER BY exam_name");
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY subject_name");
?>

<h2>✏️ Enter Marks</h2>
<p>Select exam, class, section and subject to enter marks.</p>

<form id="filterForm" method="GET" action="">
  <label>Exam:</label>
  <select id="exam_id" name="exam_id" required>
    <option value="">-- Select Exam --</option>
    <?php while($e = $exams->fetch_assoc()): ?>
      <option value="<?= $e['id'] ?>"><?= esc($e['exam_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Class:</label>
  <select id="class_id" name="class_id" required>
    <option value="">-- Select Class --</option>
    <?php while($c = $classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Section:</label>
  <select id="section_id" name="section_id" required>
    <option value="">-- Select Section --</option>
  </select>

  <label>Subject:</label>
  <select id="subject_id" name="subject_id" required>
    <option value="">-- Select Subject --</option>
    <?php while($s = $subjects->fetch_assoc()): ?>
      <option value="<?= $s['id'] ?>"><?= esc($s['subject_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <button type="button" id="loadBtn">Load Students</button>
</form>

<hr>
<div id="marksContainer">
  <p>Waiting for selection...</p>
</div>

<script>
// Load sections dynamically
document.getElementById('class_id').addEventListener('change', function(){
  const id = this.value;
  const secSelect = document.getElementById('section_id');
  secSelect.innerHTML = '<option value="">Loading...</option>';
  fetch(`<?= BASE_URL ?>backend/get_sections.php?class_id=${id}`)
    .then(r=>r.json())
    .then(d=>{
      secSelect.innerHTML = '<option value="">-- Select Section --</option>';
      d.forEach(s=> secSelect.innerHTML += `<option value="${s.id}">${s.section_name}</option>`);
    });
});

// Load students for mark entry
document.getElementById('loadBtn').addEventListener('click', ()=>{
  const params = new URLSearchParams(new FormData(document.getElementById('filterForm'))).toString();
  fetch(`<?= BASE_URL ?>backend/fetch_students_for_marks.php?${params}`)
    .then(r=>r.text())
    .then(html=> document.getElementById('marksContainer').innerHTML = html)
    .catch(err=> document.getElementById('marksContainer').innerHTML='<p style="color:red;">Error loading students.</p>');
});
</script>

<?php include 'partials/footer.php'; ?>
