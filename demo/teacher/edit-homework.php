<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// SweetAlert
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

// Logged-in teacher
$user_id = $_SESSION['user_id'];
$t = $conn->query("SELECT id FROM teachers WHERE user_id=$user_id LIMIT 1")->fetch_assoc();
$teacher_id = $t['id'];

$id = (int)($_GET['id'] ?? 0);

// Fetch homework
$hw = $conn->query("
    SELECT * FROM homeworks
    WHERE id = $id AND teacher_id = $teacher_id
    LIMIT 1
")->fetch_assoc();

if (!$hw) {
    die("Homework not found.");
}

/* ---------------------------
   UPDATE
---------------------------- */
if (isset($_POST['update'])) {

    $title = trim($_POST['title']);
    $note = trim($_POST['note']);
    $due_date = $_POST['due_date'];
    $filePath = $hw['attachment'];

    if (!empty($_FILES['attachment']['name'])) {
        $allowed = ['pdf','jpg','jpeg','png'];
        $ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            if ($filePath && file_exists('../' . $filePath)) {
                unlink('../' . $filePath);
            }

            $newName = 'hw_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $dir = '../uploads/homework/';
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            move_uploaded_file($_FILES['attachment']['tmp_name'], $dir . $newName);
            $filePath = 'uploads/homework/' . $newName;
        }
    }

    $stmt = $conn->prepare("
        UPDATE homeworks
        SET title=?, note=?, attachment=?, due_date=?
        WHERE id=? AND teacher_id=?
    ");
    $stmt->bind_param("ssssii", $title, $note, $filePath, $due_date, $id, $teacher_id);
    $stmt->execute();

    echo "<script>
        Swal.fire({
            icon:'success',
            title:'Updated!',
            text:'Homework updated successfully',
            confirmButtonColor:'#007bff'
        }).then(()=>location.href='view-homeworks.php');
    </script>";
}

/* ---------------------------
   DELETE
---------------------------- */
if (isset($_POST['delete'])) {

    if ($hw['attachment'] && file_exists('../' . $hw['attachment'])) {
        unlink('../' . $hw['attachment']);
    }

    $conn->query("
        DELETE FROM homeworks
        WHERE id=$id AND teacher_id=$teacher_id
    ");

    echo "<script>
        Swal.fire({
            icon:'success',
            title:'Deleted!',
            text:'Homework removed',
            confirmButtonColor:'#dc3545'
        }).then(()=>location.href='view-homeworks.php');
    </script>";
}
?>

<style>
.hw-card {
    max-width:600px;
    margin:auto;
    background:white;
    padding:22px;
    border-radius:16px;
    box-shadow:0 8px 22px rgba(0,0,0,.08);
}
.hw-card h2 {
    margin-bottom:18px;
}
.hw-card label {
    font-weight:600;
    margin-top:12px;
    display:block;
}
.hw-card input,
.hw-card textarea {
    width:100%;
    padding:14px;
    border-radius:10px;
    border:1px solid #ccc;
    margin-top:6px;
}
.hw-actions {
    display:flex;
    gap:10px;
    margin-top:20px;
}
.hw-actions button {
    flex:1;
    padding:14px;
    border:none;
    border-radius:10px;
    font-weight:600;
    cursor:pointer;
}
.btn-save { background:#007bff; color:white; }
.btn-delete { background:#dc3545; color:white; }

@media (max-width:480px){
    .hw-actions { flex-direction:column; }
}
</style>

<div class="hw-card">
<h2>✏️ Edit Homework</h2>

<form method="post" enctype="multipart/form-data">

<label>Title</label>
<input type="text" name="title" value="<?= esc($hw['title']) ?>" required>

<label>Note</label>
<textarea name="note" rows="4"><?= esc($hw['note']) ?></textarea>

<label>Due Date</label>
<input type="date" name="due_date" value="<?= esc($hw['due_date']) ?>" required>

<label>Replace Attachment (optional)</label>
<input type="file" name="attachment" accept="application/pdf,image/*" capture>

<?php if ($hw['attachment']): ?>
<p>
📎 <a href="../<?= esc($hw['attachment']) ?>" target="_blank">Current attachment</a>
</p>
<?php endif; ?>

<div class="hw-actions">
    <button type="submit" name="update" class="btn-save">💾 Save Changes</button>
    <button type="submit" name="delete" class="btn-delete"
        onclick="return confirm('Delete this homework?');">
        🗑 Delete
    </button>
</div>

</form>
</div>

<?php include '../partials/portal_footer.php'; ?>
