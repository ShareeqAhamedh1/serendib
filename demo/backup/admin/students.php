<?php 
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Pagination + search + status filter
$limit = 20;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$search = trim($_GET['q'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');

$where = "1=1";
$params = [];
$types  = "";

// --- Search Filter ---
if ($search !== '') {
    $where .= " AND (s.first_name LIKE ? OR s.last_name LIKE ? OR s.admission_no LIKE ?)";
    $like = "%{$search}%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types .= "sss";
}

// --- Status Filter ---
if ($statusFilter !== '') {
    $where .= " AND s.status = ?";
    $params[] = $statusFilter;
    $types .= "s";
}

// --- Count total ---
if (empty($params)) {
    $total = $conn->query("SELECT COUNT(*) AS total FROM students s")->fetch_assoc()['total'];
} else {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM students s WHERE $where");
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];
}

$pages = max(1, ceil($total / $limit));

// --- Fetch main data ---
$sql = "
    SELECT s.*, c.class_name, sec.section_name 
    FROM students s
    LEFT JOIN classes c ON s.class_id = c.id
    LEFT JOIN sections sec ON s.section_id = sec.id
    WHERE $where
    ORDER BY s.id DESC
    LIMIT $limit OFFSET $offset
";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();
?>

<style>
/* ---------- TABLE STYLING ---------- */
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
}
.table th {
  background: #004080;
  color: white;
}
.badge {
  padding: 4px 8px;
  border-radius: 5px;
  font-size: 13px;
}
.badge-active { background:#d4edda; color:#155724; }
.badge-inactive { background:#ffeeba; color:#856404; }
.badge-left { background:#f8d7da; color:#721c24; }

.filter-bar {
  margin-bottom: 15px;
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}
.filter-bar input, .filter-bar select {
  padding: 6px 8px;
}
.filter-bar button, .filter-bar a {
  padding: 6px 10px;
  background: #004080;
  color: white;
  border-radius: 4px;
  text-decoration: none;
}
.filter-bar .reset-btn { background: #777; }
</style>

<h2>👨‍🎓 Student List</h2>

<!-- ✅ FILTER BAR -->
<form method="get" class="filter-bar">

  <input name="q" value="<?= esc($search) ?>" placeholder="Search by name or admission no">

  <select name="status">
    <option value="">All Status</option>
    <option value="active"   <?= $statusFilter=='active'?'selected':'' ?>>Active</option>
    <option value="inactive" <?= $statusFilter=='inactive'?'selected':'' ?>>Inactive</option>
    <option value="left"     <?= $statusFilter=='left'?'selected':'' ?>>Left School</option>
  </select>

  <button type="submit">🔍 Apply</button>

  <?php if($search !== '' || $statusFilter !== ''): ?>
    <a href="<?= BASE_URL ?>admin/students.php" class="reset-btn">🔄 Reset</a>
  <?php endif; ?>

  <a href="<?= BASE_URL ?>admin/add-student.php">➕ Add Student</a>

</form>

<!-- ✅ TABLE -->
<table class="table">
  <thead>
    <tr>
      <th>No</th>
      <th>Admn No</th>
      <th>Photo</th>
      <th>Name</th>
      <th>Gender</th>
      <th>Medium</th>
      <th>Class</th>
      <th>Section</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    <?php 
    $no = $offset + 1;
    while ($row = $res->fetch_assoc()):
      $student_id = $row['id'];

      $badgeClass = match($row['status']) {
        'active' => 'badge-active',
        'inactive' => 'badge-inactive',
        'left' => 'badge-left',
        default => 'badge-left'
      };
    ?>
      <tr>
        <td><?= $no++ ?></td>

        <td>
          <a href="<?= BASE_URL ?>admin/student-details.php?id=<?= $student_id ?>">
            <?= esc($row['admission_no']) ?>
          </a>
        </td>

        <td>
          <?php if($row['photo']): ?>
            <img src="<?= BASE_URL ?>uploads/<?= esc($row['photo']) ?>" width="50">
          <?php else: ?>
            <span style="color:#aaa;">No Photo</span>
          <?php endif; ?>
        </td>

        <td><?= esc($row['first_name'].' '.$row['last_name']) ?></td>
        <td><?= ucfirst(esc($row['gender'])) ?></td>
        <td><?= esc($row['medium']) ?></td>
        <td><?= esc($row['class_name'] ?? '-') ?></td>
        <td><?= esc($row['section_name'] ?? '-') ?></td>

        <td>
          <span class="badge <?= $badgeClass ?>">
            <?= esc($row['status']) ?>
          </span>
        </td>

        <td>
          <a href="<?= BASE_URL ?>admin/edit-student.php?id=<?= $student_id ?>">✏️ Edit</a>
          <a href="<?= BASE_URL ?>backend/students.php?action=delete&id=<?= $student_id ?>" 
             onclick="return confirm('Delete this student?')">🗑️ Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- ✅ PAGINATION -->
<?php if($pages > 1): ?>
  <div class="pagination" style="margin-top:10px;">
    <?php for($p = 1; $p <= $pages; $p++): ?>
      <a 
        href="?page=<?= $p ?>&q=<?= urlencode($search) ?>&status=<?= urlencode($statusFilter) ?>" 
        class="<?= $p==$page?'active':'' ?>">
        <?= $p ?>
      </a>
    <?php endfor; ?>
  </div>
<?php endif; ?>

<?php include 'partials/footer.php'; ?>
