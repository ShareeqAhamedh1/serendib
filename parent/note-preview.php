<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

$id = (int)($_GET['id'] ?? 0);

/* ===============================
   FETCH NOTE (SECURE)
================================ */
$note = $conn->query("
    SELECT n.*, s.subject_name, c.class_name
    FROM subject_notes n
    JOIN subjects s ON s.id = n.subject_id
    JOIN classes c ON c.id = n.class_id
    WHERE n.id = $id
")->fetch_assoc();

if (!$note) {
    echo "<p style='color:red;'>Note not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

$files = $conn->query("
    SELECT drive_link 
    FROM subject_note_files 
    WHERE note_id = $id
");
?>

<style>
.preview-container{
    max-width:1100px;
    margin:0 auto;
    padding:16px;
}
.preview-card{
    background:white;
    border-radius:18px;
    padding:24px;
    box-shadow:0 8px 22px rgba(0,0,0,.08)
}
.preview-card h2{
    color:#004080;
    margin-bottom:6px
}
.preview-meta{
    color:#555;
    font-size:14px;
    margin-bottom:16px
}
.preview-frame{
    width:100%;
    height:520px;
    border:none;
    border-radius:14px;
    box-shadow:0 6px 16px rgba(0,0,0,.08);
    margin-bottom:18px
}

/* MOBILE */
@media(max-width:768px){
    .preview-frame{
        height:380px
    }
}
</style>

<div class="preview-container">

<div class="preview-card">

<h2><?= esc($note['title']) ?></h2>

<div class="preview-meta">
🎓 <?= esc($note['class_name']) ?> |
📘 <?= esc($note['subject_name']) ?> |
📅 <?= date('d M Y', strtotime($note['created_at'])) ?>
</div>

<?php if ($files->num_rows === 0): ?>
<p style="color:#777;">No files attached.</p>
<?php else: ?>

<?php while($f = $files->fetch_assoc()): ?>
<iframe 
    class="preview-frame"
    src="<?= esc($f['drive_link']) ?>"
    allowfullscreen>
</iframe>
<?php endwhile; ?>

<p style="font-size:14px;color:#666;">
ℹ️ You can use the Drive toolbar to open or download the file.
</p>

<?php endif; ?>

</div>
</div>

<?php include '../partials/portal_footer.php'; ?>
