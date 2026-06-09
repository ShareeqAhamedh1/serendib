<?php
include 'partials/header.php';
require_once __DIR__.'/../backend/conn.php';

/* ===============================
   ADD FORM DATA
================================ */
$classes = $conn->query("SELECT id,class_name FROM classes ORDER BY class_name");

/* ===============================
   FILTERS + PAGINATION
================================ */
$limit = 8;
$page  = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$q      = trim($_GET['q'] ?? '');
$target = $_GET['target'] ?? '';
$status = $_GET['status'] ?? '';

$where = [];
$params = [];
$types  = '';

if ($q !== '') {
  $where[] = "(title LIKE ? OR message LIKE ?)";
  $like = "%$q%";
  $params[] = $like;
  $params[] = $like;
  $types .= "ss";
}

if ($target !== '') {
  $where[] = "target_type = ?";
  $params[] = $target;
  $types .= "s";
}

if ($status === 'active') {
  $where[] = "(expires_at IS NULL OR expires_at > NOW())";
} elseif ($status === 'expired') {
  $where[] = "expires_at <= NOW()";
}

$whereSql = $where ? 'WHERE '.implode(' AND ', $where) : '';

$sqlCount = "SELECT COUNT(*) total FROM smart_announcements $whereSql";
$stmt = $conn->prepare($sqlCount);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];
$pages = max(1, ceil($total / $limit));

$sql = "
  SELECT sa.*, c.class_name
  FROM smart_announcements sa
  LEFT JOIN classes c ON c.id = sa.class_id
  $whereSql
  ORDER BY sa.created_at DESC
  LIMIT $limit OFFSET $offset
";
$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();
?>

<h2 class="page-title">
  📢 Smart Board Announcements
  <button id="openAudioModal" class="btn-purple">🎵 Manage Sounds</button>
</h2>

<!-- ================= ADD FORM ================= -->
<form method="post"
      action="<?= BASE_URL ?>backend/save-announcement.php"
      enctype="multipart/form-data"
      class="card">

  <?= csrf_field() ?>

  <label>Title</label>
  <input type="text" name="title" required>

  <label>Message</label>
  <textarea name="message" rows="4" required></textarea>

  <label>Target</label>
  <select name="target_type" id="targetType" required>
    <option value="ALL">All Classes</option>
    <option value="CLASS">Specific Class</option>
    <option value="SECTION">Specific Section</option>
  </select>

  <select name="class_id" id="classSelect">
    <option value="">-- Select Class --</option>
    <?php while($c=$classes->fetch_assoc()): ?>
      <option value="<?= $c['id'] ?>"><?= esc($c['class_name']) ?></option>
    <?php endwhile; ?>
  </select>

  <label>Audio / Alert Sound</label>
  <select name="audio_file">
    <option value="">-- No Sound --</option>
    <?php
    $audios = $conn->query("SELECT audio_file,event_type FROM smart_audio_events ORDER BY created_at DESC");
    while($a=$audios->fetch_assoc()):
    ?>
      <option value="<?= esc($a['audio_file']) ?>">
        <?= ucfirst($a['event_type']) ?> - <?= esc($a['audio_file']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <label>Priority</label>
  <select name="priority">
    <option value="normal">Normal</option>
    <option value="urgent">Urgent</option>
  </select>

  <label>Expires At</label>
  <input type="datetime-local" name="expires_at">

  <button type="submit" class="btn-primary">📤 Send Announcement</button>
</form>

<!-- ================= FILTER BAR ================= -->
<form method="get" class="filter-bar">
  <input name="q" value="<?= esc($q) ?>" placeholder="Search">

  <select name="target">
    <option value="">Target</option>
    <option value="ALL" <?= $target=='ALL'?'selected':'' ?>>All</option>
    <option value="CLASS" <?= $target=='CLASS'?'selected':'' ?>>Class</option>
    <option value="SECTION" <?= $target=='SECTION'?'selected':'' ?>>Section</option>
  </select>

  <select name="status">
    <option value="">Status</option>
    <option value="active" <?= $status=='active'?'selected':'' ?>>Active</option>
    <option value="expired" <?= $status=='expired'?'selected':'' ?>>Expired</option>
  </select>

  <button class="btn-filter">Filter</button>
  <?php if($q||$target||$status): ?>
    <a href="<?= BASE_URL ?>admin/smart-announcement.php" class="btn-reset">Reset</a>
  <?php endif; ?>
</form>

<!-- ================= LIST ================= -->
<table class="table">
<thead>
<tr>
  <th>Title</th>
  <th>Target</th>
  <th>Priority</th>
  <th>Expires</th>
  <th>Status</th>
  <th>Actions</th>
</tr>
</thead>
<tbody>
<?php while($a=$res->fetch_assoc()):
$expired = $a['expires_at'] && strtotime($a['expires_at']) <= time();
?>
<tr>
  <td><?= esc($a['title']) ?></td>
  <td><?= esc($a['target_type']) ?> <?= $a['class_name']?' - '.esc($a['class_name']):'' ?></td>
  <td><?= ucfirst($a['priority']) ?></td>
  <td><?= $a['expires_at'] ?: '-' ?></td>
  <td>
    <span class="badge <?= $expired?'expired':'active' ?>">
      <?= $expired?'Expired':'Active' ?>
    </span>
  </td>
  <td>
    <?php if(!$expired): ?>
      <a href="<?= BASE_URL ?>admin/edit-announcement.php?id=<?= $a['id'] ?>">✏️ Edit</a>
    <?php endif; ?>
    |
    <form method="post"
          action="<?= BASE_URL ?>backend/delete-announcement.php"
          style="display:inline"
          onsubmit="return confirm('Delete this announcement?')">
      <?= csrf_field() ?>
      <input type="hidden" name="id" value="<?= $a['id'] ?>">
      <button type="submit" class="btn-delete">🗑</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- ================= AUDIO MODAL ================= -->
<div id="audioModal" class="modal-overlay">
  <div class="modal-box">
    <h3>🎵 Manage Sounds</h3>

    <form id="audioUploadForm" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <select name="event_type" required>
        <option value="bell">Bell</option>
        <option value="alert">Alert</option>
        <option value="music">Music</option>
      </select>
      <input type="file" name="audio" accept="audio/*" required>
      <button type="submit" class="btn-primary">Upload</button>
    </form>

    <div id="audioList"></div>

    <button type="button" onclick="closeAudioModal()" class="btn-reset">Close</button>
  </div>
</div>

<!-- ================= STYLES ================= -->
<style>
.page-title{display:flex;justify-content:space-between;align-items:center}
.card{background:#fff;padding:20px;border-radius:10px;max-width:600px;margin-bottom:25px}
input,select,textarea{width:100%;padding:8px;margin-bottom:10px}
.btn-primary{background:#005c2e;color:#fff;padding:8px 12px;border:none}
.btn-purple{background:#6f42c1;color:#fff;padding:6px 10px;border:none;border-radius:6px}
.btn-delete{background:none;border:none;color:#dc3545;cursor:pointer}
.filter-bar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:15px}
.btn-filter{background:#005c2e;color:#fff;padding:6px 10px}
.btn-reset{background:#777;color:#fff;padding:6px 10px;text-decoration:none}
.badge{padding:4px 8px;border-radius:6px;font-size:12px}
.badge.active{background:#e6f9ec;color:#0f5132}
.badge.expired{background:#fdecea;color:#842029}
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);display:none;align-items:center;justify-content:center;z-index:9999}
.modal-box{background:#fff;padding:20px;border-radius:10px;width:400px}
.audio-item{display:flex;justify-content:space-between;margin:6px 0}
<style>
.swal2-container {
  z-index: 100000 !important;
}
</style>

</style>

<!-- ================= JS ================= -->
<script>
const modal = document.getElementById('audioModal');
const audioList = document.getElementById('audioList');
const audioUploadForm = document.getElementById('audioUploadForm');
const openAudioBtn = document.getElementById('openAudioModal');

openAudioBtn.onclick = () => {
  modal.style.display = 'flex';
  loadAudios();
};

function closeAudioModal() {
  modal.style.display = 'none';
}

function loadAudios(){
  fetch('<?= BASE_URL ?>backend/list-audios.php')
    .then(r => r.json())
    .then(data => {
      audioList.innerHTML = '';
      data.forEach(a => {
        audioList.innerHTML += `
          <div class="audio-item">
            <div>
              <strong>${a.event_type}</strong><br>
              <small>${a.audio_file}</small>
            </div>
            <button onclick="deleteAudio('${a.audio_file}')">🗑</button>
          </div>`;
      });
    });
}


audioUploadForm.onsubmit = e => {
  e.preventDefault();
  fetch('<?= BASE_URL ?>backend/save-audio.php', {
    method: 'POST',
    body: new FormData(audioUploadForm)
  })
  .then(r => r.json())
  .then(res => {
    Swal.fire(res.status, res.message, res.status);
    if (res.status === 'success') {
closeAudioModal();
}
  });
};

function deleteAudio(file){
  closeAudioModal();

  Swal.fire({
    icon:'warning',
    title:'Delete this sound?',
    showCancelButton:true
  }).then(r=>{
    if(r.isConfirmed){
      fetch('<?= BASE_URL ?>backend/delete-audio.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({audio_file:file})
      })
      .then(r=>r.json())
      .then(res=>{
        Swal.fire(res.status,res.message,res.status);
        if(res.status==='success') loadAudios();
      });
    }
  });
}

/* TARGET CLASS VISIBILITY */
const targetType = document.getElementById('targetType');
const classSelect = document.getElementById('classSelect');

function toggleClass(){
  classSelect.style.display = targetType.value === 'ALL' ? 'none' : 'block';
}
targetType.onchange = toggleClass;
toggleClass();
</script>

<?php if(!empty($_SESSION['flash'])): ?>
<script>
Swal.fire({
  icon: '<?= $_SESSION['flash']['type'] ?>',
  text: '<?= $_SESSION['flash']['message'] ?>'
});
</script>
<?php unset($_SESSION['flash']); endif; ?>

<?php include 'partials/footer.php'; ?>
