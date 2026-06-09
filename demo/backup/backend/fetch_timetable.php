<?php
require 'conn.php';
require 'helpers.php';

$class_id = isset($_GET['class_id']) && $_GET['class_id'] !== '' ? (int)$_GET['class_id'] : null;
$section_id = isset($_GET['section_id']) && $_GET['section_id'] !== '' ? (int)$_GET['section_id'] : null;
$teacher_id = isset($_GET['teacher_id']) && $_GET['teacher_id'] !== '' ? (int)$_GET['teacher_id'] : null;
$day = $_GET['day'] ?? '';

$where = [];
$params = [];
$types = '';

if ($class_id) {
  $where[] = "t.class_id = ?";
  $types .= 'i';
  $params[] = $class_id;
}
if ($section_id) {
  $where[] = "t.section_id = ?";
  $types .= 'i';
  $params[] = $section_id;
}
if ($teacher_id) {
  $where[] = "t.teacher_id = ?";
  $types .= 'i';
  $params[] = $teacher_id;
}
if ($day) {
  $where[] = "t.day_of_week = ?";
  $types .= 's';
  $params[] = $day;
}

$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$q = "
SELECT t.id, c.class_name, sec.section_name, t.day_of_week, t.period_number,
       sub.subject_name, CONCAT(tr.first_name, ' ', tr.last_name) AS teacher_name,
       t.start_time, t.end_time
FROM timetable t
LEFT JOIN classes c ON t.class_id=c.id
LEFT JOIN sections sec ON t.section_id=sec.id
LEFT JOIN subjects sub ON t.subject_id=sub.id
LEFT JOIN teachers tr ON t.teacher_id=tr.id
$whereSql
ORDER BY c.class_name, FIELD(t.day_of_week,'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'), t.period_number
";

$stmt = $conn->prepare($q);
if ($where) $stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();

$count = $res->num_rows;
if ($count === 0) {
  echo "<p>No timetable records found.</p>";
  exit;
}
?>

<!-- ✅ PERIOD COUNT SUMMARY -->
<p style="font-weight:bold; margin-bottom:10px;">
  Showing <?= $count ?> <?= $count == 1 ? 'period' : 'periods' ?>
  <?php
    $details = [];
    if ($class_id) {
      $className = $conn->query("SELECT class_name FROM classes WHERE id=$class_id")->fetch_assoc()['class_name'] ?? '';
      $details[] = "for class <b>$className</b>";
    }
    if ($section_id) {
      $secName = $conn->query("SELECT section_name FROM sections WHERE id=$section_id")->fetch_assoc()['section_name'] ?? '';
      $details[] = "section <b>$secName</b>";
    }
    if ($teacher_id) {
      $tName = $conn->query("SELECT CONCAT(first_name,' ',last_name) AS name FROM teachers WHERE id=$teacher_id")->fetch_assoc()['name'] ?? '';
      $details[] = "teacher <b>$tName</b>";
    }
    if ($day) $details[] = "on <b>$day</b>";
    if (!empty($details)) echo implode(' ', $details);
  ?>
</p>

<!-- ✅ MAIN TIMETABLE TABLE -->
<table border="1" cellpadding="6" width="100%">
  <thead>
    <tr style="background:#e9e9e9;">
      <th>Class</th><th>Section</th><th>Day</th><th>Period</th>
      <th>Subject</th><th>Teacher</th><th>Start</th><th>End</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php while($r = $res->fetch_assoc()): ?>
    <tr>
      <td><?= esc($r['class_name']) ?></td>
      <td><?= esc($r['section_name']) ?></td>
      <td><?= esc($r['day_of_week']) ?></td>
      <td><?= esc($r['period_number']) ?></td>
      <td><?= esc($r['subject_name']) ?></td>
      <td><?= esc($r['teacher_name']) ?></td>
      <td><?= esc($r['start_time']) ?></td>
      <td><?= esc($r['end_time']) ?></td>
      <td>
        <a href="<?= BASE_URL ?>admin/add-timetable.php?id=<?= $r['id'] ?>">✏️ Edit</a> |
        <a href="<?= BASE_URL ?>backend/timetable.php?action=delete&id=<?= $r['id'] ?>" onclick="return confirm('Delete this period?')">🗑️ Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
