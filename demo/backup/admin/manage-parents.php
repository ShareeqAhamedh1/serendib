<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

/* -----------------------------
   Ensure "parent" role exists
----------------------------- */
function ensure_parent_role_id() {
    global $conn;

    $q = $conn->query("SELECT id FROM roles WHERE name='parent' LIMIT 1");
    if ($q && $q->num_rows > 0) {
        return (int)$q->fetch_assoc()['id'];
    }

    // Create role
    $conn->query("INSERT INTO roles (name, description) VALUES ('parent','Parent portal role')");
    return (int)$conn->insert_id;
}

/* -----------------------------
   Create User Account for Parent
----------------------------- */
function create_parent_user($full_name, $email) {
    global $conn;

    $role_id = ensure_parent_role_id();
    $username = $email; // ✅ Parent logs in using email
    $plain = "parent123"; // ✅ Default password
    $hash  = password_hash($plain, PASSWORD_DEFAULT);

    // Make sure email/username is unique
    $base = $username;
    $i = 0;
    while (true) {
        $chk = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
        $chk->bind_param("s", $username);
        $chk->execute();
        $res = $chk->get_result();
        if ($res->num_rows == 0) break;
        $i++;
        $username = $base . $i;
    }

    $stmt = $conn->prepare("
        INSERT INTO users (role_id, username, password, full_name, email, status, created_at)
        VALUES (?, ?, ?, ?, ?, 'active', NOW())
    ");
    $stmt->bind_param("issss", $role_id, $username, $hash, $full_name, $email);
    $stmt->execute();

    return (int)$stmt->insert_id;
}

/* -----------------------------
   DELETE PARENT
----------------------------- */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // ✅ Optional: deactivate linked user
    $userRes = $conn->query("SELECT user_id FROM parents WHERE id=$id LIMIT 1");
    if ($userRes && ($row = $userRes->fetch_assoc())) {
        $uid = (int)$row['user_id'];
        if ($uid) {
            $conn->query("UPDATE users SET status='inactive' WHERE id=$uid");
        }
    }

    $conn->query("DELETE FROM parents WHERE id=$id");

    echo "<div id='msgBox' style='background:#d4edda; color:#155724; padding:10px; border-radius:6px;'>
            ✅ Parent deleted successfully.
          </div>";
}

/* -----------------------------
   ADD NEW PARENT
----------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name       = trim($_POST['full_name']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $occupation = trim($_POST['occupation']);
    $address    = trim($_POST['address']);

    /* ✅ Check if parent email already used in PARENTS table */
    $checkP = $conn->prepare("SELECT id FROM parents WHERE email=? LIMIT 1");
    $checkP->bind_param("s", $email);
    $checkP->execute();
    $existingParent = $checkP->get_result()->fetch_assoc();

    /* ✅ Check if parent email already used in USERS table */
    $checkU = $conn->prepare("SELECT id FROM users WHERE email=? OR username=? LIMIT 1");
    $checkU->bind_param("ss", $email, $email);
    $checkU->execute();
    $existingUser = $checkU->get_result()->fetch_assoc();

    if ($existingParent || $existingUser) {
        echo "<div id='msgBox' style='background:#f8d7da; color:#721c24; padding:10px; border-radius:6px;'>
                ❌ Parent already exists with this email: <b>$email</b>
              </div>";
    } else {

        // ✅ Create user account
        $user_id = create_parent_user($name, $email);

        // ✅ Insert into parents table
        $stmt = $conn->prepare("
            INSERT INTO parents (full_name, email, phone, occupation, address, user_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sssssi", $name, $email, $phone, $occupation, $address, $user_id);
        $stmt->execute();

        echo "<div id='msgBox' style='background:#d1ecf1; color:#0c5460; padding:10px; border-radius:6px;'>
                ✅ Parent added successfully.<br>
                Login Email: <b>$email</b> <br>
                Password: <b>parent123</b>
              </div>";
    }
}


$parents = $conn->query("SELECT * FROM parents ORDER BY full_name");
?>

<h2>👨‍👩‍👧 Manage Parents</h2>
<p>Add, view, or delete parent accounts.</p>

<!-- Add Parent Form -->
<form method="post" style="background:#f9f9f9; padding:15px; border-radius:8px; margin-bottom:20px; max-width:700px;">
  <h3>Add New Parent</h3>
  <div style="display:flex; flex-wrap:wrap; gap:10px;">
    <input type="text" name="full_name" placeholder="Full Name" required style="flex:1;">
    <input type="email" name="email" placeholder="Email (Login Username)" required style="flex:1;">
    <input type="text" name="phone" placeholder="Phone" style="flex:1;">
    <input type="text" name="occupation" placeholder="Occupation" style="flex:1;">
  </div>
  <textarea name="address" placeholder="Address" style="width:100%; margin-top:10px;"></textarea>
  <br>
  <button type="submit">➕ Add Parent</button>
</form>

<!-- List Parents -->
<table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse:collapse; background:white;">
  <thead style="background:#007bff; color:white;">
    <tr>
      <th>#</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Occupation</th>
      <th>Address</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($parents->num_rows == 0): ?>
      <tr><td colspan="7" style="text-align:center; color:gray;">No parents added yet.</td></tr>
    <?php else: $i=1; while($p = $parents->fetch_assoc()): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= esc($p['full_name']) ?></td>
        <td><?= esc($p['email']) ?></td>
        <td><?= esc($p['phone']) ?></td>
        <td><?= esc($p['occupation']) ?></td>
        <td><?= esc($p['address']) ?></td>
        <td>
          <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete this parent?');">🗑️ Delete</a>
        </td>
      </tr>
    <?php endwhile; endif; ?>
  </tbody>
</table>

<script>
// Fade messages
setTimeout(() => {
  const msg = document.getElementById('msgBox');
  if (msg) msg.style.display = 'none';
}, 2500);
</script>

<?php include 'partials/footer.php'; ?>
