<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

// Fetch fee types, classes
$feeTypes = $conn->query("SELECT id, name, default_amount FROM fee_types ORDER BY name");
$classes = $conn->query("SELECT id, class_name FROM classes ORDER BY class_name");
?>
<h2>🏷 Assign Fees</h2>
<p>Assign fee types to students by class+section or to selected individual students.</p>

<div style="background:#f9f9f9; padding:15px; border-radius:10px; margin-bottom:20px; max-width:900px;">
  <form method="post" action="<?= BASE_URL ?>backend/assign_fees.php">
    <?= csrf_field() ?>

    <label>Assign To</label><br>
    <label><input type="radio" name="scope" value="class" checked> Entire Class / Section</label>
    &nbsp;&nbsp;
    <label><input type="radio" name="scope" value="individual"> Individual Students</label>

    <hr>

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

    <div id="individualBox" style="display:none; margin-top:10px;">
      <label>Select Students (multi-select)</label>
      <select id="student_select" name="student_ids[]" multiple style="width:100%; height:180px; padding:8px;">
        <!-- populated by JS -->
      </select>
      <div style="font-size:12px;color:#666;margin-top:6px;">Hold Ctrl (or Cmd) to select multiple students.</div>
    </div>

    <hr>

    <label>Fee Type:</label>
    <select id="fee_type_id" name="fee_type_id" required>
      <option value="">-- Select Fee Type --</option>
      <?php while($f = $feeTypes->fetch_assoc()): ?>
        <option value="<?= $f['id'] ?>" data-default="<?= $f['default_amount'] ?>">
          <?= esc($f['name']) ?> (Default: <?= number_format($f['default_amount'], 2) ?>)
        </option>
      <?php endwhile; ?>
    </select>

    <label>Amount (LKR):</label>
    <input type="number" name="amount" id="amount" step="0.01" min="0" placeholder="Enter or auto-fill from Fee Type" required>

    <label>Term (Optional):</label>
    <input type="text" name="term" placeholder="e.g., Term 1, January 2025">

    <label>Due Date:</label>
    <input type="date" name="due_date" required>

    <br><br>
    <button type="submit">💾 Assign Fees</button>
  </form>
</div>

<hr>

<h3>📋 Recently Assigned Fees</h3>
<table border="1" cellpadding="8" style="width:100%; border-collapse:collapse; background:#fff;">
  <thead style="background:#007bff; color:white;">
    <tr>
      <th>Student</th>
      <th>Fee Type</th>
      <th>Amount</th>
      <th>Status</th>
      <th>Due Date</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $res = $conn->query("
      SELECT sf.*, s.first_name, s.last_name, ft.name AS fee_name
      FROM student_fees sf
      JOIN students s ON sf.student_id=s.id
      JOIN fee_types ft ON sf.fee_type_id=ft.id
      ORDER BY sf.id DESC LIMIT 10
    ");
    if ($res->num_rows === 0):
      echo "<tr><td colspan='5' style='text-align:center;'>No assigned fees yet.</td></tr>";
    else:
      while ($r = $res->fetch_assoc()):
        echo "<tr>
                <td>".esc($r['first_name'].' '.$r['last_name'])."</td>
                <td>".esc($r['fee_name'])."</td>
                <td>".number_format($r['amount'],2)."</td>
                <td>".esc($r['status'])."</td>
                <td>".esc($r['due_date'])."</td>
              </tr>";
      endwhile;
    endif;
    ?>
  </tbody>
</table>

<script>
// Auto-load sections when class changes
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
      // also clear student box
      document.getElementById('student_select').innerHTML = '';
    });
});

// When section changes, load students for individual selection
document.getElementById('section_id').addEventListener('change', function() {
  let classId = document.getElementById('class_id').value;
  let sectionId = this.value;
  if (!classId || !sectionId) {
    document.getElementById('student_select').innerHTML = '';
    return;
  }
  fetch('<?= BASE_URL ?>backend/get_students.php?class_id=' + classId + '&section_id=' + sectionId)
    .then(res => res.json())
    .then(data => {
      let sel = document.getElementById('student_select');
      sel.innerHTML = '';
      data.forEach(s => {
        sel.innerHTML += `<option value="${s.id}">${s.admission_no} - ${s.first_name} ${s.last_name}</option>`;
      });
    });
});

// Toggle individual box vs class mode
document.querySelectorAll('input[name="scope"]').forEach(r => {
  r.addEventListener('change', function() {
    document.getElementById('individualBox').style.display = (this.value === 'individual') ? 'block' : 'none';
    // Make student_select required only when individual
    document.getElementById('student_select').required = (this.value === 'individual');
  });
});

// Auto-fill default amount from fee type
document.getElementById('fee_type_id').addEventListener('change', function() {
  let selected = this.options[this.selectedIndex];
  document.getElementById('amount').value = selected.dataset.default || '';
});
</script>

<?php include 'partials/footer.php'; ?>
