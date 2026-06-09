<?php
include '../partials/portal_header.php';
require_once __DIR__ . '../../backend/conn.php';

$parent = $conn->query("
    SELECT id FROM parents WHERE user_id={$_SESSION['user_id']} LIMIT 1
")->fetch_assoc();

$student_id = (int)($_GET['student'] ?? 0);
$status = $_GET['status'] ?? '';

$where = "s.parent_id=?";
$params = [$parent['id']];
$types  = "i";

if ($student_id) {
    $where .= " AND s.id=?";
    $params[] = $student_id;
    $types .= "i";
}
if ($status) {
    $where .= " AND sf.status=?";
    $params[] = $status;
    $types .= "s";
}

$sql = "
SELECT s.first_name, s.last_name, sf.amount, sf.status, sf.due_date, ft.name
FROM student_fees sf
JOIN students s ON sf.student_id=s.id
JOIN fee_types ft ON sf.fee_type_id=ft.id
WHERE $where
";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();

// children
$children = $conn->query("
    SELECT id, first_name, last_name FROM students WHERE parent_id={$parent['id']}
");
?>

<style>
/* ---------- LAYOUT ---------- */
.fees-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 15px;
}

/* ---------- FILTER ---------- */
.filter-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.filter-form select,
.filter-form button,
.filter-form a {
    padding: 8px 10px;
    border-radius: 6px;
    font-size: 14px;
}

.filter-form button {
    background: #004080;
    color: white;
    border: none;
}

.filter-form a {
    text-decoration: none;
    background: #eee;
    color: #333;
}

/* ---------- TABLE ---------- */
.fees-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.fees-table th {
    background: #004080;
    color: white;
    padding: 12px;
    text-align: left;
}

.fees-table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

/* ---------- STATUS BADGES ---------- */
.badge {
    padding: 5px 10px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: bold;
}

.badge.Paid {
    background: #e6f9ec;
    color: #0f5132;
}

.badge.Pending {
    background: #fdecea;
    color: #842029;
}

.badge.Partial {
    background: #fff3cd;
    color: #664d03;
}

/* ---------- MOBILE CARDS ---------- */
.mobile-cards {
    display: none;
}

.fee-card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
}

.fee-card h4 {
    color: #004080;
    margin-bottom: 8px;
}

.fee-card p {
    margin: 5px 0;
}

/* ---------- TOTAL ---------- */
.total-due {
    margin-top: 15px;
    font-size: 18px;
    color: #b91c1c;
    font-weight: bold;
}

/* ---------- RESPONSIVE ---------- */
@media (max-width: 768px) {
    .fees-table {
        display: none;
    }
    .mobile-cards {
        display: block;
    }
}
</style>

<div class="fees-container">

<h2>💰 Fees</h2>

<form method="get" class="filter-form">
  <select name="student">
    <option value="">All Children</option>
    <?php while($c=$children->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>" <?= $student_id==$c['id']?'selected':'' ?>>
        <?= esc($c['first_name'].' '.$c['last_name']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <select name="status">
    <option value="">All Status</option>
    <option value="Pending" <?= $status=='Pending'?'selected':'' ?>>Pending</option>
    <option value="Partial" <?= $status=='Partial'?'selected':'' ?>>Partial</option>
    <option value="Paid" <?= $status=='Paid'?'selected':'' ?>>Paid</option>
  </select>

  <button>Filter</button>
  <a href="fees.php">Reset</a>
</form>

<!-- ================= DESKTOP TABLE ================= -->
<table class="fees-table">
<tr>
  <th>Student</th>
  <th>Fee</th>
  <th>Amount</th>
  <th>Status</th>
  <th>Due</th>
</tr>

<?php
$total_due = 0;
$res->data_seek(0);

while($r = $res->fetch_assoc()):
if($r['status'] !== 'Paid') $total_due += $r['amount'];
?>
<tr>
  <td><?= esc($r['first_name'].' '.$r['last_name']) ?></td>
  <td><?= esc($r['name']) ?></td>
  <td>LKR <?= number_format($r['amount'],2) ?></td>
  <td><span class="badge <?= esc($r['status']) ?>"><?= esc($r['status']) ?></span></td>
  <td><?= esc($r['due_date']) ?></td>
</tr>
<?php endwhile; ?>
</table>

<!-- ================= MOBILE CARDS ================= -->
<div class="mobile-cards">
<?php
$res->data_seek(0);

while($r = $res->fetch_assoc()):
?>
<div class="fee-card">
    <h4><?= esc($r['first_name'].' '.$r['last_name']) ?></h4>
    <p>💳 Fee: <?= esc($r['name']) ?></p>
    <p>💰 Amount: LKR <?= number_format($r['amount'],2) ?></p>
    <p>Status:
        <span class="badge <?= esc($r['status']) ?>">
            <?= esc($r['status']) ?>
        </span>
    </p>
    <p>📅 Due: <?= esc($r['due_date']) ?></p>
</div>
<?php endwhile; ?>
</div>

<div class="total-due">
    Total Outstanding: LKR <?= number_format($total_due,2) ?>
</div>

</div>

<?php include '../partials/portal_footer.php'; ?>
