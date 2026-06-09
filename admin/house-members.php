<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

/* ===============================
   PAGINATION + FILTERS
================================ */
$limit  = 12;
$page   = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$f_house = (int)($_GET['house'] ?? 0);
$f_type  = $_GET['type'] ?? '';


$where = [];
if ($f_house) $where[] = "hm.house_id = $f_house";
if ($f_type)  $where[] = "hm.entity_type = '".$conn->real_escape_string($f_type)."'";


$whereSql = $where ? 'WHERE '.implode(' AND ', $where) : '';

/* ===============================
   COUNT
================================ */
$totalRows = $conn->query("
  SELECT COUNT(*) total
  FROM house_members hm
  $whereSql
")->fetch_assoc()['total'];

$pages = max(1, ceil($totalRows / $limit));

/* ===============================
   FETCH MEMBERS
================================ */
$members = $conn->query("
SELECT
  hm.*,
  h.name AS house_name,
  h.color,
  h.logo,

  CASE
    WHEN hm.entity_type = 'student'
      THEN CONCAT(s.first_name,' ',s.last_name)
    WHEN hm.entity_type = 'teacher'
      THEN CONCAT(t.first_name,' ',t.last_name)
  END AS person_name

FROM house_members hm
JOIN houses h ON h.id = hm.house_id

LEFT JOIN students s
  ON hm.entity_type='student'
 AND hm.entity_id = s.id

LEFT JOIN teachers t
  ON hm.entity_type='teacher'
 AND hm.entity_id = t.id

$whereSql
ORDER BY hm.assigned_at DESC
LIMIT $limit OFFSET $offset
");


/* ===============================
   FILTER DATA
================================ */
$houses = $conn->query("SELECT id,name FROM houses");

?>

<h2 class="page-title">🏘️ House Members</h2>

<!-- ================= FILTER BAR ================= -->
<form method="get" class="filter-bar">

  <select name="house">
    <option value="">All Houses</option>
    <?php while($h=$houses->fetch_assoc()): ?>
      <option value="<?= $h['id'] ?>" <?= $f_house==$h['id']?'selected':'' ?>>
        <?= esc($h['name']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <select name="type">
    <option value="">All Types</option>
    <option value="student" <?= $f_type=='student'?'selected':'' ?>>Student</option>
    <option value="teacher" <?= $f_type=='teacher'?'selected':'' ?>>Teacher</option>
  </select>



  <button class="btn-filter">Filter</button>

  <?php if($f_house||$f_type): ?>
    <a href="house-members.php" class="btn-reset">Reset</a>
  <?php endif; ?>

</form>

<!-- ================= TABLE ================= -->
<table class="table">
<thead>
<tr>
  <th>Person</th>
  <th>Type</th>
  <th>House</th>
  <th>Assigned On</th>
</tr>

</thead>

<tbody>
<?php if($members->num_rows==0): ?>
<tr>
  <td colspan="5" style="text-align:center;color:#777">No members found</td>
</tr>
<?php endif; ?>

<?php while($m=$members->fetch_assoc()): ?>
<tr>
  <td><b><?= esc($m['person_name']) ?></b></td>

  <td>
    <span class="badge <?= $m['entity_type'] ?>">
      <?= ucfirst($m['entity_type']) ?>
    </span>
  </td>



  <td>
    <div class="house-chip" style="border-color:<?= $m['color'] ?>">
      <img src="../uploads/houses/<?= esc($m['logo']) ?>" alt="">
      <?= esc($m['house_name']) ?>
    </div>
  </td>

  <td><?= date('d M Y', strtotime($m['assigned_at'])) ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- ================= PAGINATION ================= -->
<?php if($pages>1): ?>
<div class="pagination">
<?php for($p=1;$p<=$pages;$p++): ?>
  <a class="<?= $p==$page?'active':'' ?>"
     href="?page=<?= $p ?>&house=<?= $f_house ?>&type=<?= $f_type ?>&grade=<?= $f_grade ?>">
     <?= $p ?>
  </a>
<?php endfor; ?>
</div>
<?php endif; ?>

<!-- ================= STYLES ================= -->
<style>
.page-title{margin-bottom:20px}

.filter-bar{
  display:flex;
  gap:10px;
  flex-wrap:wrap;
  margin-bottom:15px
}
.filter-bar select,.filter-bar button{
  padding:6px 10px
}
.btn-filter{background:#005c2e;color:#fff;border:none}
.btn-reset{background:#777;color:#fff;padding:6px 10px;text-decoration:none}

.badge{
  padding:4px 8px;
  border-radius:6px;
  font-size:12px;
  font-weight:700;
}
.badge.student{background:#e3f2fd;color:#0d47a1}
.badge.teacher{background:#fce4ec;color:#880e4f}

.house-chip{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:4px 8px;
  border:2px solid;
  border-radius:20px;
  font-weight:600;
}
.house-chip img{
  width:22px;
  height:22px;
  object-fit:contain;
}

.pagination a{
  padding:6px 10px;
  border:1px solid #ccc;
  border-radius:6px;
  margin-right:4px;
  text-decoration:none
}
.pagination a.active{
  background:#005c2e;
  color:#fff
}
</style>

<?php include 'partials/footer.php'; ?>
