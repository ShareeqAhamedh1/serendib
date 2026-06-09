<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Auto-generate Admission No
$res = $conn->query("SELECT MAX(id) AS max_id FROM students");
$next = ($res->fetch_assoc()['max_id'] ?? 0) + 1;
$autoAdmissionNo = 'S' . str_pad($next, 4, '100', STR_PAD_LEFT);

// Fetch classes
$classesRes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");

// Fetch parents
$parentsRes = $conn->query("SELECT id, full_name FROM parents ORDER BY full_name");
?>

<h2>Add Student</h2>

<form method="post" action="<?= BASE_URL ?>backend/students.php?action=create" 
      enctype="multipart/form-data" 
      style="background:#fff; padding:20px; border-radius:10px; max-width:700px;">

  <?= csrf_field() ?>

  <h3>📘 Basic Information</h3>

  <label>Admission No</label>
  <input name="admission_no"
         value="<?= esc($autoAdmissionNo) ?>" 
         readonly
         style="background:#f0f0f0; cursor:not-allowed;">

  <div style="display:flex; gap:10px;">
    <div style="flex:1;">
      <label>First Name</label>
      <input name="first_name" required>
    </div>

    <div style="flex:1;">
      <label>Last Name</label>
      <input name="last_name" required>
    </div>
  </div>

  <label>Gender</label>
  <select name="gender" required>
    <option value="">-- Select --</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
    <option value="Other">Other</option>
  </select>

  <label>Date of Birth</label>
  <input type="date" name="dob">

  <label>Medium</label>
  <select name="medium" required>
    <option value="">-- Select Medium --</option>
    <option value="Sinhala">Sinhala</option>
    <option value="Tamil">Tamil</option>
    <option value="English">English</option>
  </select>

  <h3>🏫 Class Information</h3>

  <label>Class</label>
  <select name="class_id" id="class_id" required>
    <option value="">-- Select Class --</option>
    <?php while($c = $classesRes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Section</label>
  <select name="section_id" id="section_id" required>
    <option value="">-- Select Section --</option>
  </select>

  <h3>👨‍👩‍👧 Parent Information</h3>

  <label>Select Parent</label>
  <select name="parent_id" disabled style="background:#eaeaea;">
    <option value="">(No parent linked yet)</option>
    <?php while($p = $parentsRes->fetch_assoc()): ?>
      <option value="<?= $p['id'] ?>"><?= esc($p['full_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <small style="color:gray;">Parent can be linked later from "Link Parent to Student"</small>

  <h3>📍 Other Information</h3>

  <label>Address</label>
  <textarea name="address" rows="3"></textarea>

  <label>Admission Date</label>
  <input type="date" name="admission_date" value="<?= date('Y-m-d') ?>">

  <label>Status</label>
  <select name="status">
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
  </select>

  <label>Photo</label>
  <input type="file" name="photo" accept="image/*">

  <button type="submit" style="margin-top:15px;">✅ Add Student</button>
</form>

<script>
// Load sections when class changes
document.getElementById('class_id').addEventListener('change', function() {
  let classId = this.value;
  fetch('<?= BASE_URL ?>backend/get_sections.php?class_id=' + classId)
    .then(res => res.json())
    .then(data => {
      let sec = document.getElementById('section_id');
      sec.innerHTML = '<option value="">-- Select Section --</option>';
      data.forEach(row => {
        sec.innerHTML += `<option value="${row.id}">${row.section_name}</option>`;
      });
    });
});
</script>

<?php include 'partials/footer.php'; ?>
