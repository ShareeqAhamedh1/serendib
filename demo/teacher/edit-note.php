<?php
include '../partials/portal_header.php';
require_once __DIR__.'/../backend/conn.php';
require_once __DIR__.'/../backend/helpers.php';
require_once __DIR__.'/../vendor/autoload.php';

$id = (int)($_GET['id'] ?? 0);

/* ===============================
   FETCH NOTE
================================ */
$note = $conn->query("
    SELECT * FROM subject_notes WHERE id=$id
")->fetch_assoc();

if (!$note) {
    echo "<p style='color:red;'>Note not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

$files = $conn->query("
    SELECT * FROM subject_note_files WHERE note_id=$id
");

/* ===============================
   GOOGLE DRIVE CLIENT
================================ */
$client = new Google_Client();
$client->setAuthConfig(__DIR__.'/../backend/google/credentials.json');
$client->setAccessToken(json_decode(
    file_get_contents(__DIR__.'/../backend/google/token.json'),
    true
));
$client->setScopes([Google_Service_Drive::DRIVE_FILE]);

$drive = new Google_Service_Drive($client);

/* ===============================
   HANDLE UPDATE
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $desc  = trim($_POST['description']);

    // Update DB
    $stmt = $conn->prepare("
        UPDATE subject_notes 
        SET title=?, description=? 
        WHERE id=?
    ");
    $stmt->bind_param("ssi", $title, $desc, $id);
    $stmt->execute();

    // Rename files in Drive (KEEP EXTENSION)
    $files->data_seek(0);
    $i = 1;

    while ($f = $files->fetch_assoc()) {

        $fileInfo = $drive->files->get(
            $f['drive_file_id'],
            ['fields' => 'name']
        );

        $ext = pathinfo($fileInfo->name, PATHINFO_EXTENSION);

        $newName = $title;
        if ($files->num_rows > 1) {
            $newName .= " ($i)";
        }
        if ($ext) {
            $newName .= "." . $ext;
        }

        $fileMeta = new Google_Service_Drive_DriveFile([
            'name' => $newName
        ]);

        $drive->files->update($f['drive_file_id'], $fileMeta);
        $i++;
    }

    // SUCCESS ALERT + REDIRECT
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: 'Note details and Drive files updated successfully.',
            confirmButtonColor: '#007bff'
        }).then(() => {
            window.location.href = 'view-notes.php';
        });
    </script>
    ";
    exit;
}
?>

<style>
/* ===============================
   EDIT NOTE UI
================================ */
.edit-container {
    max-width: 720px;
    margin: 0 auto;
    padding: 16px;
}

.edit-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 26px;
    box-shadow: 0 10px 26px rgba(0,0,0,.08);
}

.edit-card h2 {
    margin-bottom: 18px;
    font-size: 22px;
    color: #003366;
}

.form-group {
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    border: 1px solid #ccc;
    font-size: 15px;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0,123,255,.15);
}

.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.form-actions button,
.form-actions a {
    flex: 1;
    text-align: center;
    padding: 14px;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.btn-save {
    background: #007bff;
    color: white;
}

.btn-save:hover {
    background: #005ecb;
}

.btn-cancel {
    background: #e9ecef;
    color: #333;
}

.btn-cancel:hover {
    background: #d6d9dc;
}

/* ===============================
   MOBILE
================================ */
@media (max-width: 600px) {
    .edit-card {
        padding: 20px;
    }

    .edit-card h2 {
        font-size: 20px;
    }

    .form-actions button,
    .form-actions a {
        font-size: 15px;
        padding: 12px;
    }
}
</style>

<div class="edit-container">
    <div class="edit-card">
        <h2>✏️ Edit Subject Note</h2>

        <form method="post">

            <div class="form-group">
                <label>Note Title</label>
                <input type="text" name="title" value="<?= esc($note['title']) ?>" required>
            </div>

            <div class="form-group">
                <label>Description (optional)</label>
                <textarea name="description" rows="4"><?= esc($note['description']) ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">💾 Save Changes</button>
                <a href="view-notes.php" class="btn-cancel">← Cancel</a>
            </div>

        </form>
    </div>
</div>

<?php include '../partials/portal_footer.php'; ?>
