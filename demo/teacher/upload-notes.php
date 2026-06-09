<?php
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../backend/helpers.php';

/* ===============================
   GOOGLE AUTH CHECK (BEFORE OUTPUT)
================================ */
$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/../backend/google/credentials.json');
$client->setAccessType('offline');
$client->setScopes([Google_Service_Drive::DRIVE_FILE]);

$tokenPath = __DIR__ . '/../backend/google/token.json';

if (!file_exists($tokenPath)) {
    header("Location: google-auth.php");
    exit;
}

$client->setAccessToken(json_decode(file_get_contents($tokenPath), true));

if ($client->isAccessTokenExpired()) {
    header("Location: google-auth.php");
    exit;
}

/* ===============================
   LOGGED-IN TEACHER (FIX 🔥)
================================ */
$user_id = $_SESSION['user_id'] ?? 0;

$t = $conn->query("
    SELECT id 
    FROM teachers 
    WHERE user_id = $user_id 
    LIMIT 1
")->fetch_assoc();

if (!$t) {
    die('Teacher not found.');
}

$teacher_id = (int)$t['id'];

/* ===============================
   SAFE TO OUTPUT HTML NOW
================================ */
include '../partials/portal_header.php';

$drive = new Google_Service_Drive($client);

/* ROOT DRIVE FOLDER */
$ROOT_FOLDER_ID = '1no3F5HHWRQVMfq0EwkAYCbE0gvz6zXIK';

$success = false;

/* ===============================
   HELPERS
================================ */
function normalizeFolderName($name) {
    return preg_replace('/\s+/', ' ', trim($name));
}

function getOrCreateFolder($drive, $name, $parentId) {

    $name = addslashes($name);

    $query = "
        mimeType='application/vnd.google-apps.folder'
        AND name='$name'
        AND '$parentId' in parents
        AND trashed=false
    ";

    $files = $drive->files->listFiles([
        'q' => $query,
        'fields' => 'files(id)',
        'pageSize' => 1
    ]);

    if (!empty($files->files)) {
        return $files->files[0]->id;
    }

    $folder = new Google_Service_Drive_DriveFile([
        'name' => $name,
        'mimeType' => 'application/vnd.google-apps.folder',
        'parents' => [$parentId]
    ]);

    return $drive->files->create($folder, ['fields' => 'id'])->id;
}

/* ===============================
   HANDLE SUBMIT
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $class_id   = (int)$_POST['class_id'];
    $subject_id = (int)$_POST['subject_id'];
    $title      = trim($_POST['title']);
    $desc       = trim($_POST['description']);

    /* Save note */
    $stmt = $conn->prepare("
        INSERT INTO subject_notes
        (teacher_id, class_id, subject_id, title, description)
        VALUES (?,?,?,?,?)
    ");
    $stmt->bind_param("iiiss", $teacher_id, $class_id, $subject_id, $title, $desc);
    $stmt->execute();
    $note_id = $conn->insert_id;

    /* Fetch names */
    $classRow   = $conn->query("SELECT class_name FROM classes WHERE id=$class_id")->fetch_assoc();
    $subjectRow = $conn->query("SELECT subject_name FROM subjects WHERE id=$subject_id")->fetch_assoc();

    $classFolderId = getOrCreateFolder(
        $drive,
        normalizeFolderName($classRow['class_name']),
        $ROOT_FOLDER_ID
    );

    $subjectFolderId = getOrCreateFolder(
        $drive,
        normalizeFolderName($subjectRow['subject_name']),
        $classFolderId
    );

    /* Upload files */
    foreach ($_FILES['files']['name'] as $i => $originalName) {

        if (!$originalName) continue;

        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $driveName = $title . (count($_FILES['files']['name']) > 1 ? " (" . ($i + 1) . ")" : "") . ".$ext";

        $file = $drive->files->create(
            new Google_Service_Drive_DriveFile([
                'name' => $driveName,
                'parents' => [$subjectFolderId]
            ]),
            [
                'data' => file_get_contents($_FILES['files']['tmp_name'][$i]),
                'uploadType' => 'multipart',
                'fields' => 'id'
            ]
        );

        /* Public preview permission */
        $drive->permissions->create(
            $file->id,
            new Google_Service_Drive_Permission([
                'type' => 'anyone',
                'role' => 'reader'
            ]),
            ['sendNotificationEmail' => false]
        );

        $previewLink = "https://drive.google.com/file/d/{$file->id}/preview";

        $stmt = $conn->prepare("
            INSERT INTO subject_note_files
            (note_id, drive_file_id, drive_link)
            VALUES (?,?,?)
        ");
        $stmt->bind_param("iss", $note_id, $file->id, $previewLink);
        $stmt->execute();
    }

    $success = true;
}

/* ===============================
   CLASS → SUBJECT MAP (FIXED)
================================ */
$res = $conn->query("
    SELECT DISTINCT 
        tt.class_id, c.class_name,
        tt.subject_id, s.subject_name
    FROM timetable tt
    JOIN classes c ON c.id = tt.class_id
    JOIN subjects s ON s.id = tt.subject_id
    WHERE tt.teacher_id = $teacher_id
");

$classMap = [];
$subjectMap = [];

while ($r = $res->fetch_assoc()) {
    $classMap[$r['class_id']] = $r['class_name'];
    $subjectMap[$r['class_id']][] = [
        'id' => $r['subject_id'],
        'name' => $r['subject_name']
    ];
}
?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.note-card{
    max-width:720px;
    margin:auto;
    background:white;
    padding:24px;
    border-radius:16px;
    box-shadow:0 8px 22px rgba(0,0,0,.08)
}
.note-card input,
.note-card textarea,
.note-card select{
    width:100%;
    padding:12px;
    margin-top:10px;
    border-radius:10px;
    border:1px solid #ccc
}
.note-card button{
    margin-top:18px;
    width:100%;
    padding:14px;
    background:#007bff;
    color:white;
    font-size:16px;
    border:none;
    border-radius:10px
}
</style>

<div class="note-card">
<h2>📚 Upload Subject Notes</h2>

<form method="post" enctype="multipart/form-data">

<select name="class_id" id="classSelect" required>
    <option value="">Select Class</option>
    <?php foreach ($classMap as $cid => $cname): ?>
        <option value="<?= $cid ?>"><?= esc($cname) ?></option>
    <?php endforeach; ?>
</select>

<select name="subject_id" id="subjectSelect" required disabled>
    <option value="">Select Subject</option>
</select>

<input type="text" name="title" placeholder="Note title (used as file name)" required>

<textarea name="description" rows="4" placeholder="Description (optional)"></textarea>

<input type="file" name="files[]" multiple accept="application/pdf,image/*">

<button type="submit">⬆️ Upload Notes</button>
</form>
</div>

<script>
const subjectMap = <?= json_encode($subjectMap) ?>;
const classSelect = document.getElementById('classSelect');
const subjectSelect = document.getElementById('subjectSelect');

classSelect.addEventListener('change', () => {
    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
    const list = subjectMap[classSelect.value] || [];
    list.forEach(s => {
        subjectSelect.innerHTML += `<option value="${s.id}">${s.name}</option>`;
    });
    subjectSelect.disabled = !list.length;
});
</script>

<?php if ($success): ?>
<script>
Swal.fire({
    icon:'success',
    title:'Uploaded!',
    text:'Notes uploaded successfully and organized by class & subject.',
    confirmButtonColor:'#007bff'
});
</script>
<?php endif; ?>

<?php include '../partials/portal_footer.php'; ?>
