<?php
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Default teacher array
$teacher = [
  'id' => 0,
  'teacher_code' => '',
  'first_name' => '',
  'last_name' => '',
  'gender' => 'male',
  'email' => '',
  'phone' => '',
  'subject_id' => null,
  'photo' => '',
  'status' => 'active'
];

// ✅ Editing existing teacher
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM teachers WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $teacher = $stmt->get_result()->fetch_assoc();
}
// ✅ Adding new teacher → auto generate teacher code
else {
    $res = $conn->query("SELECT MAX(id) AS max_id FROM teachers");
    $next = ($res->fetch_assoc()['max_id'] ?? 0) + 1;
    $teacher['teacher_code'] = 'T' . str_pad($next, 3, '0', STR_PAD_LEFT);
}

$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY subject_name");
?>

<style>
.form-card {
    max-width: 850px;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}
.form-card label {
    font-weight: bold;
    margin-top: 8px;
    display: block;
}
.form-card input,
.form-card select,
.form-card textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 5px;
}
.save-btn {
    padding: 12px 25px;
    background: #007bff;
    border: none;
    color: white;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
}
.save-btn:hover {
    background: #0056b3;
}
.photo-preview {
    margin-top: 8px;
    padding: 8px;
    background: #f7f7f7;
    border-radius: 6px;
}
</style>

<h2><?= $id ? '✏ Edit Teacher' : '➕ Add Teacher' ?></h2>

<div class="form-card">

<form method="post" 
      action="<?= BASE_URL ?>backend/teachers.php?action=<?= $id ? 'update' : 'create' ?>" 
      enctype="multipart/form-data">

  <?= csrf_field() ?>

  <?php if($id): ?>
    <input type="hidden" name="id" value="<?= $teacher['id'] ?>">
  <?php endif; ?>

  <div class="form-grid">

    <!-- Teacher Code -->
    <div>
        <label>Teacher Code</label>
        <input type="text" name="teacher_code" value="<?= esc($teacher['teacher_code']) ?>" readonly
               style="background:#eee; cursor:not-allowed;">
        <small style="color:gray;">System generated</small>
    </div>

    <!-- Subject -->
    <div>
        <label>Subject</label>
        <select name="subject_id">
            <option value="">-- Select Subject --</option>
            <?php while($s = $subjects->fetch_assoc()): ?>
              <option value="<?= $s['id'] ?>" <?= $teacher['subject_id']==$s['id']?'selected':'' ?>>
                <?= esc($s['subject_name']) ?>
              </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div>
        <label>First Name</label>
        <input name="first_name" required value="<?= esc($teacher['first_name']) ?>">
    </div>

    <div>
        <label>Last Name</label>
        <input name="last_name" required value="<?= esc($teacher['last_name']) ?>">
    </div>

    <div>
        <label>Gender</label>
        <select name="gender">
            <option value="male"   <?= $teacher['gender']=='male'?'selected':'' ?>>Male</option>
            <option value="female" <?= $teacher['gender']=='female'?'selected':'' ?>>Female</option>
            <option value="other"  <?= $teacher['gender']=='other'?'selected':'' ?>>Other</option>
        </select>
    </div>

    <div>
        <label>Phone</label>
        <input name="phone" pattern="[0-9]{10,15}" value="<?= esc($teacher['phone']) ?>">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" required value="<?= esc($teacher['email']) ?>">
    </div>

    <!-- ✅ STATUS FIELD -->
    <div>
        <label>Status</label>
        <select name="status">
            <option value="active"   <?= $teacher['status']=='active'?'selected':'' ?>>Active</option>
            <option value="inactive" <?= $teacher['status']=='inactive'?'selected':'' ?>>Inactive</option>
            <option value="left"     <?= $teacher['status']=='left'?'selected':'' ?>>Left School</option>
        </select>
    </div>

    <!-- Photo -->
    <div>
        <label>Photo</label>
        <input type="file" name="photo" accept="image/*">

        <?php if($teacher['photo']): ?>
        <div class="photo-preview">
            <strong>Current:</strong><br>
            <img src="<?= BASE_URL ?>uploads/<?= esc($teacher['photo']) ?>" width="80">
        </div>
        <?php endif; ?>
    </div>
  
<br>
  <button class="save-btn" type="submit"><?= $id ? '💾 Save Changes' : '✅ Add Teacher' ?></button>
  </div>


</form>

</div>

<?php include 'partials/footer.php'; ?>
