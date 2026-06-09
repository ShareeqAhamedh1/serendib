<?php
include '../partials/portal_header.php';
require_once __DIR__.'/../backend/conn.php';
require_once __DIR__.'/../backend/helpers.php';

$user_id = $_SESSION['user_id'];

/* ===============================
   STUDENT + HOUSE
================================ */
$student = $conn->query("
  SELECT 
    s.id AS student_id,
    CONCAT(s.first_name,' ',s.last_name) AS student_name,
    h.id AS house_id,
    h.name AS house_name,
    h.color,
    h.logo
  FROM students s
  JOIN house_members hm
    ON hm.entity_type='student'
   AND hm.entity_id=s.id
  JOIN houses h ON h.id = hm.house_id
  WHERE s.user_id=$user_id
  LIMIT 1
")->fetch_assoc();

if(!$student){
  echo "<p>You are not assigned to a house yet.</p>";
  include '../partials/portal_footer.php';
  exit;
}

/* ===============================
   ACTIVE ACADEMIC YEAR
================================ */
$year = $conn->query("
  SELECT id FROM academic_years
  WHERE is_active=1 LIMIT 1
")->fetch_assoc();

$year_id = $year['id'] ?? 0;

/* ===============================
   CONTRIBUTION LOGS
================================ */
$logs = $conn->query("
  SELECT *
  FROM house_point_logs
  WHERE entity_type='student'
    AND entity_id={$student['student_id']}
    AND house_id={$student['house_id']}
    AND academic_year_id=$year_id
  ORDER BY created_at DESC
");

$rows = [];
$total = 0;

while ($r = $logs->fetch_assoc()) {
  $total += ($r['action'] === 'ADD' ? $r['points'] : -$r['points']);
  $rows[] = $r;
}
?>

<h2>🏰 My House</h2>

<!-- ================= HOUSE HEADER ================= -->
<div class="house-header" style="border-color:<?= esc($student['color']) ?>">
  <img src="../uploads/houses/<?= esc($student['logo']) ?>" alt="House Logo">

  <div>
    <h3 style="color:<?= esc($student['color']) ?>">
      <?= esc($student['house_name']) ?>
    </h3>

    <p>
      👤 Student: <b><?= esc($student['student_name']) ?></b>
    </p>

    <p>
      ⭐ Total Contribution: <b><?= $total ?> points</b>
    </p>
  </div>
</div>

<!-- ================= CONTRIBUTIONS TABLE ================= -->
<table class="table">
<thead>
<tr>
  <th>Date</th>
  <th>Action</th>
  <th>Points</th>
  <th>Reason</th>
</tr>
</thead>
<tbody>

<?php if(empty($rows)): ?>
<tr>
  <td colspan="4" style="text-align:center;color:#777">
    No contributions yet.
  </td>
</tr>
<?php endif; ?>

<?php foreach($rows as $l): ?>
<tr>
  <td><?= date('d M Y H:i', strtotime($l['created_at'])) ?></td>
  <td>
    <span class="badge <?= strtolower($l['action']) ?>">
      <?= $l['action'] ?>
    </span>
  </td>
  <td><?= $l['points'] ?></td>
  <td><?= esc($l['reason']) ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<!-- ================= STYLES ================= -->
<style>
.house-header{
  display:flex;
  align-items:center;
  gap:18px;
  background:#fff;
  padding:20px;
  border-left:6px solid;
  border-radius:14px;
  margin-bottom:20px;
  box-shadow:0 6px 16px rgba(0,0,0,.08);
}
.house-header img{
  width:80px;
  height:80px;
  object-fit:contain;
}
.badge{
  padding:4px 8px;
  border-radius:6px;
  font-size:12px;
  font-weight:700;
}
.badge.add{background:#e6f9ec;color:#0f5132}
.badge.deduct{background:#fdecea;color:#842029}
</style>

<?php include '../partials/portal_footer.php'; ?>
