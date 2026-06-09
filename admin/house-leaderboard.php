<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

/* ===============================
   ACTIVE ACADEMIC YEAR
================================ */
$year = $conn->query("
  SELECT id, year_name
  FROM academic_years
  WHERE is_active=1
  LIMIT 1
")->fetch_assoc();

if (!$year) die('No active academic year');

/* ===============================
   HOUSE TOTALS (RANKED)
================================ */
$houses = $conn->query("
  SELECT 
    h.id,
    h.name,
    h.color,
    h.logo,
    COALESCE(SUM(l.points),0) AS points
  FROM houses h
  LEFT JOIN house_point_logs l
    ON l.house_id = h.id
   AND l.academic_year_id = {$year['id']}
  GROUP BY h.id
  ORDER BY points DESC
");

?>

<h2 class="page-title">🏆 House Cup Leaderboard – <?= esc($year['year_name']) ?></h2>

<!-- ================= HOUSE LEADERBOARD ================= -->
<div class="house-leaderboard">
<?php 
$rank = 1;
while($h = $houses->fetch_assoc()):
?>
  <div class="house-rank <?= $rank==1?'winner':'' ?>">
    <div class="rank-badge">#<?= $rank ?></div>

    <img src="../uploads/houses/<?= esc($h['logo']) ?>" alt="<?= esc($h['name']) ?>">
    
    <h3 style="color:<?= $h['color'] ?>">
      
    </h3>

    <div class="points">
      <?= $h['points'] ?> pts
    </div>
  </div>
<?php 
$rank++;
endwhile; 
?>
</div>

<hr>

<!-- ================= STUDENT LEADERBOARD ================= -->
<?php
$houses->data_seek(0); // rewind
?>

<div class="students-by-house">

<?php while($house = $houses->fetch_assoc()): ?>

<?php
$students = $conn->query("
  SELECT 
    s.id,
    CONCAT(s.first_name,' ',s.last_name) AS name,
    COALESCE(SUM(l.points),0) AS total_points
  FROM house_point_logs l
  JOIN students s ON s.id = l.entity_id
  WHERE l.entity_type='student'
    AND l.house_id={$house['id']}
    AND l.academic_year_id={$year['id']}
  GROUP BY s.id
  ORDER BY total_points DESC
  LIMIT 10
");

?>

<div class="house-column" style="--house-color: <?= esc($house['color']) ?>">

  <div class="house-header">
    <img src="../uploads/houses/<?= esc($house['logo']) ?>">
   
  </div>

  <?php
  $pos = 1;
  while($s = $students->fetch_assoc()):
  ?>
    <div class="student-card 
      <?= $pos==1?'gold':($pos==2?'silver':($pos==3?'bronze':'')) ?>
    ">
      <div class="rank">
        <?= $pos==1?'🥇':($pos==2?'🥈':($pos==3?'🥉':'#'.$pos)) ?>
      </div>

      <div class="name"><?= esc($s['name']) ?></div>
      <div class="points"><?= $s['total_points'] ?> pts</div>
    </div>
  <?php
    $pos++;
  endwhile;

  if ($students->num_rows == 0):
  ?>
    <div class="empty">No contributors yet</div>
  <?php endif; ?>

</div>

<?php endwhile; ?>
</div>


<!-- ================= STYLES ================= -->
<style>
.page-title{
  margin-bottom:20px;
}

/* ===== HOUSE LEADERBOARD ===== */
.house-leaderboard{
  display:flex;
  gap:18px;
  flex-wrap:wrap;
  margin-bottom:30px;
}
.house-rank{
  background:#fff;
  padding:20px;
  border-radius:18px;
  width:320px;
  text-align:center;
  box-shadow:0 8px 22px rgba(0,0,0,.12);
  position:relative;
}
.house-rank.winner{
  transform:scale(1.08);
  border:4px solid gold;
}
.rank-badge{
  position:absolute;
  top:-12px;
  right:-12px;
  background:#000;
  color:#fff;
  padding:6px 10px;
  border-radius:50%;
  font-weight:700;
}
.house-rank img{
  width:90px;
  height:90px;
  object-fit:contain;
}
.house-rank .points{
  font-size:26px;
  font-weight:800;
  margin-top:8px;
}

/* ===== STUDENT LEADERBOARD ===== */
.house-title{
  margin-top:30px;
}
.student-leaderboard{
  display:flex;
  gap:12px;
  flex-wrap:wrap;
  margin-bottom:25px;
}
.student-card{
  background:#fff;
  padding:14px 16px;
  border-radius:14px;
  min-width:180px;
  text-align:center;
  box-shadow:0 4px 14px rgba(0,0,0,.08);
}
.student-card.gold{
  transform:scale(1.15);
  border:3px solid gold;
}
.student-card.silver{
  transform:scale(1.08);
  border:3px solid silver;
}
.student-card.bronze{
  transform:scale(1.05);
  border:3px solid #cd7f32;
}
.student-rank{
  font-size:22px;
}
.student-name{
  font-weight:700;
  margin:6px 0;
}
.student-points{
  font-size:18px;
}
/* ===== STUDENTS SIDE BY SIDE ===== */
.students-by-house{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
  gap:20px;
  margin-top:30px;
}

.house-column{
  background:#fff;
  border-top:6px solid var(--house-color);
  border-radius:18px;
  padding:16px;
  box-shadow:0 8px 22px rgba(0,0,0,.12);
}

.house-header{
  text-align:center;
  margin-bottom:12px;
}

.house-header img{
  width:70px;
  height:70px;
  object-fit:contain;
}

.house-header h3{
  margin:6px 0 0;
  color:var(--house-color);
}

/* ===== STUDENT CARDS ===== */
.student-card{
  background:#f8f9fa;
  border-left:5px solid var(--house-color);
  border-radius:12px;
  padding:10px 12px;
  margin-bottom:8px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  box-shadow:0 3px 10px rgba(0,0,0,.08);
}

.student-card.gold{
  transform:scale(1.12);
  background:#fffbea;
  border-left-color:gold;
  font-weight:700;
}

.student-card.silver{
  transform:scale(1.06);
  border-left-color:silver;
}

.student-card.bronze{
  transform:scale(1.03);
  border-left-color:#cd7f32;
}

.rank{
  font-size:20px;
  width:40px;
}

.name{
  flex:1;
  font-weight:600;
}

.points{
  font-weight:700;
}

/* EMPTY */
.empty{
  text-align:center;
  color:#777;
  padding:10px;
}

</style>

<?php include 'partials/footer.php'; ?>
