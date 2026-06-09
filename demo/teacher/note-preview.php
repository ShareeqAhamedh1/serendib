<?php
include '../partials/portal_header.php';
require_once __DIR__.'/../backend/conn.php';
require_once __DIR__.'/../backend/helpers.php';

$id = (int)$_GET['id'];

$note = $conn->query("
    SELECT n.*, c.class_name, s.subject_name
    FROM subject_notes n
    JOIN classes c ON c.id=n.class_id
    JOIN subjects s ON s.id=n.subject_id
    WHERE n.id=$id
")->fetch_assoc();

$files = $conn->query("
    SELECT drive_link
    FROM subject_note_files
    WHERE note_id=$id
");
?>

<style>
.preview-box {
    max-width:1100px;
    margin:auto;
}
iframe {
    width:100%;
    height:80vh;
    border:none;
    border-radius:12px;
}
</style>

<div class="preview-box">
<h2><?= esc($note['title']) ?></h2>
<p><?= esc($note['class_name']) ?> · <?= esc($note['subject_name']) ?></p>
<p><?= nl2br(esc($note['description'])) ?></p>

<?php while($f=$files->fetch_assoc()): ?>
<iframe src="<?= esc($f['drive_link']) ?>"></iframe>
<br><br>
<?php endwhile; ?>
</div>

<?php include '../partials/portal_footer.php'; ?>
