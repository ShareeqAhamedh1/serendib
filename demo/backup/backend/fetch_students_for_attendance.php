<?php
require 'conn.php';
require 'helpers.php';

$class_id = (int)($_GET['class_id'] ?? 0);
$section_id = !empty($_GET['section_id']) ? (int)$_GET['section_id'] : null;
$date = $_GET['date'] ?? date('Y-m-d');
$period = (int)($_GET['period'] ?? 0);

$where = "WHERE s.class_id = $class_id";
if ($section_id) $where .= " AND s.section_id = $section_id";

$res = $conn->query("SELECT s.id, s.first_name, s.last_name FROM students s $where ORDER BY s.first_name");
if (!$res->num_rows) {
  echo "<p>No students found for the selected class/section.</p>";
  exit;
}

echo "<form id='saveAttendanceForm'>";
echo csrf_field();
echo "<input type='hidden' name='class_id' value='$class_id'>";
echo "<input type='hidden' name='section_id' value='$section_id'>";
echo "<input type='hidden' name='date' value='$date'>";
echo "<input type='hidden' name='period_number' value='$period'>";

echo "<table border='1' cellpadding='6' width='100%'>";
echo "<tr><th>Student</th><th>Present</th><th>Absent</th><th>Late</th></tr>";

while($row = $res->fetch_assoc()) {
  echo "<tr>";
  echo "<td>" . esc($row['first_name'] . ' ' . $row['last_name']) . "</td>";
  echo "<td><input type='radio' name='status[{$row['id']}]' value='Present' checked></td>";
  echo "<td><input type='radio' name='status[{$row['id']}]' value='Absent'></td>";
  echo "<td><input type='radio' name='status[{$row['id']}]' value='Late'></td>";
  echo "</tr>";
}

echo "</table>";
echo "<button type='button' id='saveAttendanceBtn'>Save Attendance</button>";
echo "</form>";
?>

<script>
document.getElementById('saveAttendanceBtn').addEventListener('click', function() {
  const form = document.getElementById('saveAttendanceForm');
  const formData = new FormData(form);

  fetch('<?= BASE_URL ?>backend/save_attendance.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(txt => {
    alert(txt);
  })
  .catch(err => {
    alert('Error saving attendance');
    console.error(err);
  });
});
</script>
