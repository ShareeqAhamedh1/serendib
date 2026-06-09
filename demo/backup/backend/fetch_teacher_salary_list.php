<?php
require 'conn.php';
require 'helpers.php';

$search = trim($_POST['search'] ?? '');
$month  = trim($_POST['month'] ?? '');
$page   = max(1, (int)($_POST['page'] ?? 1));
$limit  = 10;
$offset = ($page - 1) * $limit;

// ✅ Use consistent month format (Y-m) for comparison & database storage
$monthYear = $month ? date('Y-m', strtotime($month)) : date('Y-m');

$where = "1=1";
$params = [];

if ($search !== '') {
  $where .= " AND (t.first_name LIKE ? OR t.last_name LIKE ? OR t.teacher_code LIKE ? OR s.subject_name LIKE ?)";
  $like = "%$search%";
  $params = [$like, $like, $like, $like];
}

// 🔢 Count total teachers
$qCount = "
  SELECT COUNT(*) AS total
  FROM teachers t
  LEFT JOIN subjects s ON t.subject_id = s.id
  WHERE $where
";
$stmt = $conn->prepare($qCount);
if ($search !== '') $stmt->bind_param("ssss", ...$params);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
$totalPages = max(1, ceil($total / $limit));

// 📋 Fetch paginated teachers
$q = "
  SELECT t.id, t.teacher_code, t.first_name, t.last_name, t.email, t.phone, 
         s.subject_name, t.gender, t.join_date, t.status
  FROM teachers t
  LEFT JOIN subjects s ON t.subject_id = s.id
  WHERE $where
  ORDER BY t.first_name
  LIMIT $limit OFFSET $offset
";
$stmt = $conn->prepare($q);
if ($search !== '') $stmt->bind_param("ssss", ...$params);
$stmt->execute();
$teachers = $stmt->get_result();

if ($teachers->num_rows === 0) {
  echo "<p style='color:gray;'>No teachers found.</p><!--PAGE_SPLIT--><!--PAGE_SPLIT-->";
  exit;
}

// 🧾 Build the table
echo "<table border='1' cellpadding='8' cellspacing='0' style='width:100%; border-collapse:collapse; background:#fff;'>
<thead style='background:#007bff; color:white;'>
  <tr>
    <th>#</th>
    <th>Teacher</th>
    <th>Gender</th>
    <th>Subject</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Join Date</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
</thead>
<tbody>";

$i = $offset + 1;
while ($t = $teachers->fetch_assoc()):
  $teacher_id = $t['id'];

  // ✅ Use consistent month format (Y-m)
  $check = $conn->prepare("SELECT id FROM teacher_payments WHERE teacher_id=? AND month_year=?");
  $check->bind_param("is", $teacher_id, $monthYear);
  $check->execute();
  $paid = $check->get_result()->num_rows > 0;

  $status = $paid ? 'Paid' : 'Pending';
  $color  = $paid ? 'green' : 'red';

  echo "<tr>
    <td>{$i}</td>
    <td>".esc($t['first_name'].' '.$t['last_name'])."<br><small>".esc($t['teacher_code'])."</small></td>
    <td>".esc($t['gender'])."</td>
    <td>".esc($t['subject_name'] ?? '-')."</td>
    <td>".esc($t['email'])."</td>
    <td>".esc($t['phone'])."</td>
    <td>".esc($t['join_date'])."</td>
    <td style='color:$color; font-weight:bold;'>$status</td>
    <td>";

  if ($paid) {
    echo "✅ Paid";
  } else {
    echo "<button class='payBtn' 
            data-id='{$teacher_id}' 
            data-name='".esc($t['first_name'].' '.$t['last_name'])."'>💵 Pay Salary</button>";
  }

  echo "</td></tr>";
  $i++;
endwhile;

echo "</tbody></table>";
echo "<!--PAGE_SPLIT-->";

// 🔁 Pagination controls
if ($totalPages > 1) {
  echo "<div style='text-align:center; margin-top:10px;'>";
  for ($p = 1; $p <= $totalPages; $p++) {
    $active = ($p == $page)
      ? 'background:#007bff; color:white; padding:5px 8px; border-radius:4px;'
      : 'padding:5px 8px;';
    echo "<a href='#' class='page-link' data-page='$p' style='margin:2px; text-decoration:none; $active'>$p</a>";
  }
  echo "</div>";
}
?>
