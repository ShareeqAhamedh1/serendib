<?php
include 'partials/header.php';
require_once __DIR__.'/../backend/conn.php';
require_once __DIR__.'/../backend/helpers.php';

date_default_timezone_set('Asia/Colombo');

/* ===============================
   FILTERS
================================ */
$q       = trim($_GET['q'] ?? '');
$status  = $_GET['status'] ?? '';
$type    = $_GET['type'] ?? '';

$where = "1=1";
$params = [];
$types  = "";

/* Search by teacher name or code */
if ($q !== '') {
    $where .= " AND (t.first_name LIKE ? OR t.last_name LIKE ? OR t.teacher_code LIKE ?)";
    $like = "%$q%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types   .= "sss";
}

/* Status filter */
if ($status !== '') {
    $where .= " AND r.status = ?";
    $params[] = $status;
    $types   .= "s";
}

/* Leave type filter */
if ($type !== '') {
    $where .= " AND r.leave_type = ?";
    $params[] = $type;
    $types   .= "s";
}

/* ===============================
   PAGINATION
================================ */
$limit = 10;
$page  = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

/* ===============================
   COUNT
================================ */
$countSql = "
    SELECT COUNT(*) total
    FROM teacher_leave_requests r
    JOIN teachers t ON t.id = r.teacher_id
    WHERE $where
";
$stmt = $conn->prepare($countSql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];
$pages = max(1, ceil($total / $limit));

/* ===============================
   FETCH DATA
================================ */
$sql = "
    SELECT 
        r.*,
        t.first_name, t.last_name, t.teacher_code,
        q.sick_leave, q.casual_leave, q.annual_leave
    FROM teacher_leave_requests r
    JOIN teachers t ON t.id = r.teacher_id
    JOIN teacher_leave_quota q 
        ON q.teacher_id = r.teacher_id
       AND q.year = YEAR(CURDATE())
    WHERE $where
    ORDER BY r.created_at DESC
    LIMIT $limit OFFSET $offset
";

$stmt = $conn->prepare($sql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$requests = $stmt->get_result();
?>

<style>
.container{max-width:1300px;margin:auto;padding:15px}
.filter-box{
  background:#fff;padding:15px;border-radius:12px;
  box-shadow:0 4px 14px rgba(0,0,0,.08);
  margin-bottom:20px
}
.filter-box form{
  display:flex;gap:10px;flex-wrap:wrap
}
.filter-box input,
.filter-box select{
  padding:8px 10px;border-radius:8px;border:1px solid #ccc
}
.filter-box button,
.filter-box a{
  padding:8px 14px;border-radius:8px;
  background:#005c2e;color:#fff;
  border:none;text-decoration:none;font-weight:600
}
.filter-box a{background:#6c757d}

.table{
  width:100%;
  border-collapse:collapse;
  background:#fff;
  box-shadow:0 6px 18px rgba(0,0,0,.08);
  border-radius:12px;
  overflow:hidden
}
.table th{
  background:#004080;color:#fff;
  padding:12px;text-align:left
}
.table td{
  padding:12px;border-bottom:1px solid #eee;
  vertical-align:top
}

.badge{
  padding:4px 10px;border-radius:12px;
  font-size:12px;font-weight:600
}
.pending{background:#fff3cd;color:#664d03}
.approved{background:#e6f9ec;color:#0f5132}
.rejected{background:#fdecea;color:#842029}

.btn{
  padding:6px 12px;border-radius:8px;
  border:none;cursor:pointer;font-weight:600
}
.approve{background:#198754;color:#fff}
.reject{background:#dc3545;color:#fff}

.pagination a{
  padding:6px 10px;border-radius:6px;
  border:1px solid #ccc;
  text-decoration:none;margin-right:4px
}
.pagination a.active{
  background:#007bff;color:#fff;border-color:#007bff
}

@media(max-width:900px){
  .table{font-size:14px}
}
</style>

<div class="container">

<h2>📩 Leave Approval Dashboard</h2>
<p style="color:#555">Approve or reject teacher leave requests.</p>

<!-- ================= FILTERS ================= -->
<div class="filter-box">
<form method="get">
  <input name="q" placeholder="Teacher name / code" value="<?= esc($q) ?>">

  <select name="status">
    <option value="">All Status</option>
    <option <?= $status=='Pending'?'selected':'' ?>>Pending</option>
    <option <?= $status=='Approved'?'selected':'' ?>>Approved</option>
    <option <?= $status=='Rejected'?'selected':'' ?>>Rejected</option>
  </select>

  <select name="type">
    <option value="">All Types</option>
    <option <?= $type=='SICK'?'selected':'' ?> value="SICK">Sick</option>
    <option <?= $type=='CASUAL'?'selected':'' ?> value="CASUAL">Casual</option>
    <option <?= $type=='ANNUAL'?'selected':'' ?> value="ANNUAL">Annual</option>
  </select>

  <button>🔍 Filter</button>
  <a href="leave-requests.php">🔄 Reset</a>
</form>
</div>

<!-- ================= TABLE ================= -->
<table class="table">
<thead>
<tr>
  <th>Teacher</th>
  <th>Leave</th>
  <th>Dates</th>
  <th>Quota</th>
  <th>Reason</th>
  <th>Status</th>
  <th>Action</th>
</tr>
</thead>
<tbody>

<?php if($requests->num_rows===0): ?>
<tr><td colspan="7" style="text-align:center;color:#777">No records</td></tr>
<?php endif; ?>

<?php while($r=$requests->fetch_assoc()): ?>
<?php
$used = $conn->query("
  SELECT SUM(days) total
  FROM teacher_leave_requests
  WHERE teacher_id={$r['teacher_id']}
    AND leave_type='{$r['leave_type']}'
    AND status='Approved'
    AND YEAR(start_date)=YEAR(CURDATE())
")->fetch_assoc()['total'] ?? 0;


$totalQuota = match($r['leave_type']){
  'SICK'=>$r['sick_leave'],
  'CASUAL'=>$r['casual_leave'],
  'ANNUAL'=>$r['annual_leave']
};
$remaining = max(0, $totalQuota - $used);
?>

<tr>
<td>
<b><?= esc($r['first_name'].' '.$r['last_name']) ?></b><br>
<small><?= esc($r['teacher_code']) ?></small>
</td>

<td><?= esc($r['leave_type']) ?></td>

<td>
<?= $r['start_date'] ?> → <?= $r['end_date'] ?><br>
Days: <?= $r['days'] ?>
</td>

<td>
Total: <?= $totalQuota ?><br>
Used: <?= $used ?><br>
<b>Remain: <?= $remaining ?></b>
</td>

<td><?= esc($r['reason']) ?></td>

<td>
<span class="badge <?= strtolower($r['status']) ?>">
<?= $r['status'] ?>
</span>
</td>

<td>
<?php if($r['status']==='Pending'): ?>

  <?php if($remaining >= $r['days']): ?>
    <button class="btn approve"
      onclick="updateStatus(<?= $r['id'] ?>,'Approved')">
      Approve
    </button>
  <?php else: ?>
    <span style="color:red;font-weight:600">
      ❌ Insufficient Balance
    </span>
  <?php endif; ?>

  <br><br>

  <button class="btn reject"
    onclick="updateStatus(<?= $r['id'] ?>,'Rejected')">
    Reject
  </button>

<?php endif; ?>

</td>
</tr>

<?php endwhile; ?>
</tbody>
</table>

<!-- ================= PAGINATION ================= -->
<?php if($pages>1): ?>
<div class="pagination" style="margin-top:15px">
<?php for($p=1;$p<=$pages;$p++): ?>
<a class="<?= $p==$page?'active':'' ?>"
 href="?page=<?= $p ?>&q=<?= urlencode($q) ?>&status=<?= urlencode($status) ?>&type=<?= urlencode($type) ?>">
<?= $p ?>
</a>
<?php endfor; ?>
</div>
<?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function updateStatus(id,status){
  Swal.fire({
    title: status+' this request?',
    showCancelButton:true,
    confirmButtonColor: status==='Approved'?'#198754':'#dc3545'
  }).then(r=>{
    if(r.isConfirmed){
      fetch('../backend/update-leave-status.php',{
        method:'POST',
        body:new URLSearchParams({id,status})
      })
      .then(r=>r.json())
      .then(res=>{
        if(res.status==='success'){
          Swal.fire('Done',res.message,'success')
            .then(()=>location.reload());
        }else{
          Swal.fire('Error',res.message,'error');
        }
      });
    }
  });
}
</script>

<?php include 'partials/footer.php'; ?>
