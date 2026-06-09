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

  echo "
  <div class='empty-box'>
    <i class='fas fa-house-circle-xmark'></i>
    <h3>No House Assigned</h3>
    <p>Please contact the administrator.</p>
  </div>";

  include '../partials/portal_footer.php';
  exit;
}

/* ===============================
   ACTIVE ACADEMIC YEAR
================================ */
$year = $conn->query("
  SELECT id
  FROM academic_years
  WHERE is_active=1
  LIMIT 1
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

  $total += ($r['action'] === 'ADD'
      ? $r['points']
      : -$r['points']);

  $rows[] = $r;
}
?>

<style>
/* ================= PAGE TITLE ================= */
.page-title{
    font-size:30px;
    font-weight:700;
    margin-bottom:24px;
    display:flex;
    align-items:center;
    gap:12px;
}

/* ================= HOUSE HEADER ================= */
.house-header{
    background:#fff;
    border-radius:22px;
    padding:24px;
    display:flex;
    align-items:center;
    gap:24px;
    margin-bottom:24px;
    border-left:8px solid;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
}

.house-logo{
    width:100px;
    height:100px;
    border-radius:20px;
    background:#f8f9fa;
    padding:14px;
    object-fit:contain;
    box-shadow:0 4px 14px rgba(0,0,0,.08);
}

.house-info h3{
    margin:0;
    font-size:28px;
    font-weight:700;
}

.house-info p{
    margin:8px 0;
    color:#555;
    font-size:15px;
}

.total-points{
    margin-top:12px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:12px 18px;
    border-radius:14px;
    background:#f4f8ff;
    color:#0d6efd;
    font-weight:700;
    font-size:15px;
}

/* ================= TABLE ================= */
.table-wrap{
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
}

.house-table{
    width:100%;
    border-collapse:collapse;
}

.house-table thead{
    background:linear-gradient(135deg,#0d6efd,#0056b3);
    color:#fff;
}

.house-table th{
    padding:16px;
    text-align:left;
    font-size:14px;
    font-weight:600;
}

.house-table td{
    padding:16px;
    border-bottom:1px solid #f1f1f1;
    font-size:14px;
    color:#333;
}

.house-table tr:hover{
    background:#f9fbff;
}

/* ================= BADGES ================= */
.badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:7px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:700;
}

.badge.add{
    background:#e6f9ec;
    color:#157347;
}

.badge.deduct{
    background:#fdecea;
    color:#b02a37;
}

/* ================= POINT COLORS ================= */
.points-add{
    color:#198754;
    font-weight:700;
}

.points-deduct{
    color:#dc3545;
    font-weight:700;
}

/* ================= MOBILE CARDS ================= */
.mobile-cards{
    display:none;
}

.log-card{
    background:#fff;
    border-radius:20px;
    padding:18px;
    margin-bottom:16px;
    box-shadow:0 6px 20px rgba(0,0,0,.06);
}

.log-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:12px;
}

.log-date{
    font-size:13px;
    color:#777;
}

.log-reason{
    margin-top:12px;
    color:#444;
    line-height:1.5;
}

.log-points{
    margin-top:14px;
    font-size:20px;
    font-weight:700;
}

/* ================= EMPTY ================= */
.empty-box{
    background:#fff;
    border-radius:20px;
    padding:40px 20px;
    text-align:center;
    box-shadow:0 6px 20px rgba(0,0,0,.06);
}

.empty-box i{
    font-size:60px;
    color:#ccc;
    margin-bottom:14px;
}

.empty-box h3{
    margin:0;
    font-size:24px;
}

.empty-box p{
    color:#777;
}

/* ================= MOBILE ================= */
@media(max-width:768px){

    .page-title{
        font-size:24px;
    }

    .house-header{
        flex-direction:column;
        text-align:center;
        padding:22px 18px;
    }

    .house-logo{
        width:90px;
        height:90px;
    }

    .house-info h3{
        font-size:24px;
    }

    .table-wrap{
        display:none;
    }

    .mobile-cards{
        display:block;
    }

    .log-card{
        padding:16px;
    }

    .log-points{
        font-size:18px;
    }
}
</style>

<h2 class="page-title">
    <i class="fas fa-shield-halved"></i>
    My House
</h2>

<!-- ================= HOUSE HEADER ================= -->
<div class="house-header"
     style="border-color:<?= esc($student['color']) ?>">

    <img src="../uploads/houses/<?= esc($student['logo']) ?>"
         class="house-logo">

    <div class="house-info">

        <h3 style="color:<?= esc($student['color']) ?>">
            <?= esc($student['house_name']) ?>
        </h3>

        <p>
            <i class="fas fa-user"></i>
            Student:
            <b><?= esc($student['student_name']) ?></b>
        </p>

        <div class="total-points">

            <i class="fas fa-star"></i>

            Total Contribution:
            <?= $total ?> Points

        </div>

    </div>

</div>

<!-- ================= DESKTOP TABLE ================= -->
<div class="table-wrap">

<table class="house-table">

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
  <td colspan="4"
      style="text-align:center;color:#777;padding:24px;">

      No contributions yet.

  </td>
</tr>

<?php endif; ?>

<?php foreach($rows as $l): ?>

<tr>

  <td>
    <?= date('d M Y • h:i A', strtotime($l['created_at'])) ?>
  </td>

  <td>

    <span class="badge <?= strtolower($l['action']) ?>">

      <?php if($l['action'] == 'ADD'): ?>

        <i class="fas fa-arrow-up"></i>&nbsp; Added

      <?php else: ?>

        <i class="fas fa-arrow-down"></i>&nbsp; Deducted

      <?php endif; ?>

    </span>

  </td>

  <td class="<?= $l['action']=='ADD'
      ? 'points-add'
      : 'points-deduct' ?>">

      <?= $l['action']=='ADD' ? '+' : '-' ?>
      <?= $l['points'] ?>

  </td>

  <td>
    <?= esc($l['reason']) ?>
  </td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<!-- ================= MOBILE VIEW ================= -->
<div class="mobile-cards">

<?php if(empty($rows)): ?>

<div class="empty-box">

    <i class="fas fa-star"></i>

    <h3>No Contributions Yet</h3>

</div>

<?php endif; ?>

<?php foreach($rows as $l): ?>

<div class="log-card">

    <div class="log-top">

        <div class="log-date">
            <?= date('d M Y • h:i A', strtotime($l['created_at'])) ?>
        </div>

        <span class="badge <?= strtolower($l['action']) ?>">

            <?php if($l['action'] == 'ADD'): ?>

                <i class="fas fa-arrow-up"></i>&nbsp; Added

            <?php else: ?>

                <i class="fas fa-arrow-down"></i>&nbsp; Deducted

            <?php endif; ?>

        </span>

    </div>

    <div class="log-reason">
        <?= esc($l['reason']) ?>
    </div>

    <div class="log-points <?= $l['action']=='ADD'
        ? 'points-add'
        : 'points-deduct' ?>">

        <?= $l['action']=='ADD' ? '+' : '-' ?>
        <?= $l['points'] ?> Points

    </div>

</div>

<?php endforeach; ?>

</div>

<?php include '../partials/portal_footer.php'; ?>