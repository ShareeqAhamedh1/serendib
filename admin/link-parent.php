<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Save link
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'], $_POST['parent_id'])) {
  $student_id = (int)$_POST['student_id'];
  $parent_id = (int)$_POST['parent_id'];
  $conn->query("UPDATE students SET parent_id=$parent_id WHERE id=$student_id");
  echo "<div id='msgBox' style='background:#d4edda; color:#155724; padding:10px; border-radius:6px;'>
          ✅ Parent linked successfully.
        </div>";
}

$students = $conn->query("SELECT id, admission_no, first_name, last_name FROM students ORDER BY first_name");
$parents = $conn->query("SELECT id, full_name FROM parents ORDER BY full_name");
?>

<h2>🔗 Link Parent to Student</h2>
<p>Select a student and assign their parent. You can also type to search or add a new parent.</p>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<form method="post" id="linkForm" style="background:#f9f9f9; padding:15px; border-radius:8px; max-width:650px;">
  <label>Student:</label>
  <select id="studentSelect" name="student_id" required style="width:100%; margin-bottom:10px;">
    <option value="">Select Student</option>
    <?php while($s = $students->fetch_assoc()): ?>
      <option value="<?= $s['id'] ?>">
        <?= esc($s['first_name'].' '.$s['last_name'].' ('.$s['admission_no'].')') ?>
      </option>
    <?php endwhile; ?>
  </select>

  <label>Parent:</label>
  <div style="display:flex; gap:10px; align-items:center;">
    <select id="parentSelect" name="parent_id" required style="flex:1;">
      <option value="">Select Parent</option>
      <?php while($p = $parents->fetch_assoc()): ?>
        <option value="<?= $p['id'] ?>"><?= esc($p['full_name']) ?></option>
      <?php endwhile; ?>
    </select>
    <button type="button" id="addParentBtn" style="padding:6px 10px;">➕ Add Parent</button>
  </div>

  <br>
  <button type="submit">✅ Link Parent</button>
</form>

<!-- ✅ Add Parent Modal -->
<div id="addParentModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;">
  <div style="background:#fff; width:420px; margin:100px auto; padding:20px; border-radius:8px; position:relative;">
    <h3>➕ Add New Parent</h3>
    <form id="addParentForm">
      <label>Full Name:</label>
      <input type="text" name="full_name" required style="width:100%; margin-bottom:10px;">

      <label>Email:</label>
      <input type="email" name="email" required style="width:100%; margin-bottom:10px;">

      <label>Phone:</label>
      <input type="text" name="phone" style="width:100%; margin-bottom:10px;">

      <label>Occupation:</label>
      <input type="text" name="occupation" style="width:100%; margin-bottom:10px;">

      <label>Address:</label>
      <textarea name="address" style="width:100%; margin-bottom:10px;"></textarea>

      <div style="text-align:right;">
        <button type="button" id="cancelParentBtn">Cancel</button>
        <button type="submit">💾 Save Parent</button>
      </div>
    </form>
  </div>
</div>

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
  // ✅ Initialize searchable dropdowns
  $('#studentSelect').select2({
    placeholder: "Select or type to search student",
    allowClear: true,
    width: 'resolve'
  });

  $('#parentSelect').select2({
    placeholder: "Select or type to search parent",
    allowClear: true,
    width: 'resolve'
  });

  // ✅ Show / hide modal
  $('#addParentBtn').on('click', () => $('#addParentModal').fadeIn());
  $('#cancelParentBtn').on('click', () => $('#addParentModal').fadeOut());

  // ✅ Handle Add Parent form (AJAX)
  $('#addParentForm').on('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('<?= BASE_URL ?>backend/add_parent_ajax.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      if (data.success) {
        $('#addParentModal').fadeOut();
        // Refresh parent dropdown dynamically
        $('#parentSelect').append(
          new Option(data.parent_name, data.parent_id, true, true)
        ).trigger('change');
      }
    })
    .catch(err => {
      console.error(err);
      alert('Error adding parent.');
    });
  });

  // ✅ Hide success messages automatically
  setTimeout(() => {
    $('#msgBox').fadeOut();
  }, 2500);
});
</script>

<?php include 'partials/footer.php'; ?>
