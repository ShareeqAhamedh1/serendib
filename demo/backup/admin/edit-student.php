<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch student
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
  echo "<p style='color:red;'>Student not found</p>";
  include 'partials/footer.php';
  exit;
}

// Fetch classes
$classesRes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");

// Fetch sections for the student's current class
$class_id = $student['class_id'] ?? 0;
$secStmt = $conn->prepare("SELECT id, section_name FROM sections WHERE class_id = ?");
$secStmt->bind_param("i", $class_id);
$secStmt->execute();
$sections = $secStmt->get_result();
?>

<h2>Edit Student</h2>

<form method="post" action="<?= BASE_URL ?>backend/students.php?action=update" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= esc($student['id']) ?>">

  <!-- 🔵 Admission No (Readonly) -->
  <label>Admission No</label>
  <input 
      name="admission_no" 
      value="<?= esc($student['admission_no']) ?>" 
      readonly
      style="background:#eee; cursor:not-allowed;">
  <small style="color:gray;">Auto-generated, cannot be modified.</small>

  <!-- 🧑 Student Info -->
  <label>First Name</label>
  <input name="first_name" required value="<?= esc($student['first_name']) ?>">

  <label>Last Name</label>
  <input name="last_name" required value="<?= esc($student['last_name']) ?>">

  <label>Gender</label>
  <select name="gender">
    <option value="male"   <?= $student['gender']=='male'?'selected':'' ?>>Male</option>
    <option value="female" <?= $student['gender']=='female'?'selected':'' ?>>Female</option>
    <option value="other"  <?= $student['gender']=='other'?'selected':'' ?>>Other</option>
  </select>

  <label>DOB</label>
  <input type="date" name="dob" value="<?= esc($student['dob']) ?>">

  <!-- 🌐 Medium -->
  <label>Medium</label>
  <select name="medium" required>
    <option value="">-- Select Medium --</option>
    <option value="Sinhala" <?= $student['medium']=='Sinhala'?'selected':'' ?>>Sinhala</option>
    <option value="Tamil" <?= $student['medium']=='Tamil'?'selected':'' ?>>Tamil</option>
    <option value="English" <?= $student['medium']=='English'?'selected':'' ?>>English</option>
  </select>

  <!-- 🏫 Class & Section -->
  <label>Class</label>
  <select name="class_id" id="class_id" required>
    <option value="">-- Select Class --</option>
    <?php while($c = $classesRes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>" <?= ($student['class_id']==$c['id'])?'selected':'' ?>>
        <?= esc($c['class_name']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <label>Section</label>
  <select name="section_id" id="section_id" required>
    <option value="">-- Select Section --</option>
    <?php while($s = $sections->fetch_assoc()): ?>
      <option value="<?= $s['id'] ?>" <?= ($student['section_id']==$s['id'])?'selected':'' ?>>
        <?= esc($s['section_name']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <!-- 🏠 Address -->
  <label>Address</label>
  <textarea name="address" style="height:70px;"><?= esc($student['address']) ?></textarea>

  <!-- 📅 Admission Date -->
  <label>Admission Date</label>
  <input type="date" name="admission_date" value="<?= esc($student['admission_date']) ?>">

  <!-- ✅ Status -->
  <label>Status</label>
  <select name="status">
    <option value="active"   <?= $student['status']=='active'?'selected':'' ?>>Active</option>
    <option value="inactive" <?= $student['status']=='inactive'?'selected':'' ?>>Inactive</option>
    <option value="left"     <?= $student['status']=='left'?'selected':'' ?>>Left School</option>
  </select>

  <!-- 🖼 Photo -->
  <label>Photo (leave empty to keep current)</label>
  <input type="file" name="photo" accept="image/*">

  <?php if(!empty($student['photo'])): ?>
    <div style="margin-top:6px;">
      <strong>Current:</strong><br>
      <img src="<?= BASE_URL ?>uploads/<?= esc($student['photo']) ?>" width="80" style="border-radius:5px;margin-top:5px;">
    </div>
  <?php endif; ?>

  <br>
  <button type="submit" class="btn btn-primary">💾 Save Changes</button>
</form>

<script>
// Auto load sections when class changes
document.getElementById('class_id').addEventListener('change', function () {
  const classId = this.value;
  const sec = document.getElementById('section_id');
  sec.innerHTML = '<option>Loading...</option>';

  fetch('<?= BASE_URL ?>backend/get_sections.php?class_id=' + classId)
    .then(res => res.json())
    .then(data => {
      sec.innerHTML = '<option value="">-- Select Section --</option>';
      data.forEach(row => {
        sec.innerHTML += `<option value="${row.id}">${row.section_name}</option>`;
      });
    });
});
</script>

<?php include 'partials/footer.php'; ?>
