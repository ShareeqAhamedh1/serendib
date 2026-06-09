<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d');
?>

<h2>📋 Quick Attendance Scanner</h2>
<p>Scan or enter <b>Student Admission No</b> or <b>Teacher Code</b> to mark <b>Time In / Time Out</b> for <b><?= $date ?></b>.</p>

<div style="margin:20px 0; background:#f8f8f8; padding:20px; border-radius:10px; max-width:500px;">
  <form id="scannerForm" method="post" action="<?= BASE_URL ?>backend/save_scanned_attendance.php">
    <?= csrf_field() ?>
    <label>Scan / Enter ID:</label><br>
    <input 
      type="text" 
      id="scanInput" 
      name="scan_code" 
      placeholder="e.g., S001 or T001" 
      autofocus 
      autocomplete="off"
      style="padding:12px; font-size:18px; width:100%; border:2px solid #007bff; border-radius:6px;"
      required>
    <button type="submit" style="margin-top:10px;">Submit</button>
  </form>
</div>

<div id="resultBox" style="margin-top:20px; padding:10px; border-radius:8px; background:#f9f9f9;">
  Waiting for scan...
</div>

<hr style="margin:30px 0;">
<a href="../backend/auto_mark_absent.php" 
   class="btn-sm" 
   onclick="return confirm('Mark all unmarked as absent?')">
   ✅ Process Absent
</a>


<h3>✅ Today's Attendance</h3>
<table border="1" cellpadding="6" style="width:100%; border-collapse:collapse; background:#fff;">
  <thead>
    <tr style="background:#007bff; color:white;">
      <th>Type</th>
      <th>Name</th>
      <th>Code</th>
      <th>Time In</th>
      <th>Time Out</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody id="attendanceTable"></tbody>
</table>

<script>
const form = document.getElementById('scannerForm');
const input = document.getElementById('scanInput');
const resultBox = document.getElementById('resultBox');
const table = document.getElementById('attendanceTable');

form.addEventListener('submit', e => {
  e.preventDefault();
  const formData = new FormData(form);

  fetch(form.action, {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    input.value = '';
    input.focus();

    if (data.success) {
      // Message style depends on IN or OUT
      const color = data.action === 'out' ? '#ff8800' : '#28a745';
      const actionText = data.action === 'out' ? 'Time Out' : 'Time In';
      resultBox.innerHTML = `
        <p style="color:${color}">
          <b>${data.name}</b> (${data.role}) marked <b>${actionText}</b> ✅ at ${data.time}
        </p>
      `;
      addOrUpdateRow(data.role, data.name, data.code, data.time, data.action);
    } else {
      resultBox.innerHTML = `<p style="color:red">⚠️ ${data.message}</p>`;
    }
  })
  .catch(err => {
    resultBox.innerHTML = `<p style="color:red">❌ Error connecting to server.</p>`;
    console.error(err);
  });
});

// --- Update table row or add new one ---
function addOrUpdateRow(type, name, code, time, action) {
  const rows = [...table.rows];
  let row = rows.find(r => r.cells[2]?.textContent === code);

  if (!row) {
    // Create new row
    row = document.createElement('tr');
    row.innerHTML = `
      <td>${type}</td>
      <td>${name}</td>
      <td>${code}</td>
      <td>${action === 'in' ? time : '-'}</td>
      <td>${action === 'out' ? time : '-'}</td>
      <td>${action === 'out' ? 'Completed' : 'Present'}</td>
    `;
    table.prepend(row);
  } else {
    // Update existing row
    if (action === 'in') row.cells[3].textContent = time;
    if (action === 'out') {
      row.cells[4].textContent = time;
      row.cells[5].textContent = 'Completed';
    }
  }
}

// Always refocus on scanner box
window.addEventListener('click', () => input.focus());

// --- Load today's attendance on page load ---
function loadTodayAttendance() {
  fetch("<?= BASE_URL ?>backend/fetch_today_attendance.php")
    .then(res => res.json())
    .then(rows => {
      table.innerHTML = ''; // clear table
      if (!rows.length) {
        const empty = document.createElement('tr');
        empty.innerHTML = `<td colspan="6" style="text-align:center; color:gray;">No attendance marked yet today.</td>`;
        table.appendChild(empty);
        return;
      }
      rows.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${r.type}</td>
          <td>${r.name}</td>
          <td>${r.code}</td>
          <td>${r.time_in}</td>
          <td>${r.time_out}</td>
          <td>${r.status}</td>
        `;
        table.appendChild(tr);
      });
    })
    .catch(err => console.error('Error loading attendance:', err));
}

// Load today's attendance once the page is ready
window.addEventListener('DOMContentLoaded', loadTodayAttendance);

</script>

<?php include 'partials/footer.php'; ?>
