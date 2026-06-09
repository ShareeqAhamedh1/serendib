<?php
// admin/view_registration.php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';



$id = (int)($_GET['id'] ?? 0);
if (!$id) { echo "Invalid id"; exit; }

$stmt = $conn->prepare("SELECT * FROM registrations WHERE id=? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$r = $stmt->get_result()->fetch_assoc();
if (!$r) { echo "Not found"; exit; }
?>

<h2>Registration Details</h2>

<table cellpadding="8" style="background:#fff; border-collapse:collapse; width:100%;">
  <tr><td style="width:180px;font-weight:700">Full name</td><td><?= esc($r['full_name']) ?></td></tr>
  <tr><td style="font-weight:700">DOB</td><td><?= esc($r['dob']) ?></td></tr>
  <tr><td style="font-weight:700">Gender</td><td><?= esc($r['gender']) ?></td></tr>
  <tr><td style="font-weight:700">Joining Grade</td><td><?= 'Grade ' . (int)$r['joining_grade'] ?></td></tr>
  <tr><td style="font-weight:700">Medium</td><td><?= esc($r['medium']) ?></td></tr>
  <tr><td style="font-weight:700">Parent</td><td><?= esc($r['parent_name']) ?></td></tr>
  <tr><td style="font-weight:700">Parent Email</td><td><?= esc($r['parent_email']) ?></td></tr>
  <tr><td style="font-weight:700">Parent Phone</td><td><?= esc($r['parent_phone']) ?></td></tr>
  <tr><td style="font-weight:700">Previous School</td><td><?= esc($r['previous_school']) ?></td></tr>
  <tr><td style="font-weight:700">Address</td><td><?= nl2br(esc($r['address'])) ?></td></tr>
  <tr><td style="font-weight:700">Remarks</td><td><?= nl2br(esc($r['remarks'])) ?></td></tr>
  <tr><td style="font-weight:700">Status</td><td><?= esc($r['status']) ?></td></tr>
  <tr><td style="font-weight:700">Submitted</td><td><?= esc($r['created_at']) ?></td></tr>
</table>

<p style="margin-top:12px;">
  <a href="registrations.php" class="btn-sm">⬅ Back</a>
  <?php if($r['status']==='new'): ?>
    <a href="../backend/registration_action.php?action=check&id=<?= $r['id'] ?>" class="btn-sm" onclick="return confirm('Mark as checked?')">✔ Mark Checked</a>
  <?php else: ?>
    <a href="../backend/registration_action.php?action=uncheck&id=<?= $r['id'] ?>" class="btn-sm" onclick="return confirm('Mark as new?')">↺ Uncheck</a>
  <?php endif; ?>
</p>

<?php include 'partials/footer.php'; ?>
