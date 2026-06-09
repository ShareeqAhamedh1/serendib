<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
  echo "<p>Invalid announcement</p>";
  include 'partials/footer.php';
  exit;
}

/* ===============================
   FETCH ANNOUNCEMENT
================================ */
$stmt = $conn->prepare("
  SELECT *
  FROM smart_announcements
  WHERE id=?
  LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$a = $stmt->get_result()->fetch_assoc();

if (!$a) {
  echo "<p>Announcement not found</p>";
  include 'partials/footer.php';
  exit;
}

if ($a['expires_at'] && strtotime($a['expires_at']) <= time()) {
  echo "<p>Expired announcements cannot be edited</p>";
  include 'partials/footer.php';
  exit;
}

/* ===============================
   LOAD CLASSES + AUDIOS
================================ */
$classes = $conn->query("SELECT id,class_name FROM classes ORDER BY class_name");
$audios  = $conn->query("SELECT audio_file,event_type FROM smart_audio_events ORDER BY created_at DESC");
?>

<h2 class="page-title">✏️ Edit Announcement</h2>

<form method="post"
      action="<?= BASE_URL ?>backend/update-announcement.php"
      class="card">

  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= $a['id'] ?>">

  <label>Title</label>
  <input type="text" name="title" value="<?= esc($a['title']) ?>" required>

  <label>Message</label>
  <textarea name="message" rows="4" required><?= esc($a['message']) ?></textarea>

  <label>Target</label>
  <select name="target_type" id="targetType" required>
    <option value="ALL" <?= $a['target_type']=='ALL'?'selected':'' ?>>All Classes</option>
    <option value="CLASS" <?= $a['target_type']=='CLASS'?'selected':'' ?>>Specific Class</option>
    <option value="SECTION" <?= $a['target_type']=='SECTION'?'selected':'' ?>>Specific Section</option>
  </select>

  <select name="class_id" id="classSelect">
    <option value="">-- Select Class --</option>
    <?php while($c=$classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>"
        <?= $a['class_id']==$c['id']?'selected':'' ?>>
        <?= esc($c['class_name']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <label>Audio / Alert Sound</label>
  <select name="audio_file">
    <option value="">-- No Sound --</option>
    <?php while($s=$audios->fetch_assoc()): ?>
      <option value="<?= esc($s['audio_file']) ?>"
        <?= $a['sound_file']===$s['audio_file']?'selected':'' ?>>
        <?= ucfirst($s['event_type']) ?> - <?= esc($s['audio_file']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <label>Priority</label>
  <select name="priority">
    <option value="normal" <?= $a['priority']=='normal'?'selected':'' ?>>Normal</option>
    <option value="urgent" <?= $a['priority']=='urgent'?'selected':'' ?>>Urgent</option>
  </select>

  <label>Expires At</label>
  <input type="datetime-local"
         name="expires_at"
         value="<?= $a['expires_at'] ? date('Y-m-d\TH:i', strtotime($a['expires_at'])) : '' ?>">

  <button type="submit" class="btn-primary">💾 Update Announcement</button>
  <a href="<?= BASE_URL ?>admin/smart-announcement.php" class="btn-reset">Cancel</a>
</form>

<script>
const targetType = document.getElementById('targetType');
const classSelect = document.getElementById('classSelect');

function toggleClass(){
  classSelect.style.display = targetType.value === 'ALL' ? 'none' : 'block';
}
targetType.onchange = toggleClass;
toggleClass();
</script>

<?php include 'partials/footer.php'; ?>
