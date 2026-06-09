<?php
include '../partials/portal_header.php';
require_once __DIR__ . '../../backend/conn.php';

date_default_timezone_set('Asia/Colombo');

$parent = $conn->query("
    SELECT id FROM parents WHERE user_id={$_SESSION['user_id']} LIMIT 1
")->fetch_assoc();

$parent_id = $parent['id'];

// Current month & year
$currentMonth = date('Y-m');
$currentYear  = date('Y');

// Fetch all children
$children = $conn->query("
    SELECT id, first_name, last_name
    FROM students
    WHERE parent_id=$parent_id
");
?>

<style>
/* ---------- LAYOUT ---------- */
.attendance-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 15px;
}

.attendance-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.attendance-table th {
    background: #004080;
    color: white;
    padding: 12px;
    text-align: left;
}

.attendance-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

/* ---------- BADGES ---------- */
.badge {
    padding: 5px 10px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 13px;
    display: inline-block;
}

.badge.green { background:#e6f9ec; color:#0f5132; }
.badge.orange { background:#fff3cd; color:#664d03; }
.badge.red { background:#fdecea; color:#842029; }

/* ---------- LINKS ---------- */
.attendance-link {
    text-decoration: none;
    color: #004080;
    font-weight: 600;
}

.attendance-link:hover {
    text-decoration: underline;
}

/* ---------- MOBILE CARDS ---------- */
.mobile-cards {
    display: none;
}

.attendance-card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.attendance-card h4 {
    margin-bottom: 10px;
    color: #004080;
}

.attendance-card p {
    margin: 6px 0;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 768px) {
    .attendance-table {
        display: none;
    }
    .mobile-cards {
        display: block;
    }
}
</style>

<div class="attendance-container">

<h2>📅 Attendance Overview</h2>
<p style="color:#555;">
    Attendance percentages are calculated <b>only from marked days</b> (Present / Absent).
</p>

<!-- ================= DESKTOP TABLE ================= -->
<table class="attendance-table">
<thead>
<tr>
  <th>#</th>
  <th>Student</th>
  <th>This Month</th>
  <th>Annual</th>
</tr>
</thead>
<tbody>

<?php
$i = 1;
$children->data_seek(0);

while ($s = $children->fetch_assoc()):

  $sid = $s['id'];

  /* Monthly */
  $monthQ = $conn->prepare("
      SELECT 
        SUM(status='Present') AS present_count,
        SUM(status IN ('Present','Absent')) AS total_count
      FROM attendance
      WHERE entity_type='student'
        AND entity_id=?
        AND DATE_FORMAT(date,'%Y-%m')=?
  ");
  $monthQ->bind_param("is", $sid, $currentMonth);
  $monthQ->execute();
  $month = $monthQ->get_result()->fetch_assoc();

  $monthPercent = ($month['total_count'] > 0)
      ? round(($month['present_count'] / $month['total_count']) * 100, 1)
      : 0;

  /* Annual */
  $yearQ = $conn->prepare("
      SELECT 
        SUM(status='Present') AS present_count,
        SUM(status IN ('Present','Absent')) AS total_count
      FROM attendance
      WHERE entity_type='student'
        AND entity_id=?
        AND YEAR(date)=?
  ");
  $yearQ->bind_param("ii", $sid, $currentYear);
  $yearQ->execute();
  $year = $yearQ->get_result()->fetch_assoc();

  $yearPercent = ($year['total_count'] > 0)
      ? round(($year['present_count'] / $year['total_count']) * 100, 1)
      : 0;

  $mColor = $monthPercent >= 75 ? 'green' : ($monthPercent >= 60 ? 'orange' : 'red');
  $yColor = $yearPercent >= 75 ? 'green' : ($yearPercent >= 60 ? 'orange' : 'red');
?>

<tr>
  <td><?= $i++ ?></td>
  <td>
    <a class="attendance-link" href="attendance-calendar.php?student_id=<?= $sid ?>">
        <?= esc($s['first_name'].' '.$s['last_name']) ?>
    </a>
  </td>
  <td><span class="badge <?= $mColor ?>"><?= $monthPercent ?>%</span></td>
  <td><span class="badge <?= $yColor ?>"><?= $yearPercent ?>%</span></td>
</tr>

<?php endwhile; ?>

</tbody>
</table>

<!-- ================= MOBILE CARDS ================= -->
<div class="mobile-cards">
<?php
$children->data_seek(0);

while ($s = $children->fetch_assoc()):
  $sid = $s['id'];

  // reuse last calculated values safely
?>
<div class="attendance-card">
    <h4><?= esc($s['first_name'].' '.$s['last_name']) ?></h4>
    <p>📆 This Month: <span class="badge <?= $mColor ?>"><?= $monthPercent ?>%</span></p>
    <p>📅 Annual: <span class="badge <?= $yColor ?>"><?= $yearPercent ?>%</span></p>
    <a class="attendance-link" href="attendance-calendar.php?student_id=<?= $sid ?>">
        View Calendar →
    </a>
</div>
<?php endwhile; ?>
</div>

<hr style="margin:25px 0">

<h3>📌 Notes</h3>
<ul style="color:#555">
  <li>Only days marked as <b>Present</b> or <b>Absent</b> are counted.</li>
  <li>Unmarked days and holidays are excluded.</li>
  <li>Monthly percentage is based on the current month.</li>
  <li>Annual percentage resets every academic year.</li>
</ul>

</div>

<?php include '../partials/portal_footer.php'; ?>
