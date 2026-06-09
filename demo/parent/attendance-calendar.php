<?php
include '../partials/portal_header.php';
require_once __DIR__ . '../../backend/conn.php';

date_default_timezone_set('Asia/Colombo');

$student_id = (int)($_GET['student_id'] ?? 0);
$month = $_GET['month'] ?? date('Y-m');

/* ---------------------------------------
   Validate parent → student relation
--------------------------------------- */
$check = $conn->prepare("
    SELECT s.first_name, s.last_name
    FROM students s
    JOIN parents p ON s.parent_id = p.id
    WHERE s.id = ? AND p.user_id = ?
");
$check->bind_param("ii", $student_id, $_SESSION['user_id']);
$check->execute();
$res = $check->get_result();
$student = $res->fetch_assoc();
$res->free();
$check->close();

if (!$student) {
    die("Access denied");
}

/* ---------------------------------------
   Date ranges
--------------------------------------- */
$firstDay = date('Y-m-01', strtotime($month));
$lastDay  = date('Y-m-t', strtotime($month));
$currentYear = date('Y');

/* ---------------------------------------
   FETCH MONTHLY ATTENDANCE
--------------------------------------- */
$attQ = $conn->prepare("
    SELECT date, status
    FROM attendance
    WHERE entity_type = 'student'
      AND entity_id = ?
      AND date BETWEEN ? AND ?
");
$attQ->bind_param("iss", $student_id, $firstDay, $lastDay);
$attQ->execute();

$attendance = [];
$monthPresent = 0;
$monthTotal   = 0;

$res = $attQ->get_result();
while ($r = $res->fetch_assoc()) {
    $attendance[$r['date']] = $r['status'];

    if (in_array($r['status'], ['present','absent'])) {
        $monthTotal++;
        if ($r['status'] === 'present') {
            $monthPresent++;
        }
    }
}
$res->free();
$attQ->close();

$monthPercent = $monthTotal > 0
    ? round(($monthPresent / $monthTotal) * 100, 1)
    : 0;

/* ---------------------------------------
   FETCH ANNUAL ATTENDANCE
--------------------------------------- */
$yearQ = $conn->prepare("
    SELECT status
    FROM attendance
    WHERE entity_type = 'student'
      AND entity_id = ?
      AND YEAR(date) = ?
");
$yearQ->bind_param("ii", $student_id, $currentYear);
$yearQ->execute();

$yearPresent = 0;
$yearTotal   = 0;

$res = $yearQ->get_result();
while ($r = $res->fetch_assoc()) {
    if (in_array($r['status'], ['present','absent'])) {
        $yearTotal++;
        if ($r['status'] === 'present') {
            $yearPresent++;
        }
    }
}
$res->free();
$yearQ->close();

$yearPercent = $yearTotal > 0
    ? round(($yearPresent / $yearTotal) * 100, 1)
    : 0;

/* ---------------------------------------
   Badge colors
--------------------------------------- */
function badgeColor($p) {
    if ($p >= 75) return 'green';
    if ($p >= 60) return 'orange';
    return 'red';
}
?>

<style>
.summary {
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin:15px 0;
}
.summary-box {
    background:white;
    padding:15px;
    border-radius:10px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
    min-width:200px;
}
.badge {
    padding:5px 10px;
    border-radius:12px;
    font-weight:600;
}
.green { background:#e6f9ec; color:#0f5132; }
.orange { background:#fff3cd; color:#664d03; }
.red { background:#fdecea; color:#842029; }

.calendar {
    display:grid;
    grid-template-columns: repeat(7,1fr);
    gap:8px;
}
.day {
    padding:10px;
    border-radius:6px;
    background:#f3f4f6;
    text-align:center;
    font-weight:bold;
}
.present { background:#d1fae5; color:#065f46; }
.absent  { background:#fee2e2; color:#991b1b; }
.empty   { background:#eee; color:#999; }
.weekday {
    background:#004080;
    color:white;
}
</style>

<h2>📅 Attendance Calendar</h2>
<p><b>Student:</b> <?= esc($student['first_name'].' '.$student['last_name']) ?></p>

<!-- ================= SUMMARY ================= -->
<div class="summary">
    <div class="summary-box">
        <p><b>📆 This Month</b></p>
        <span class="badge <?= badgeColor($monthPercent) ?>">
            <?= $monthPercent ?>%
        </span>
    </div>

    <div class="summary-box">
        <p><b>📅 Annual</b></p>
        <span class="badge <?= badgeColor($yearPercent) ?>">
            <?= $yearPercent ?>%
        </span>
    </div>
</div>

<form method="get" style="margin-bottom:15px;">
    <input type="hidden" name="student_id" value="<?= $student_id ?>">
    <input type="month" name="month" value="<?= $month ?>">
    <button>🔍 View</button>
    <a href="attendance-calendar.php?student_id=<?= $student_id ?>">🔄 Reset</a>
</form>

<!-- ================= CALENDAR ================= -->
<div class="calendar">
<?php
$weekdays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
foreach ($weekdays as $w) {
    echo "<div class='day weekday'>$w</div>";
}

$startDay = date('w', strtotime($firstDay));
for ($i = 0; $i < $startDay; $i++) {
    echo "<div class='day empty'></div>";
}

$daysInMonth = date('t', strtotime($month));
for ($d = 1; $d <= $daysInMonth; $d++) {

    $date = sprintf('%s-%02d', $month, $d);
    $status = $attendance[$date] ?? '';

    $class = 'day';
    if ($status === 'present') $class .= ' present';
    elseif ($status === 'absent') $class .= ' absent';

    echo "<div class='$class'>$d</div>";
}
?>
</div>

<p style="margin-top:15px;">
🟢 Present &nbsp;&nbsp;
🔴 Absent &nbsp;&nbsp;
⚪ Not Marked
</p>

<?php include '../partials/portal_footer.php'; ?>
