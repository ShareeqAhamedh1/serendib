<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

date_default_timezone_set('Asia/Colombo');

/* ===============================
   LOGGED-IN TEACHER
================================ */
$user_id = $_SESSION['user_id'];

$t = $conn->query("
    SELECT id, first_name, last_name
    FROM teachers
    WHERE user_id = $user_id
    LIMIT 1
")->fetch_assoc();

if (!$t) {
    echo "<p style='color:red'>Teacher not found</p>";
    include '../partials/portal_footer.php';
    exit;
}

$teacher_id = (int)$t['id'];
$year = date('Y');

/* ===============================
   FETCH LEAVE QUOTA
================================ */
$q = $conn->query("
    SELECT *
    FROM teacher_leave_quota
    WHERE teacher_id = $teacher_id
      AND year = $year
")->fetch_assoc();

if (!$q) {
    echo "<p style='color:red'>Leave quota not assigned yet. Please contact admin.</p>";
    include '../partials/portal_footer.php';
    exit;
}

/* ===============================
   USED LEAVES
================================ */
$used = [];
$res = $conn->query("
    SELECT leave_type, SUM(days) total
    FROM teacher_leave_requests
    WHERE teacher_id=$teacher_id
      AND status='Approved'
      AND YEAR(start_date)=$year
    GROUP BY leave_type
");

while ($r = $res->fetch_assoc()) {
    $used[$r['leave_type']] = (int)$r['total'];
}

function remaining($total, $type, $used) {
    return max(0, $total - ($used[$type] ?? 0));
}
?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.leave-container {
    max-width: 900px;
    margin: auto;
    padding: 15px;
}

/* ---------- QUOTA ---------- */
.quota-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
    gap: 15px;
    margin-bottom: 25px;
}
.quota-card {
    background: white;
    padding: 18px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
}
.quota-card h3 { margin-bottom: 10px; }

/* ---------- FORM ---------- */
.leave-form {
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
}
.leave-form label {
    font-weight: 600;
    display: block;
    margin-top: 12px;
}
.leave-form input,
.leave-form select,
.leave-form textarea {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border-radius: 10px;
    border: 1px solid #ccc;
}
.leave-form button {
    margin-top: 18px;
    padding: 14px;
    width: 100%;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
}

/* ---------- REQUEST LIST ---------- */
.requests {
    margin-top: 30px;
}
.request-card {
    background: white;
    padding: 16px;
    border-radius: 14px;
    box-shadow: 0 6px 16px rgba(0,0,0,.08);
    margin-bottom: 14px;
}
.badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}
.badge.pending { background:#fff3cd;color:#664d03; }
.badge.approved{ background:#e6f9ec;color:#0f5132; }
.badge.rejected{ background:#fdecea;color:#842029; }
</style>

<div class="leave-container">

<h2>🗓️ Leave Management</h2>
<p style="color:#555;">Hello <?= esc($t['first_name']) ?>, manage your leave requests here.</p>

<!-- ================= QUOTA ================= -->
<div class="quota-grid">
  <div class="quota-card">
    <h3>🤒 Sick Leave</h3>
    <p>Total: <?= $q['sick_leave'] ?></p>
    <p>Used: <?= $used['SICK'] ?? 0 ?></p>
    <p><b>Remaining: <?= remaining($q['sick_leave'],'SICK',$used) ?></b></p>
  </div>

  <div class="quota-card">
    <h3>🧳 Casual Leave</h3>
    <p>Total: <?= $q['casual_leave'] ?></p>
    <p>Used: <?= $used['CASUAL'] ?? 0 ?></p>
    <p><b>Remaining: <?= remaining($q['casual_leave'],'CASUAL',$used) ?></b></p>
  </div>

  <div class="quota-card">
    <h3>🏖️ Annual Leave</h3>
    <p>Total: <?= $q['annual_leave'] ?></p>
    <p>Used: <?= $used['ANNUAL'] ?? 0 ?></p>
    <p><b>Remaining: <?= remaining($q['annual_leave'],'ANNUAL',$used) ?></b></p>
  </div>
</div>

<!-- ================= REQUEST FORM ================= -->
<div class="leave-form">
<h3>➕ Request Leave</h3>

<form id="leaveRequestForm">
<input type="hidden" name="teacher_id" value="<?= $teacher_id ?>">

<label>Leave Type</label>
<select name="leave_type" required>
  <option value="">Select</option>
  <option value="SICK">Sick Leave</option>
  <option value="CASUAL">Casual Leave</option>
  <option value="ANNUAL">Annual Leave</option>
</select>

<label>From</label>
<input type="date" name="start_date" required>

<label>To</label>
<input type="date" name="end_date" required>

<label>Reason</label>
<textarea name="reason" rows="3" required></textarea>

<button type="submit">📤 Submit Request</button>
</form>
</div>

<!-- ================= MY REQUESTS ================= -->
<div class="requests">
<h3>📄 My Leave Requests</h3>

<?php
/* ===============================
   PAGINATION (REQUESTS ONLY)
================================ */
$perPage = 5;
$reqPage = max(1, (int)($_GET['page'] ?? 1));
$offset = ($reqPage - 1) * $perPage;


$totalReq = $conn->query("
    SELECT COUNT(*) total
    FROM teacher_leave_requests
    WHERE teacher_id = $teacher_id
")->fetch_assoc()['total'];

$totalPages = max(1, ceil($totalReq / $perPage));

$rq = $conn->query("
    SELECT *
    FROM teacher_leave_requests
    WHERE teacher_id = $teacher_id
    ORDER BY created_at DESC
    LIMIT $perPage OFFSET $offset
");


if ($rq->num_rows === 0):
?>
<p style="color:#777;">No leave requests yet.</p>
<?php else: while($r=$rq->fetch_assoc()): ?>
<div class="request-card">
<b><?= esc($r['leave_type']) ?></b>
(<?= $r['start_date'] ?> → <?= $r['end_date'] ?>)<br>
Days: <?= $r['days'] ?><br>
Reason: <?= esc($r['reason']) ?><br>
Status:
<span class="badge <?= strtolower($r['status']) ?>">
  <?= $r['status'] ?>
</span>

<?php if ($r['status'] === 'Pending'): ?>
<br>
<span style="color:#dc3545;font-weight:600;cursor:pointer"
      onclick="deleteRequest(<?= $r['id'] ?>)">
    🗑 Delete
</span>
<?php endif; ?>
</div>

<?php endwhile;

endif; ?>
<?php if ($totalPages > 1): ?>
<div style="margin-top:15px">
<?php for ($p = 1; $p <= $totalPages; $p++): ?>
  <a href="?page=<?= $p ?>"
     style="padding:6px 10px;
            border:1px solid #ccc;
            border-radius:6px;
            margin-right:4px;
            text-decoration:none;
            <?= $p == $reqPage ? 'background:#007bff;color:white;' : '' ?>
">
     <?= $p ?>
  </a>
<?php endfor; ?>
</div>
<?php endif; ?>

</div>

</div>

<?php include '../partials/portal_footer.php'; ?>

<script>
document.getElementById('leaveRequestForm').addEventListener('submit', function(e){
    e.preventDefault();

    fetch('backend/teacher-leave-request.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Leave Requested',
                text: data.message,
                confirmButtonColor: '#005c2e'
            }).then(() => location.reload());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: data.message
            });
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.'
        });
    });
});
</script>
<script>
function deleteRequest(id){
    Swal.fire({
        icon:'warning',
        title:'Delete this request?',
        text:'Only pending requests can be deleted.',
        showCancelButton:true,
        confirmButtonColor:'#dc3545'
    }).then(result=>{
        if(result.isConfirmed){
            fetch('backend/delete-leave-request.php',{
                method:'POST',
                body:new URLSearchParams({ request_id:id })
            })
            .then(res=>res.json())
            .then(data=>{
                if(data.status==='success'){
                    Swal.fire('Deleted',data.message,'success')
                        .then(()=>location.reload());
                }else{
                    Swal.fire('Error',data.message,'error');
                }
            });
        }
    });
}
</script>

