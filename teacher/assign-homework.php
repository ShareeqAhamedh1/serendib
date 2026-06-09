<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// ✅ Logged-in teacher
$user_id = $_SESSION['user_id'];
$t = $conn->query("SELECT id FROM teachers WHERE user_id=$user_id LIMIT 1")->fetch_assoc();
$teacher_id = $t['id'];

// ✅ Fetch subjects/classes teacher teaches
$assignments = $conn->query("
    SELECT DISTINCT 
        tt.subject_id,
        s.subject_name,
        tt.class_id,
        c.class_name,
        tt.section_id,
        sec.section_name
    FROM timetable tt
    JOIN subjects s ON s.id = tt.subject_id
    JOIN classes c ON c.id = tt.class_id
    JOIN sections sec ON sec.id = tt.section_id
    WHERE tt.teacher_id = $teacher_id
    ORDER BY c.class_name, s.subject_name
");

// ✅ Handle submit
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $subject_id = (int)$_POST['subject_id'];
    $class_id   = (int)$_POST['class_id'];
    $section_id = (int)$_POST['section_id'];
    $title      = trim($_POST['title']);
    $note       = trim($_POST['note']);
    $due_date   = $_POST['due_date'];

    $filePath = null;

    if (!empty($_FILES['attachment']['name'])) {
        $allowed = ['pdf','jpg','jpeg','png'];
        $ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $newName = 'hw_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $uploadDir = '../uploads/homework/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadDir . $newName);
            $filePath = 'uploads/homework/' . $newName;
        }
    }

    $stmt = $conn->prepare("
        INSERT INTO homeworks 
        (teacher_id, subject_id, class_id, section_id, title, note, attachment, due_date, created_at)
        VALUES (?,?,?,?,?,?,?,?,NOW())
    ");
    $stmt->bind_param(
        "iiiissss",
        $teacher_id,
        $subject_id,
        $class_id,
        $section_id,
        $title,
        $note,
        $filePath,
        $due_date
    );
    $stmt->execute();

    $success = true;
}
?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.hw-wrapper {
    padding: 15px;
}

.hw-card {
    max-width: 620px;
    background: white;
    padding: 22px;
    border-radius: 16px;
    box-shadow: 0 8px 22px rgba(0,0,0,.08);
    margin: auto;
}

.hw-card h2 {
    margin-bottom: 18px;
    font-size: 22px;
}

.hw-card label {
    font-weight: 600;
    display:block;
    margin:12px 0 6px;
    font-size:14px;
}

.hw-card input,
.hw-card select,
.hw-card textarea {
    width:100%;
    padding:14px;
    border-radius:10px;
    border:1px solid #ccd6e0;
    font-size:15px;
}

.hw-card textarea {
    resize: vertical;
}

.hw-card input:focus,
.hw-card select:focus,
.hw-card textarea:focus {
    outline:none;
    border-color:#007bff;
    box-shadow:0 0 0 3px rgba(0,123,255,.15);
}

.hw-card button {
    margin-top:18px;
    width:100%;
    padding:14px;
    background:#007bff;
    border:none;
    color:white;
    font-size:16px;
    font-weight:600;
    border-radius:10px;
    cursor:pointer;
}

.hw-card button:hover {
    background:#0056b3;
}

/* Mobile refinements */
@media (max-width: 480px) {
    .hw-card {
        padding:18px;
    }
    .hw-card h2 {
        font-size:20px;
    }
}

.file-input{
    width:100%;
    padding:14px;
    border:2px dashed #cbd5e1;
    border-radius:14px;
    background:#f8fafc;
    cursor:pointer;
    transition:.25s;
}

.file-input:hover{
    border-color:#3b82f6;
    background:#eff6ff;
}
/* ---------- UPLOAD LOADER ---------- */

.upload-loader{
    position:fixed;
    inset:0;
    background:rgba(255,255,255,.92);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
    backdrop-filter:blur(4px);
}

.loader-box{
    text-align:center;
    background:#fff;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
    width:90%;
    max-width:320px;
}

.loader-box h3{
    margin-top:16px;
    margin-bottom:8px;
}

.loader-box p{
    color:#666;
    font-size:14px;
}

/* Spinner */
.spinner{
    width:58px;
    height:58px;
    margin:auto;
    border:5px solid #dbeafe;
    border-top:5px solid #2563eb;
    border-radius:50%;
    animation:spin 1s linear infinite;
}

@keyframes spin{
    100%{
        transform:rotate(360deg);
    }
}

/* Disabled button */
button.loading{
    opacity:.7;
    pointer-events:none;
}
</style>

<div class="hw-wrapper">

<div class="hw-card">
<h2>📘 Assign Homework</h2>

<form method="post" enctype="multipart/form-data" id="hwForm">

<label>Subject / Class / Section</label>
<select name="subject_id" required>
<option value="">-- Select --</option>
<?php
$assignments->data_seek(0);
while ($a = $assignments->fetch_assoc()):
?>
<option value="<?= $a['subject_id'] ?>"
        data-class="<?= $a['class_id'] ?>"
        data-section="<?= $a['section_id'] ?>">
<?= esc($a['subject_name']) ?> —
<?= esc($a['class_name']) ?> (<?= esc($a['section_name']) ?>)
</option>
<?php endwhile; ?>
</select>

<input type="hidden" name="class_id" id="class_id">
<input type="hidden" name="section_id" id="section_id">

<label>Homework Title</label>
<input type="text" name="title" required placeholder="Eg: Math – Algebra Practice">

<label>Instructions / Note</label>
<textarea name="note" rows="4" placeholder="Write homework instructions..."></textarea>

<label>Attachment</label>

<input 
    type="file" 
    name="attachment"
    accept=".pdf,.jpg,.jpeg,.png"
    required
>

<small style="color:#666;">
  You can upload a PDF, choose an image, or take a photo using your camera.
</small>


<label>Due Date</label>
<input type="date" name="due_date" required>

<button type="submit" id="submitBtn">
    📤 Assign Homework
</button>

</form>
</div>

</div>
<!-- Upload Loader -->
<div class="upload-loader" id="uploadLoader">
    <div class="loader-box">
        <div class="spinner"></div>
        <h3>Uploading Homework...</h3>
        <p>Please wait while the file uploads.</p>
    </div>
</div>

<script>
const sel = document.querySelector("select[name='subject_id']");

sel.addEventListener("change", () => {
    const opt = sel.selectedOptions[0];

    document.getElementById("class_id").value =
        opt.dataset.class || "";

    document.getElementById("section_id").value =
        opt.dataset.section || "";
});

const hwForm = document.getElementById('hwForm');
const uploadLoader = document.getElementById('uploadLoader');
const submitBtn = document.getElementById('submitBtn');

hwForm.addEventListener('submit', function () {

    uploadLoader.style.display = 'flex';

    submitBtn.classList.add('loading');
    submitBtn.innerHTML = '⏳ Uploading...';

});
</script>

<?php if ($success): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Homework Assigned!',
    text: 'Students and parents will be notified.',
    confirmButtonColor: '#007bff'
}).then(() => {
    window.location = 'assign-homework.php';
});
</script>
<?php endif; ?>

<?php include '../partials/portal_footer.php'; ?>
