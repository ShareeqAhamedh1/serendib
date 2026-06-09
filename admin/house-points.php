<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

/* ===============================
   ACTIVE ACADEMIC YEAR
================================ */
$year = $conn->query("
  SELECT id, year_name
  FROM academic_years
  WHERE is_active = 1
  LIMIT 1
")->fetch_assoc();

if (!$year) {
  die('No active academic year found');
}

/* ===============================
   FETCH HOUSE TOTALS
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


/* ===============================
   LOG FILTERS + PAGINATION
================================ */
$limit = 10;
$page  = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$f_house  = (int)($_GET['house'] ?? 0);
$f_action = $_GET['action'] ?? '';
$f_source = $_GET['source'] ?? '';

$where = ["l.academic_year_id={$year['id']}"];

if ($f_house)  $where[] = "l.house_id=$f_house";
if ($f_action) $where[] = "l.action='".$conn->real_escape_string($f_action)."'";
if ($f_source) $where[] = "l.source='".$conn->real_escape_string($f_source)."'";

$whereSql = 'WHERE ' . implode(' AND ', $where);

/* COUNT */
$totalRows = $conn->query("
  SELECT COUNT(*) total
  FROM house_point_logs l
  $whereSql
")->fetch_assoc()['total'];

$pages = max(1, ceil($totalRows / $limit));

/* FETCH LOGS */
$logs = $conn->query("
SELECT 
  l.*,
  h.name AS house_name,
  h.color,

  CASE
    WHEN l.entity_type = 'student'
      THEN CONCAT(s.first_name,' ',s.last_name)
    ELSE 'House'
  END AS display_name

FROM house_point_logs l
JOIN houses h 
  ON h.id = l.house_id

LEFT JOIN students s
  ON l.entity_type = 'student'
 AND l.entity_id = s.id

$whereSql
ORDER BY l.created_at DESC
LIMIT $limit OFFSET $offset
");

?>
<!-- ================= STYLES ================= -->
<style>
.page-title{margin-bottom:20px}

.house-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:18px;
  margin-bottom:30px;
}
.house-card{
  background:#fff;
  border:3px solid;
  border-radius:16px;
  padding:18px;
  text-align:center;
  box-shadow:0 6px 18px rgba(0,0,0,.08);
}
.house-logo{
  width:150px;height:150px;
  object-fit:contain;
  margin-bottom:10px;
}
.points{
  font-size:26px;
  font-weight:700;
  margin:10px 0;
}
.actions button{
  margin:4px;
  padding:8px 12px;
  border:none;
  border-radius:8px;
  cursor:pointer;
  font-weight:600;
}
.btn-add{background:#198754;color:#fff}
.btn-deduct{background:#dc3545;color:#fff}

.filter-bar{
  display:flex;gap:8px;flex-wrap:wrap;margin-bottom:15px
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
.badge.add{background:#e6f9ec;color:#0f5132}
.badge.deduct{background:#fdecea;color:#842029}

.pagination{
  display:flex;
  flex-wrap:wrap;
  gap:8px;
  margin-top:20px;
  align-items:center;
}

.pagination a{
  min-width:38px;
  height:38px;
  display:flex;
  align-items:center;
  justify-content:center;
  border:1px solid #ccc;
  border-radius:8px;
  text-decoration:none;
  background:#fff;
  color:#005c2e;
  font-weight:600;
  transition:.2s;
}

.pagination a:hover{
  background:#eaf5ee;
}

.pagination a.active{
  background:#005c2e;
  color:#fff;
  border-color:#005c2e;
}
.btn-remove{
  background:#6c757d;
  color:#fff;
  border:none;
  padding:6px 10px;
  border-radius:6px;
  cursor:pointer;
  font-size:13px;
}
.btn-remove:hover{
  background:#495057;
}

</style>
<h2 class="page-title">
  🏆 House Cup – <?= esc($year['year_name']) ?>
</h2>

<!-- ================= HOUSE CARDS ================= -->
<div class="house-grid">
<?php while($h=$houses->fetch_assoc()): ?>
  <div class="house-card" style="border-color:<?= $h['color'] ?>">
    <img src="../uploads/houses/<?= esc($h['logo']) ?>"
         class="house-logo"
         alt="<?= esc($h['name']) ?>">

    <div class="points" style="color:<?= $h['color'] ?>">
      <?= $h['points'] ?> pts
    </div>

    <div class="actions">
      <button onclick="modifyPoints(<?= $h['id'] ?>,'ADD')" class="btn-add">➕ Add</button>
      <button onclick="modifyPoints(<?= $h['id'] ?>,'DEDUCT')" class="btn-deduct">➖ Deduct</button>
    </div>
  </div>
<?php endwhile; ?>
</div>

<hr>

<!-- ================= LOG FILTER ================= -->
<form method="get" class="filter-bar">
  <select name="house">
    <option value="">All Houses</option>
    <?php
    $hs = $conn->query("SELECT id,name FROM houses");
    while($r=$hs->fetch_assoc()):
    ?>
      <option value="<?= $r['id'] ?>" <?= $f_house==$r['id']?'selected':'' ?>>
        <?= esc($r['name']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <select name="action">
    <option value="">All Actions</option>
    <option value="ADD" <?= $f_action=='ADD'?'selected':'' ?>>ADD</option>
    <option value="DEDUCT" <?= $f_action=='DEDUCT'?'selected':'' ?>>DEDUCT</option>
  </select>

  <select name="source">
    <option value="">All Sources</option>
    <option value="ADMIN" <?= $f_source=='ADMIN'?'selected':'' ?>>ADMIN</option>
    <option value="HOMEWORK" <?= $f_source=='HOMEWORK'?'selected':'' ?>>HOMEWORK</option>
    <option value="DISCIPLINE" <?= $f_source=='DISCIPLINE'?'selected':'' ?>>DISCIPLINE</option>
  </select>

  <button class="btn-filter">Filter</button>

  <?php if($f_house||$f_action||$f_source): ?>
    <a href="house-points.php" class="btn-reset">Reset</a>
  <?php endif; ?>
</form>

<!-- ================= LOG TABLE ================= -->
<table class="table">
<thead>
<tr>
  <th>Date</th>
  <th>House</th>
  <th>Student</th>
  <th>Action</th>
  <th>Points</th>
  <th>Reason</th>
  <th>Source</th>
  <th>Actions</th>
</tr>
</thead>
<tbody>
<?php if($logs->num_rows==0): ?>
<tr><td colspan="6" style="text-align:center;color:#777">No records</td></tr>
<?php endif; ?>

<?php while($l=$logs->fetch_assoc()): ?>
<tr>
  <td><?= date('d M Y H:i', strtotime($l['created_at'])) ?></td>
  <td style="color:<?= $l['color'] ?>;font-weight:600">
    <?= esc($l['house_name']) ?>
  </td>
<td>
  <?= esc($l['display_name']) ?>
</td>


  <td>
    <span class="badge <?= strtolower($l['action']) ?>">
      <?= $l['action'] ?>
    </span>
  </td>
  <td><?= $l['points'] ?></td>
  <td><?= esc($l['reason']) ?></td>
<td><?= esc($l['source']) ?></td>

<td>
<?php if (
    strtoupper($l['source']) === 'HOMEWORK' ||
    strtoupper($l['source']) === 'ADMIN'
): ?>
  <button class="btn-remove"
    onclick="removePoints(<?= $l['id'] ?>)">
    ❌ Remove
  </button>
<?php else: ?>
  —
<?php endif; ?>
</td>

</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- ================= PAGINATION ================= -->
<?php if($pages > 1): ?>

<?php
$start = max(1, $page - 2);
$end   = min($pages, $page + 2);
?>

<div class="pagination">

  <!-- PREVIOUS -->
  <?php if($page > 1): ?>
    <a href="?page=<?= $page-1 ?>&house=<?= $f_house ?>&action=<?= $f_action ?>&source=<?= $f_source ?>">
      ←
    </a>
  <?php endif; ?>

  <!-- FIRST PAGE -->
  <?php if($start > 1): ?>
    <a href="?page=1&house=<?= $f_house ?>&action=<?= $f_action ?>&source=<?= $f_source ?>">
      1
    </a>

    <?php if($start > 2): ?>
      <span class="dots">...</span>
    <?php endif; ?>
  <?php endif; ?>

  <!-- MIDDLE PAGES -->
  <?php for($p = $start; $p <= $end; $p++): ?>
    <a class="<?= $p==$page?'active':'' ?>"
       href="?page=<?= $p ?>&house=<?= $f_house ?>&action=<?= $f_action ?>&source=<?= $f_source ?>">
       <?= $p ?>
    </a>
  <?php endfor; ?>

  <!-- LAST PAGE -->
  <?php if($end < $pages): ?>

    <?php if($end < $pages - 1): ?>
      <span class="dots">...</span>
    <?php endif; ?>

    <a href="?page=<?= $pages ?>&house=<?= $f_house ?>&action=<?= $f_action ?>&source=<?= $f_source ?>">
      <?= $pages ?>
    </a>
  <?php endif; ?>

  <!-- NEXT -->
  <?php if($page < $pages): ?>
    <a href="?page=<?= $page+1 ?>&house=<?= $f_house ?>&action=<?= $f_action ?>&source=<?= $f_source ?>">
      →
    </a>
  <?php endif; ?>

</div>
<?php endif; ?>



<!-- ================= JS ================= -->
<script>
function modifyPoints(house, action){
  Swal.fire({
    title: action + ' Points',
    html: `
      <select id="targetType" class="swal2-input">
        <option value="HOUSE">House</option>
        <option value="student">Student</option>
      </select>

      <select id="studentSelect" class="swal2-input" style="display:none">
        <option value="">Select Student</option>
      </select>

      <input id="points" type="number" class="swal2-input" placeholder="Points">
      <input id="reason" type="text" class="swal2-input" placeholder="Reason">
    `,
    didOpen: () => {
      const target = document.getElementById('targetType');
      const studentSelect = document.getElementById('studentSelect');

      target.onchange = () => {
        if (target.value === 'student') {
          studentSelect.style.display = 'block';

          fetch('../backend/list-house-students.php?house_id='+house)
            .then(r=>r.json())
            .then(d=>{
              studentSelect.innerHTML = '<option value="">Select Student</option>';
              d.forEach(s=>{
                studentSelect.innerHTML +=
                  `<option value="${s.id}">${s.name}</option>`;
              });
            });
        } else {
          studentSelect.style.display = 'none';
          studentSelect.value = '';
        }
      };
    },
    showCancelButton:true,

    /* ✅ VALIDATION HERE */
    preConfirm: () => {
      const target = document.getElementById('targetType').value;
      const studentId = document.getElementById('studentSelect').value;
      const points = document.getElementById('points').value;
      const reason = document.getElementById('reason').value.trim();

      if (!points || Number(points) <= 0) {
        Swal.showValidationMessage('⚠️ Points are required');
        return false;
      }

      if (!reason) {
        Swal.showValidationMessage('⚠️ Reason is required');
        return false;
      }

      if (target === 'student' && !studentId) {
        Swal.showValidationMessage('⚠️ Please select a student');
        return false;
      }

      return { target, student_id: studentId, points, reason };
    }
  }).then(res=>{
    if(!res.isConfirmed) return;

    fetch('../backend/add-house-points.php',{
      method:'POST',
      body:new URLSearchParams({
        house_id: house,
        action: action,
        points: res.value.points,
        reason: res.value.reason,
        entity_type: res.value.target === 'student' ? 'STUDENT' : '',
        entity_id: res.value.target === 'student' ? res.value.student_id : '',
        source: 'ADMIN'
      })
    }).then(()=>location.reload());
  });
}


function removePoints(logId){
  Swal.fire({
    icon:'warning',
    title:'Remove Points?',
    text:'This will permanently remove this points record.',
    showCancelButton:true,
    confirmButtonColor:'#dc3545',
    confirmButtonText:'Yes, remove'
  }).then(res=>{
    if(!res.isConfirmed) return;

    fetch('../backend/remove-house-points.php',{
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body:JSON.stringify({
        log_id:logId
      })
    })
    .then(r=>r.json())
    .then(resp=>{
      Swal.fire(resp.status, resp.message, resp.status)
        .then(()=>{
          if(resp.status === 'success'){
            location.reload();
          }
        });
    });
  });
}
</script>


<?php include 'partials/footer.php'; ?>
