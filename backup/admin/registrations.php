<?php
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';
requireLogin();

// Only admin allowed
if (!isset($_SESSION['user_id']) || ($_SESSION['role_name'] ?? '') !== 'admin') {
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}

include 'partials/header.php';


// Alert message (one-time)
$msg = $_GET['msg'] ?? '';
$ok  = $_GET['ok'] ?? '';

// -----------------------------
//  FILTERS
// -----------------------------
$gradeFilter  = $_GET['grade'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$fromDate     = $_GET['from'] ?? '';
$toDate       = $_GET['to'] ?? '';

$where = [];
$params = [];
$types = "";

// Grade filter
if ($gradeFilter !== '') {
    $where[] = "joining_grade = ?";
    $params[] = $gradeFilter;
    $types .= "i";
}

// Status filter
if ($statusFilter !== '') {
    $where[] = "status = ?";
    $params[] = $statusFilter;
    $types .= "s";
}

// Date range filter
if ($fromDate && $toDate) {
    $where[] = "DATE(created_at) BETWEEN ? AND ?";
    $params[] = $fromDate;
    $params[] = $toDate;
    $types .= "ss";
}

// Build SQL
$sql = "SELECT * FROM registrations";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();
?>

<h2>📝 New Student Registrations</h2>



<!-- ===========================
      FILTERS BOX
=========================== -->
<form method="get" style="background:#f9f9f9;padding:15px;border-radius:10px;margin-bottom:20px;">
  <div style="display:flex;gap:15px;flex-wrap:wrap;">
    
    <!-- Grade -->
    <div>
      <label><b>Joining Grade:</b></label><br>
      <select name="grade">
        <option value="">All</option>
        <?php for($g=6; $g<=11; $g++): ?>
          <option value="<?= $g ?>" <?= ($gradeFilter==$g)?'selected':'' ?>>Grade <?= $g ?></option>
        <?php endfor; ?>
      </select>
    </div>

    <!-- Status -->
    <div>
      <label><b>Status:</b></label><br>
      <select name="status">
        <option value="">All</option>
        <option value="new"     <?= ($statusFilter=='new')?'selected':'' ?>>New</option>
        <option value="checked" <?= ($statusFilter=='checked')?'selected':'' ?>>Checked</option>
      </select>
    </div>

    <!-- Date filter -->
    <div>
      <label><b>From:</b></label><br>
      <input type="date" name="from" value="<?= esc($fromDate) ?>">
    </div>

    <div>
      <label><b>To:</b></label><br>
      <input type="date" name="to" value="<?= esc($toDate) ?>">
    </div>

    <div style="align-self:end;">
      <button type="submit">🔍 Filter</button>
      <a href="registrations.php" style="margin-left:10px;">Reset</a>
    </div>
  </div>
</form>

<!-- ===========================
      TABLE
=========================== -->
<table border="1" cellpadding="8" cellspacing="0" 
       style="width:100%; border-collapse:collapse; background:#fff;">
  <thead style="background:#007bff;color:white;">
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Joining Grade</th>
      <th>Parent</th>
      <th>Contact</th>
      <th>Submitted</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php if ($res->num_rows == 0): ?>
      <tr>
        <td colspan="8" align="center" style="color:gray;">No registrations found.</td>
      </tr>
    <?php else: $i=1; ?>
      <?php while($r = $res->fetch_assoc()): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= esc($r['full_name']) ?></td>
          <td><?= "Grade " . (int)$r['joining_grade'] ?></td>
          <td><?= esc($r['parent_name'] ?: '-') ?></td>
          <td><?= esc($r['parent_phone'] ?: $r['parent_email'] ?: '-') ?></td>
          <td><?= esc($r['created_at']) ?></td>

          <td>
            <?php if ($r['status']=='new'): ?>
              <strong style="color:#d97706;">🟠 New</strong>
            <?php else: ?>
              <strong style="color:green;">🟢 Checked</strong>
            <?php endif; ?>
          </td>

          <td>
            <a class="btn-sm" href="view_registration.php?id=<?= $r['id'] ?>">View</a>

            <?php if ($r['status']=='new'): ?>
              <a class="btn-sm" 
                 href="../backend/registration_action.php?action=check&id=<?= $r['id'] ?>"
                 onclick="return confirm('Mark as checked?')">✔ Mark Checked</a>
            <?php else: ?>
              <a class="btn-sm"
                 href="../backend/registration_action.php?action=uncheck&id=<?= $r['id'] ?>"
                 onclick="return confirm('Mark as new?')">↺ Uncheck</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php endif; ?>
  </tbody>
</table>

<!-- AUTO-HIDE MESSAGE -->
<script>
setTimeout(()=>{
  const el = document.getElementById('adminMsg');
  if(el) el.style.display='none';
}, 2500);
</script>

<?php if ($msg): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        title: "<?= ($ok=='1') ? 'Success!' : 'Error!' ?>",
        text: "<?= htmlspecialchars($msg) ?>",
        icon: "<?= ($ok=='1') ? 'success' : 'error' ?>",
        confirmButtonColor: "#3085d6"
    });

    // Remove msg and ok from URL after showing alert
    const url = new URL(window.location.href);
    url.searchParams.delete('msg');
    url.searchParams.delete('ok');
    window.history.replaceState({}, document.title, url.pathname + (url.searchParams.toString() ? '?' + url.searchParams.toString() : ''));
});
</script>
<?php endif; ?>

<?php include 'partials/footer.php'; ?>
