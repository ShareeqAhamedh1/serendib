<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

/* ===============================
   PAGINATION + SEARCH
================================ */
$limit  = 20;
$page   = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;
$search = trim($_GET['q'] ?? '');

$whereSql = '';
$params   = [];
$types    = '';

if ($search !== '') {
    $whereSql = "WHERE (t.first_name LIKE ? OR t.last_name LIKE ? OR t.teacher_code LIKE ? OR t.email LIKE ? OR s.subject_name LIKE ?)";
    $like = "%$search%";
    $params = [$like,$like,$like,$like,$like];
    $types  = "sssss";
}

/* ===============================
   COUNT
================================ */
if ($search === '') {
    $total = $conn->query("SELECT COUNT(*) total FROM teachers")->fetch_assoc()['total'];
} else {
    $stmt = $conn->prepare("
        SELECT COUNT(*) total
        FROM teachers t
        LEFT JOIN subjects s ON s.id=t.subject_id
        $whereSql
    ");
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];
}
$pages = max(1, ceil($total / $limit));

/* ===============================
   FETCH TEACHERS (WITH LEAVE)
================================ */
$sql = "
SELECT 
    t.*, 
    s.subject_name,
    tlq.id              AS leave_id,
    tlq.sick_leave,
    tlq.casual_leave,
    tlq.annual_leave,
    tlq.year
FROM teachers t
LEFT JOIN subjects s ON s.id = t.subject_id
LEFT JOIN teacher_leave_quota tlq 
       ON tlq.teacher_id = t.id
      AND tlq.year = YEAR(CURDATE())
";

if ($search !== '') {
    $sql .= " $whereSql ";
}

$sql .= " ORDER BY t.first_name LIMIT $limit OFFSET $offset";

$stmt = $conn->prepare($sql);
if ($search !== '') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();
?>

<style>
/* ---------- TABLE ---------- */
.table{
  width:100%; border-collapse:collapse; background:#fff;
  border-radius:8px; overflow:hidden;
  box-shadow:0 4px 12px rgba(0,0,0,.08)
}
.table th,.table td{padding:10px;border-bottom:1px solid #ddd}
.table th{background:#005c2e;color:#fff}
.table tr:nth-child(even){background:#f9f9f9}

/* ---------- FILTER ---------- */
.filter-bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:15px}
.filter-bar input{padding:6px}
.filter-bar button,.filter-bar a{
  background:#005c2e;color:#fff;
  padding:6px 10px;border-radius:4px;text-decoration:none
}
.reset-btn{background:#888}

/* ---------- BADGES ---------- */
.leave-badge{
  padding:4px 10px;border-radius:12px;
  font-size:12px;font-weight:600;display:inline-block
}
.leave-ok{background:#e6f9ec;color:#0f5132}
.leave-missing{background:#fff3cd;color:#664d03}

.action-leave{
  display:inline-block;margin-top:4px;
  padding:5px 8px;border-radius:6px;
  font-size:13px;font-weight:600;color:#fff;text-decoration:none
}
.action-assign{background:#198754}
.action-edit{background:#0d6efd}

/* ---------- MODAL ---------- */
.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1000}
.modal-content{
  background:#fff;max-width:420px;
  margin:10% auto;padding:20px;
  border-radius:12px
}
.modal-content label{display:block;margin-top:10px;font-weight:600}
.modal-content input{width:100%;padding:8px;margin-top:4px}
.modal-actions{display:flex;gap:10px;margin-top:15px}
.modal-actions button{
  flex:1;padding:10px;border:none;border-radius:8px;cursor:pointer
}
.modal-actions .save{background:#005c2e;color:#fff}
.modal-actions .cancel{background:#ccc}
</style>

<h2>👨‍🏫 Teacher List</h2>

<form method="get" class="filter-bar">
  <input name="q" value="<?= esc($search) ?>" placeholder="Search by name, subject, email or code">
  <button type="submit">🔍 Search</button>
  <a href="<?= BASE_URL ?>admin/add-teacher.php">➕ Add Teacher</a>
  <?php if($search !== ''): ?>
    <a href="<?= BASE_URL ?>admin/teachers.php" class="reset-btn">🔄 Reset</a>
  <?php endif; ?>
</form>

<table class="table">
<thead>
<tr>
  <th>No</th>
  <th>Teacher Code</th>
  <th>Name</th>
  <th>Email</th>
  <th>Phone</th>
  <th>Subject</th>
  <th>Join Date</th>
  <th>Status</th>
  <th>Actions</th>
</tr>
</thead>
<tbody>
<?php 
$no = $offset + 1;
while($t = $res->fetch_assoc()):
$statusColor = strtolower($t['status']) === 'active' ? 'green' : 'red';
?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= esc($t['teacher_code']) ?></td>
  <td>
    <a href="<?= BASE_URL ?>admin/teacher-details.php?id=<?= $t['id'] ?>" style="color:#007bff;">
      <?= esc($t['first_name'].' '.$t['last_name']) ?>
    </a>
  </td>
  <td><?= esc($t['email']) ?></td>
  <td><?= esc($t['phone']) ?></td>
  <td><?= esc($t['subject_name'] ?? '-') ?></td>
  <td><?= esc($t['join_date']) ?></td>
  <td style="color:<?= $statusColor ?>;font-weight:bold"><?= ucfirst($t['status']) ?></td>
  <td class="actions">
<?php if($t['leave_id']): ?>
  <span class="leave-badge leave-ok">Assigned</span><br>
  <a href="#"
     class="action-leave action-edit btn-assign-leave"
     data-json='<?= json_encode($t) ?>'>
     ✏️ Edit Leave
  </a>
<?php else: ?>
  <span class="leave-badge leave-missing">Not Assigned</span><br>
  <a href="#"
     class="action-leave action-assign btn-assign-leave"
     data-json='<?= json_encode($t) ?>'>
     🗓️ Assign Leave
  </a>
<?php endif; ?>

    <a href="<?= BASE_URL ?>admin/add-teacher.php?id=<?= $t['id'] ?>">✏️ Edit</a>
    <a href="<?= BASE_URL ?>backend/teachers.php?action=delete&id=<?= $t['id'] ?>" onclick="return confirm('Delete this teacher?')">🗑️</a>
    <a href="assign-teacher-classes.php?id=<?= $t['id'] ?>">📚</a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<?php if($pages > 1): ?>
<div class="pagination" style="margin-top:10px;">
<?php for($p=1;$p<=$pages;$p++): ?>
  <a href="?page=<?= $p ?>&q=<?= urlencode($search) ?>" class="<?= $p==$page?'active':'' ?>">
    <?= $p ?>
  </a>
<?php endfor; ?>
</div>
<?php endif; ?>


<!-- ================= MODAL ================= -->
<div id="leaveModal" class="modal">
<div class="modal-content">
<h3 id="modalTitle">🗓️ Assign Leave</h3>
<p id="teacherName"></p>

<form id="leaveForm">
<input type="hidden" name="teacher_id" id="teacherId">
<input type="hidden" name="year" value="<?= date('Y') ?>">

<label>Sick Leave</label>
<input type="number" name="SICK" id="sick">

<label>Casual Leave</label>
<input type="number" name="CASUAL" id="casual">

<label>Annual Leave</label>
<input type="number" name="ANNUAL" id="annual">

<div class="modal-actions">
  <button class="save">💾 Save</button>
  <button type="button" class="cancel" onclick="closeModal()">Cancel</button>
</div>
</form>
</div>
</div>

<?php include 'partials/footer.php'; ?>

<script>
const modal = document.getElementById('leaveModal');
const teacherName = document.getElementById('teacherName');
const modalTitle = document.getElementById('modalTitle');

document.querySelectorAll('.btn-assign-leave').forEach(btn=>{
  btn.onclick = e=>{
    e.preventDefault();
    const d = JSON.parse(btn.dataset.json);

    teacherName.textContent = d.first_name + ' ' + d.last_name;
    teacherId.value = d.id;

    sick.value   = d.sick_leave   ?? 0;
    casual.value = d.casual_leave ?? 0;
    annual.value = d.annual_leave ?? 0;

    modalTitle.textContent = d.leave_id ? '✏️ Edit Leave' : '🗓️ Assign Leave';
    modal.style.display='block';
  }
});

function closeModal(){ modal.style.display='none'; }

leaveForm.onsubmit = e=>{
  e.preventDefault();
  fetch('../backend/save-teacher-leave.php',{
    method:'POST', body:new FormData(e.target)
  })
  .then(r=>r.json())
  .then(()=>location.reload());
};
</script>
