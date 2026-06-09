<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Logged-in teacher
$user_id = $_SESSION['user_id'] ?? 0;

// Get teacher id
$tRow = $conn->query("SELECT id, first_name, last_name FROM teachers WHERE user_id = $user_id LIMIT 1")->fetch_assoc();
$teacher_id = (int)($tRow['id'] ?? 0);
if (!$teacher_id) {
  echo "<p style='color:red;'>Teacher record not found.</p>";
  include '../partials/portal_footer.php';
  exit;
}

// Get teacher's assigned class + section
$assign = $conn->query("
  SELECT 
    tc.class_id, tc.section_id,
    c.class_name, s.section_name
  FROM teacher_classes tc
  JOIN classes c ON c.id = tc.class_id
  JOIN sections s ON s.id = tc.section_id
  WHERE tc.teacher_id = $teacher_id
  LIMIT 1
")->fetch_assoc();

if (!$assign) {
  echo "
  <div style='background:#fef3c7; padding:15px; border-radius:8px; color:#b45309;'>
    ⚠️ <b>No Class Assigned</b><br>
    You are not assigned to any class yet. Please contact the administrator.
  </div>";
  include '../partials/portal_footer.php';
  exit;
}

$class_id = (int)$assign['class_id'];
$section_id = (int)$assign['section_id'];

$daysMap = [
  'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3,
  'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7
];
$dayNames = array_keys($daysMap);
$todayName = date('l'); // e.g., Monday

// Filter by day (All by default)
$dayFilter = $_GET['day'] ?? 'all';
$dayFilter = in_array($dayFilter, $dayNames) ? $dayFilter : 'all';

// Build query
$baseSql = "
  SELECT 
    tt.day_of_week, tt.period_number, tt.start_time, tt.end_time,
    s.subject_name,
    t.first_name AS teacher_first, t.last_name AS teacher_last
  FROM timetable tt
  JOIN subjects s ON s.id = tt.subject_id
  JOIN teachers t ON t.id = tt.teacher_id
  WHERE tt.class_id = $class_id AND tt.section_id = $section_id
";

if ($dayFilter !== 'all') {
  $baseSql .= " AND tt.day_of_week = '". $conn->real_escape_string($dayFilter) ."' ";
}

// Order by day-of-week (Mon..Sun) then start_time
$baseSql .= "
  ORDER BY FIELD(tt.day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'),
           tt.start_time
";

$rows = $conn->query($baseSql);
?>

<style>
  .card { background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.08); }
  .filters { display:flex; gap:10px; align-items:center; margin-bottom:15px; }
  .filters select, .filters button { padding:8px 10px; border:1px solid #ddd; border-radius:6px; }
  .btn { padding:8px 12px; border-radius:6px; text-decoration:none; border:1px solid #007bff; color:#007bff; background:#fff; cursor:pointer; }
  .btn.primary { background:#007bff; color:#fff; border-color:#007bff; }
  .table { width:100%; border-collapse:collapse; background:#fff; }
  .table th, .table td { padding:10px; border-bottom:1px solid #eee; }
  .table th { background:#007bff; color:#fff; text-align:left; }
  .day-header { margin:18px 0 8px; font-weight:700; }
  .row-today { background:#fffaf0; } /* highlight today */
  @media print{
    .filters, .print-hide { display:none !important; }
    .card { box-shadow:none; }
    body { background:#fff; }
  }
</style>

<h2>🗓 Student Timetable — <?= esc($assign['class_name']) ?> / <?= esc($assign['section_name']) ?></h2>

<div class="card">

  <!-- Filters -->
  <form class="filters" method="get" action="class-timetable.php">
    <label><b>Day:</b></label>
    <select name="day">
      <option value="all" <?= $dayFilter==='all'?'selected':'' ?>>All days</option>
      <?php foreach ($dayNames as $dn): ?>
        <option value="<?= $dn ?>" <?= $dayFilter===$dn?'selected':'' ?>><?= $dn ?></option>
      <?php endforeach; ?>
    </select>

    <button class="btn primary" type="submit">Apply</button>
    <button class="btn" type="button" onclick="window.print()">Print</button>
  </form>

  <?php if(!$rows || $rows->num_rows === 0): ?>
    <p style="color:#888">No timetable entries found.</p>
  <?php else: ?>

    <?php
    // Render grouped by day when "all", otherwise single table
    if ($dayFilter === 'all'):
      $currentDay = '';
      while($r = $rows->fetch_assoc()):
        if ($currentDay !== $r['day_of_week']) {
          // close previous table
          if ($currentDay !== '') {
            echo "</tbody></table>";
          }
          $currentDay = $r['day_of_week'];
          $isToday = ($currentDay === $todayName);
          echo "<div class='day-header'".($isToday ? " style='color:#d97706'" : "").">" . esc($currentDay) . ($isToday ? " (Today)" : "") . "</div>";
          echo "<table class='table'><thead><tr>
                  <th>Time</th><th>Period</th><th>Subject</th><th>Teacher</th>
                </tr></thead><tbody>";
        }

        $rowClass = ($r['day_of_week'] === $todayName) ? "row-today" : "";
        ?>
        <tr class="<?= $rowClass ?>">
          <td><?= esc(substr($r['start_time'],0,5)) ?> - <?= esc(substr($r['end_time'],0,5)) ?></td>
          <td><?= (int)$r['period_number'] ?></td>
          <td><?= esc($r['subject_name']) ?></td>
          <td><?= esc(($r['teacher_first'].' '.$r['teacher_last'])) ?></td>
        </tr>
        <?php
      endwhile;
      echo "</tbody></table>";
    else:
      // Single day table
      ?>
      <div class="day-header" style="color:<?= $dayFilter===$todayName ? '#d97706' : '#333' ?>">
        <?= esc($dayFilter) ?><?= $dayFilter===$todayName ? " (Today)" : "" ?>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>Time</th><th>Period</th><th>Subject</th><th>Teacher</th>
          </tr>
        </thead>
        <tbody>
          <?php $rows->data_seek(0); while($r = $rows->fetch_assoc()): ?>
            <tr class="<?= $dayFilter===$todayName ? 'row-today' : '' ?>">
              <td><?= esc(substr($r['start_time'],0,5)) ?> - <?= esc(substr($r['end_time'],0,5)) ?></td>
              <td><?= (int)$r['period_number'] ?></td>
              <td><?= esc($r['subject_name']) ?></td>
              <td><?= esc(($r['teacher_first'].' '.$r['teacher_last'])) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>

  <?php endif; ?>
</div>

<?php include '../partials/portal_footer.php'; ?>
