<h2>🎵 Manage Alert Sounds</h2>

<form method="post" action="<?= BASE_URL ?>backend/save-audio.php" enctype="multipart/form-data">
<?= csrf_field() ?>

<label>Audio Type</label>
<select name="event_type">
  <option value="bell">Bell</option>
  <option value="alert">Alert</option>
  <option value="music">Music</option>
</select>

<label>Audio File</label>
<input type="file" name="audio" accept="audio/*" required>

<button>Upload</button>
</form>
