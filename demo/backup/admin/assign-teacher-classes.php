<?php
ob_start(); 
include 'partials/header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

/* -----------------------------------------
   LOAD DATA
------------------------------------------ */

// Teachers
$teachers = $conn->query("
    SELECT id, first_name, last_name, teacher_code 
    FROM teachers ORDER BY first_name
");

// Classes
$classes = $conn->query("
    SELECT id, class_name FROM classes ORDER BY class_name
");

// Sections
$sectionsQuery = $conn->query("SELECT * FROM sections ORDER BY section_name");
$sections = [];
while ($s = $sectionsQuery->fetch_assoc()) {
    $sections[] = $s;
}

// Current assignments
$assignedPairs = [];
$allAssignments = [];

$assignments = $conn->query("
    SELECT tc.id, tc.teacher_id, tc.class_id, tc.section_id,
           t.first_name, t.last_name, t.teacher_code,
           c.class_name, s.section_name
    FROM teacher_classes tc
    JOIN teachers t ON tc.teacher_id = t.id
    JOIN classes c ON tc.class_id = c.id
    JOIN sections s ON tc.section_id = s.id
    ORDER BY c.class_name, s.section_name
");

while ($a = $assignments->fetch_assoc()) {
    $assignedPairs[] = $a['class_id'] . "-" . $a['section_id'];
    $allAssignments[] = $a;
}

/* -----------------------------------------
   HANDLE CREATE OR UPDATE
------------------------------------------ */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $teacher_id = (int)$_POST['teacher_id'];
    $class_id   = (int)$_POST['class_id'];
    $section_id = (int)$_POST['section_id'];
    $edit_id    = (int)($_POST['edit_id'] ?? 0);

    $isEditing = $edit_id > 0;

    // Teacher cannot be class teacher for more than one class
    if (!$isEditing) {
        $check = $conn->query("SELECT id FROM teacher_classes WHERE teacher_id = $teacher_id");
        if ($check->num_rows > 0) {
            $error = "❌ This teacher is already assigned to a class.";
        }
    }

    // Class + section must be unique
    $pairKey = "$class_id-$section_id";

    if (!$isEditing && in_array($pairKey, $assignedPairs)) {
        $error = "❌ This class + section is already assigned.";
    }

    if (!isset($error)) {
        if ($isEditing) {
            // UPDATE
            $stmt = $conn->prepare("UPDATE teacher_classes SET teacher_id=?, class_id=?, section_id=? WHERE id=?");
            $stmt->bind_param("iiii", $teacher_id, $class_id, $section_id, $edit_id);
            $stmt->execute();

            $success = "✅ Assignment updated successfully";
        } else {
            // CREATE
            $stmt = $conn->prepare("
                INSERT INTO teacher_classes (teacher_id, class_id, section_id, created_at)
                VALUES (?, ?, ?, NOW())
            ");
            $stmt->bind_param("iii", $teacher_id, $class_id, $section_id);
            $stmt->execute();

            $success = "✅ Class assigned to teacher";
        }

        header("Location: assign-teacher-classes.php?success=" . urlencode($success));
        exit;
    }
}

/* -----------------------------------------
   DELETE ASSIGNMENT
------------------------------------------ */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM teacher_classes WHERE id=$id");
    header("Location: assign-teacher-classes.php?success=" . urlencode("Assignment removed"));
    exit;
}
?>
<style>
.form-box {background:white; padding:20px; border-radius:10px; margin-bottom:25px;}
.warning {color:red; font-size:12px;}
.disabled-opt {color:#aaa;}
.table {width:100%; border-collapse:collapse; background:white;}
.table th, .table td {padding:8px; border-bottom:1px solid #ccc;}
.table th {background:#007bff; color:white;}
.btn-sm {padding:6px 10px; background:#007bff; border-radius:6px; color:white; text-decoration:none;}
.btn-sm.red {background:#cc0000;}

/* Fade-out alert */
.fade-out {
    transition: opacity 0.8s ease;
}
</style>

<h2>📘 Assign Class Teacher</h2>

<!-- ✅ SUCCESS BOX (Auto-hide) -->
<?php if(isset($_GET['success'])): ?>
<div id="successBox" class="fade-out" style="background:#d4edda; padding:8px; color:#155724; border-radius:6px; margin-bottom:15px;">
    <?= htmlspecialchars($_GET['success']) ?>
</div>
<?php endif; ?>

<!-- ✅ ERROR BOX (Auto-hide) -->
<?php if(isset($error)): ?>
<div id="errorBox" class="fade-out" style="background:#f8d7da; padding:8px; color:#721c24; border-radius:6px; margin-bottom:15px;">
    <?= $error ?>
</div>
<?php endif; ?>

<div class="form-box">
<form method="post">

    <?php 
    $editData = null;
    if (isset($_GET['edit'])) {
        $eid = (int)$_GET['edit'];
        $editData = $conn->query("SELECT * FROM teacher_classes WHERE id=$eid")->fetch_assoc();
        echo "<input type='hidden' name='edit_id' value='$eid'>";
    }
    ?>

    <label><b>Select Teacher</b></label>
    <select name="teacher_id" required style="width:100%;padding:10px;">
        <option value="">-- Select --</option>
        <?php
        $teachers->data_seek(0);
        while ($t = $teachers->fetch_assoc()): 
            $selected = ($editData && $editData['teacher_id']==$t['id']) ? "selected" : "";
        ?>
            <option value="<?= $t['id'] ?>" <?= $selected ?>>
                <?= $t['first_name'].' '.$t['last_name'] ?> (<?= $t['teacher_code'] ?>)
            </option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <label><b>Select Class</b></label>
    <select name="class_id" id="classSelect" required style="width:100%;padding:10px;">
        <option value="">-- Select --</option>
        <?php
        $classes->data_seek(0);
        while ($c = $classes->fetch_assoc()):
            $selected = ($editData && $editData['class_id']==$c['id']) ? "selected" : "";
        ?>
            <option value="<?= $c['id'] ?>" <?= $selected ?>><?= $c['class_name'] ?></option>
        <?php endwhile; ?>
    </select>

    <br><br>

    <label><b>Select Section</b></label>
    <select name="section_id" id="sectionSelect" required style="width:100%;padding:10px;">
        <?php if($editData): ?>
            <option value="<?= $editData['section_id'] ?>">Current</option>
        <?php else: ?>
            <option value="">-- Select Class First --</option>
        <?php endif; ?>
    </select>

    <br><br>

    <button class="btn-sm">✅ Save</button>

</form>
</div>

<h3>📋 Assigned Class Teachers</h3>

<table class="table">
<tr>
    <th>Teacher</th>
    <th>Class</th>
    <th>Section</th>
    <th>Actions</th>
</tr>

<?php foreach($allAssignments as $a): ?>
<tr>
    <td><?= $a['first_name'].' '.$a['last_name'].' ('.$a['teacher_code'].')' ?></td>
    <td><?= $a['class_name'] ?></td>
    <td><?= $a['section_name'] ?></td>
    <td>
        <a class="btn-sm" href="?edit=<?= $a['id'] ?>">✏ Edit</a>
        <a class="btn-sm red" href="?delete=<?= $a['id'] ?>" onclick="return confirm('Remove assignment?')">🗑 Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<script>
let sections = <?= json_encode($sections) ?>;
let assigned = <?= json_encode($assignedPairs) ?>;

let classSel = document.getElementById("classSelect");
let secSel = document.getElementById("sectionSelect");

// ✅ Auto-hide alerts + remove from URL
setTimeout(() => {
    const success = document.getElementById('successBox');
    const error = document.getElementById('errorBox');
    [success, error].forEach(box => {
        if (box) {
            box.style.opacity = 0;
            setTimeout(() => box.remove(), 800);
        }
    });

    // ✅ Remove ?success=... or ?error=... from URL
    if (window.location.search.includes("success") || window.location.search.includes("error")) {
        history.replaceState({}, document.title, "assign-teacher-classes.php");
    }
}, 2500);

classSel.addEventListener("change", function() {
    let cid = this.value;
    secSel.innerHTML = "<option value=''>-- Select --</option>";

    sections.forEach(s => {
        if (s.class_id == cid) {
            let key = cid + "-" + s.id;
            let disabled = assigned.includes(key) ? "disabled" : "";
            secSel.innerHTML += `
                <option value="${s.id}" ${disabled}>
                    ${s.section_name} ${disabled ? "(Assigned)" : ""}
                </option>
            `;
        }
    });
});
</script>


<?php
ob_end_flush();
?>
<?php include 'partials/footer.php'; ?>
