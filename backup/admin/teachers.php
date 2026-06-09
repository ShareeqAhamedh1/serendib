<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Pagination + search
$limit = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = trim($_GET['q'] ?? '');

$where = "1=1";
$params = [];

if ($search !== '') {
  $where .= " AND (t.first_name LIKE ? OR t.last_name LIKE ? OR t.teacher_code LIKE ? OR t.email LIKE ? OR s.subject_name LIKE ?)";
  $like = "%{$search}%";
  $params = [$like, $like, $like, $like, $like];
}

// Count total
if ($search === '') {
  $totalRes = $conn->query("SELECT COUNT(*) AS total FROM teachers t");
  $total = $totalRes->fetch_assoc()['total'];
} else {
  $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM teachers t LEFT JOIN subjects s ON t.subject_id = s.id WHERE $where");
  $stmt->bind_param("sssss", ...$params);
  $stmt->execute();
  $total = $stmt->get_result()->fetch_assoc()['total'];
}
$pages = max(1, ceil($total / $limit));

// Fetch teachers
if ($search === '') {
  $res = $conn->query("
    SELECT t.*, s.subject_name 
    FROM teachers t 
    LEFT JOIN subjects s ON t.subject_id = s.id 
    ORDER BY t.first_name 
    LIMIT $limit OFFSET $offset
  ");
} else {
  $stmt = $conn->prepare("
    SELECT t.*, s.subject_name
    FROM teachers t 
    LEFT JOIN subjects s ON t.subject_id = s.id 
    WHERE (t.first_name LIKE ? OR t.last_name LIKE ? OR t.teacher_code LIKE ? OR t.email LIKE ? OR s.subject_name LIKE ?)
    ORDER BY t.first_name 
    LIMIT ? OFFSET ?
  ");
  $stmt->bind_param("sssssii", $like, $like, $like, $like, $like, $limit, $offset);
  $stmt->execute();
  $res = $stmt->get_result();
}

?>

<style>
.table {
  border-collapse: collapse;
  width: 100%;
  background: white;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  border-radius: 8px;
  overflow: hidden;
}
.table th, .table td {
  border-bottom: 1px solid #ddd;
  padding: 10px 8px;
  text-align: left;
}
.table th {
  background: #005c2e;
  color: white;
}
.table tr:nth-child(even) {
  background: #f9f9f9;
}
.actions a {
  text-decoration: none;
  margin-right: 6px;
  color: #005c2e;
}
.actions a:hover {
  text-decoration: underline;
}
.pagination a {
  text-decoration: none;
  margin: 3px;
  padding: 4px 8px;
  border-radius: 4px;
  border: 1px solid #005c2e;
  color: #005c2e;
}
.pagination a.active {
  background: #005c2e;
  color: white;
  font-weight: bold;
}
.filter-bar {
  margin-bottom: 15px;
  display: flex;
  gap: 8px;
  align-items: center;
}
.filter-bar input {
  padding: 6px 8px;
}
.filter-bar button, .filter-bar a {
  padding: 6px 10px;
  background: #005c2e;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  text-decoration: none;
}
.filter-bar button:hover, .filter-bar a:hover {
  background: #004620;
}
.reset-btn {
  background: #888;
}
.reset-btn:hover {
  background: #666;
}
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
        <a href="<?= BASE_URL ?>admin/teacher-details.php?id=<?= $t['id'] ?>" style="color:#007bff; text-decoration:none;">
          <?= esc($t['first_name'].' '.$t['last_name']) ?>
        </a>
      </td>
      <td><?= esc($t['email']) ?></td>
      <td><?= esc($t['phone']) ?></td>
      <td><?= esc($t['subject_name'] ?? '-') ?></td>
      <td><?= esc($t['join_date']) ?></td>
      <td style="color:<?= $statusColor ?>; font-weight:bold;"><?= ucfirst($t['status']) ?></td>
      <td class="actions">
        <a href="<?= BASE_URL ?>admin/add-teacher.php?id=<?= $t['id'] ?>">✏️ Edit</a>
        <a href="<?= BASE_URL ?>backend/teachers.php?action=delete&id=<?= $t['id'] ?>" onclick="return confirm('Delete this teacher?')">🗑️ Delete</a>
        <a href="assign-teacher-classes.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-info">
    📚 Assign Classes
</a>

      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php if($pages > 1): ?>
  <div class="pagination" style="margin-top:10px;">
    <?php for($p = 1; $p <= $pages; $p++): ?>
      <a href="?page=<?= $p ?>&q=<?= urlencode($search) ?>" class="<?= $p==$page?'active':'' ?>"><?= $p ?></a>
    <?php endfor; ?>
  </div>
<?php endif; ?>

<?php include 'partials/footer.php'; ?>
