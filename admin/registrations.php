<?php
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';
requireLogin();

/* =============================
   AJAX DELETE
============================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['ajax'] ?? '') === 'delete') {
    header('Content-Type: application/json');

    $id = (int)($_POST['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['success'=>false,'msg'=>'Invalid record']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM registrations WHERE id=?");
    $stmt->bind_param("i",$id);

    if($stmt->execute()){
        echo json_encode(['success'=>true,'msg'=>'Registration deleted']);
    } else {
        echo json_encode(['success'=>false,'msg'=>'Delete failed']);
    }
    exit;
}

include 'partials/header.php';

/* =============================
   FILTERS
============================= */

$gradeFilter  = $_GET['grade'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$fromDate     = $_GET['from'] ?? '';
$toDate       = $_GET['to'] ?? '';

$where = [];
$params = [];
$types = "";

/* Grade filter (STRING now) */
if ($gradeFilter !== '') {
    $where[] = "joining_grade = ?";
    $params[] = $gradeFilter;
    $types .= "s";
}

/* Status filter */
if ($statusFilter !== '') {
    $where[] = "status = ?";
    $params[] = $statusFilter;
    $types .= "s";
}

/* Date range */
if ($fromDate && $toDate) {
    $where[] = "DATE(created_at) BETWEEN ? AND ?";
    $params[] = $fromDate;
    $params[] = $toDate;
    $types .= "ss";
}

/* =============================
   PAGINATION
============================= */

$perPage = 10;
$page = max(1,(int)($_GET['page'] ?? 1));
$offset = ($page-1)*$perPage;

/* Count */
$countSql = "SELECT COUNT(*) FROM registrations";
if ($where) $countSql .= " WHERE ".implode(" AND ",$where);

$countStmt = $conn->prepare($countSql);
if ($params) $countStmt->bind_param($types,...$params);
$countStmt->execute();
$totalRows = $countStmt->get_result()->fetch_row()[0];
$totalPages = max(1,ceil($totalRows/$perPage));

/* Fetch */
$sql = "SELECT * FROM registrations";
if ($where) $sql .= " WHERE ".implode(" AND ",$where);
$sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);

if ($params) {
    $stmt->bind_param($types."ii", ...array_merge($params,[$perPage,$offset]));
} else {
    $stmt->bind_param("ii",$perPage,$offset);
}

$stmt->execute();
$res = $stmt->get_result();
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.page-title{margin-bottom:20px}
.filter-box{
  background:#fff;
  padding:18px;
  border-radius:12px;
  box-shadow:0 4px 18px rgba(0,0,0,0.05);
  margin-bottom:20px;
}
.filter-box select,
.filter-box input{
  padding:8px 10px;
  border-radius:8px;
  border:1px solid #ddd;
}
.btn{
  padding:8px 14px;
  border:none;
  border-radius:8px;
  cursor:pointer;
  font-weight:600;
}
.btn-primary{background:#007bff;color:#fff;}
.btn-danger{background:#dc3545;color:#fff;}
.table{
  width:100%;
  border-collapse:collapse;
  background:#fff;
  border-radius:12px;
  overflow:hidden;
  box-shadow:0 4px 18px rgba(0,0,0,0.05);
}
.table th{
  background:#007bff;
  color:#fff;
  padding:10px;
}
.table td{
  padding:10px;
  border-bottom:1px solid #eee;
}
.status-new{color:#ff9800;font-weight:600;}
.status-checked{color:#28a745;font-weight:600;}
.pagination a{
  padding:6px 10px;
  border-radius:6px;
  margin-right:5px;
  text-decoration:none;
  background:#f1f1f1;
}
.pagination a.active{
  background:#007bff;
  color:#fff;
}
</style>

<h2 class="page-title">📝 Student Registrations</h2>

<!-- FILTERS -->
<form method="get" class="filter-box">
  <div style="display:flex;gap:15px;flex-wrap:wrap;align-items:end;">

    <div>
      <label><b>Grade / Stream</b></label><br>
      <select name="grade">
        <option value="">All</option>
        <optgroup label="Grades">
          <?php for($g=6;$g<=11;$g++): ?>
            <option value="<?= $g ?>" <?= ($gradeFilter==$g)?'selected':'' ?>>
              Grade <?= $g ?>
            </option>
          <?php endfor; ?>
        </optgroup>
        <optgroup label="A/L 2028">
          <option value="2028_physical_science" <?= ($gradeFilter=='2028_physical_science')?'selected':'' ?>>2028 Physical Science</option>
          <option value="2028_biological_science" <?= ($gradeFilter=='2028_biological_science')?'selected':'' ?>>2028 Biological Science</option>
          <option value="2028_commerce" <?= ($gradeFilter=='2028_commerce')?'selected':'' ?>>2028 Commerce</option>
          <option value="2028_arts" <?= ($gradeFilter=='2028_arts')?'selected':'' ?>>2028 Arts</option>
        </optgroup>
      </select>
    </div>

    <div>
      <label><b>Status</b></label><br>
      <select name="status">
        <option value="">All</option>
        <option value="new" <?= ($statusFilter=='new')?'selected':'' ?>>New</option>
        <option value="checked" <?= ($statusFilter=='checked')?'selected':'' ?>>Checked</option>
      </select>
    </div>

    <div>
      <label><b>From</b></label><br>
      <input type="date" name="from" value="<?= esc($fromDate) ?>">
    </div>

    <div>
      <label><b>To</b></label><br>
      <input type="date" name="to" value="<?= esc($toDate) ?>">
    </div>

    <div>
      <button class="btn btn-primary">Filter</button>
      <a href="registrations.php" class="btn">Reset</a>
    </div>

  </div>
</form>

<!-- TABLE -->
<table class="table">
<thead>
<tr>
  <th>#</th>
  <th>Name</th>
  <th>Grade / Stream</th>
  <th>Parent</th>
  <th>Contact</th>
  <th>Submitted</th>
  <th>Status</th>
  <th>Actions</th>
</tr>
</thead>

<tbody>
<?php if($res->num_rows===0): ?>
<tr><td colspan="8" align="center">No registrations found</td></tr>
<?php else: $i=$offset+1; ?>
<?php while($r=$res->fetch_assoc()): ?>
<tr id="row<?= $r['id'] ?>">
  <td><?= $i++ ?></td>
  <td><?= esc($r['full_name']) ?></td>
  <td><?= esc($r['joining_grade']) ?></td>
  <td><?= esc($r['parent_name'] ?: '-') ?></td>
  <td><?= esc($r['parent_phone'] ?: $r['parent_email'] ?: '-') ?></td>
  <td><?= esc($r['created_at']) ?></td>
  <td>
    <?php if($r['status']=='new'): ?>
      <span class="status-new">🟠 New</span>
    <?php else: ?>
      <span class="status-checked">🟢 Checked</span>
    <?php endif; ?>
  </td>
  <td>
    <a href="view_registration.php?id=<?= $r['id'] ?>">View</a> |
    <a href="#" onclick="deleteRegistration(<?= $r['id'] ?>);return false;" style="color:red;">Delete</a>
  </td>
</tr>
<?php endwhile; endif; ?>
</tbody>
</table>

<!-- PAGINATION -->
<div class="pagination" style="margin-top:20px;">
<?php for($p=1;$p<=$totalPages;$p++): ?>
<a href="?<?= http_build_query(array_merge($_GET,['page'=>$p])) ?>"
   class="<?= $p==$page?'active':'' ?>">
   <?= $p ?>
</a>
<?php endfor; ?>
</div>

<script>
function deleteRegistration(id){
  Swal.fire({
    title:'Delete this registration?',
    text:'This cannot be undone',
    icon:'warning',
    showCancelButton:true,
    confirmButtonColor:'#d33',
    confirmButtonText:'Yes, delete'
  }).then(result=>{
    if(!result.isConfirmed) return;

    fetch('registrations.php',{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:new URLSearchParams({ajax:'delete',id:id})
    })
    .then(res=>res.json())
    .then(data=>{
      if(data.success){
        document.getElementById('row'+id)?.remove();
        Swal.fire('Deleted!',data.msg,'success');
      }else{
        Swal.fire('Error',data.msg,'error');
      }
    });
  });
}
</script>

<?php include 'partials/footer.php'; ?>