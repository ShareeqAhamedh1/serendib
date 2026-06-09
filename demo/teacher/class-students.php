<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

// Logged-in teacher user_id
$user_id = $_SESSION['user_id'];

// ✅ Get teacher ID
$teacher = $conn->query("SELECT id FROM teachers WHERE user_id = $user_id")->fetch_assoc();
$teacher_id = $teacher['id'] ?? 0;

if (!$teacher_id) {
    echo "<p style='color:red;'>Teacher record not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

// ✅ Check assigned class + section
$q = $conn->query("
    SELECT 
        tc.class_id, tc.section_id,
        c.class_name,
        s.section_name
    FROM teacher_classes tc
    JOIN classes c ON tc.class_id = c.id
    JOIN sections s ON tc.section_id = s.id
    WHERE tc.teacher_id = $teacher_id
    LIMIT 1
");
$assign = $q->fetch_assoc();

if (!$assign) {
    echo "
    <div style='background:#fef3c7; padding:15px; border-radius:8px; color:#b45309;'>
        ⚠️ <b>No Class Assigned</b><br>
        You are not assigned to any class yet. Please contact the administrator.
    </div>";
    include '../partials/portal_footer.php';
    exit;
}

$class_id   = $assign['class_id'];
$section_id = $assign['section_id'];

// ✅ Fetch students in this class + section
$students = $conn->query("
    SELECT 
        id, admission_no, first_name, last_name, gender, photo
    FROM students
    WHERE class_id = $class_id AND section_id = $section_id
    ORDER BY first_name
");

?>

<h2>👨‍🏫 My Students</h2>

<div style="margin-bottom:20px; padding:15px; background:white; border-radius:10px;">
    <h3 style="margin:0;">
        Class: <?= htmlspecialchars($assign['class_name']) ?>
        &nbsp; | &nbsp;
        Section: <?= htmlspecialchars($assign['section_name']) ?>
    </h3>
    <p style="margin:5px 0; color:#666;">Below is the list of students assigned to your class.</p>
</div>

<table border="1" cellpadding="8" cellspacing="0"
       style="width:100%; background:white; border-collapse:collapse;">
    <thead style="background:#007bff; color:white;">
        <tr>
            <th>Photo</th>
            <th>Admission No</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($students->num_rows == 0): ?>
            <tr>
                <td colspan="5" align="center" style="color:gray;">No students found in this class.</td>
            </tr>
        <?php else: ?>
            <?php while ($s = $students->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img src="../uploads/<?= htmlspecialchars($s['photo'] ?: 'default.png') ?>"
                             style="width:50px;height:50px;border-radius:6px;object-fit:cover;">
                    </td>
                    <td><?= htmlspecialchars($s['admission_no']) ?></td>
                    <td><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($s['gender'])) ?></td>

                    <td>
                        <a href="view-student.php?id=<?= $s['id'] ?>" class="btn-sm">👁 View</a>
                        <a href="marks.php?student=<?= $s['id'] ?>" class="btn-sm">📝 Marks</a>
                        <a href="class-timetable.php" class="btn-sm">🗓 View Class Timetable</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../partials/portal_footer.php'; ?>
