<?php
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';
require_once __DIR__ . '/../backend/helpers.php';

// Logged-in student
$user_id = $_SESSION['user_id'];

$student = $conn->query("
    SELECT id, class_id, section_id
    FROM students
    WHERE user_id = $user_id
    LIMIT 1
")->fetch_assoc();

$class_id   = $student['class_id'];
$section_id = $student['section_id'];

// Homework ID
$hw_id = (int)($_GET['id'] ?? 0);

// Fetch homework (SECURE: class & section check)
$hw = $conn->query("
    SELECT 
        h.*,
        s.subject_name,
        t.first_name,
        t.last_name
    FROM homeworks h
    JOIN subjects s ON s.id = h.subject_id
    JOIN teachers t ON t.id = h.teacher_id
    WHERE h.id = $hw_id
      AND h.class_id = $class_id
      AND h.section_id = $section_id
    LIMIT 1
")->fetch_assoc();

if (!$hw) {
    echo "<p style='color:red;'>Homework not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

$submission = $conn->query("
    SELECT submitted_at
    FROM homework_submissions
    WHERE homework_id = $hw_id
      AND student_id = {$student['id']}
    LIMIT 1
")->fetch_assoc();


if ($submission) {
    $status = 'submitted';
} elseif ($hw['due_date'] < date('Y-m-d')) {
    $status = 'overdue';
} else {
    $status = 'pending';
}

?>

<style>
.hw-wrapper {
    max-width:720px;
    margin:auto;
}

.hw-card {
    background:white;
    padding:22px;
    border-radius:16px;
    box-shadow:0 8px 22px rgba(0,0,0,.08);
}

.hw-header h2 {
    margin-bottom:6px;
}

.hw-meta {
    font-size:14px;
    color:#555;
    margin-bottom:12px;
}

.hw-status {
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    font-weight:600;
    font-size:14px;
}

.hw-pending {
    background:#fff3cd;
    color:#664d03;
}

.hw-overdue {
    background:#fdecea;
    color:#842029;
}

.hw-note {
    margin-top:16px;
    line-height:1.6;
    font-size:15px;
    white-space:pre-line;
}

.hw-attach {
    margin-top:18px;
}

.hw-attach a {
    display:inline-block;
    padding:10px 14px;
    background:#007bff;
    color:white;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
}

.hw-attach a:hover {
    background:#0056b3;
}

.hw-preview {
    margin-top:16px;
}

.hw-preview img {
    max-width:100%;
    border-radius:10px;
}

/* Mobile */
@media (max-width:480px) {
    .hw-card {
        padding:18px;
    }
}
</style>

<div class="hw-wrapper">

<div class="hw-card">

    <div class="hw-header">
        <h2>📘 <?= esc($hw['title']) ?></h2>
        <div class="hw-meta">
            📚 <?= esc($hw['subject_name']) ?><br>
            👩‍🏫 <?= esc($hw['first_name'].' '.$hw['last_name']) ?><br>
            📅 Due: <?= esc($hw['due_date']) ?>
        </div>

<span class="hw-status hw-<?= $status ?>">
    <?= ucfirst($status) ?>
    <?php if ($status === 'submitted'): ?>
        (<?= esc(date('d M Y', strtotime($submission['submitted_at']))) ?>)
    <?php endif; ?>
</span>

    </div>

    <?php if (!empty($hw['note'])): ?>
        <div class="hw-note">
            <h4>📝 Instructions</h4>
            <?= esc($hw['note']) ?>
        </div>
    <?php endif; ?>

    <?php if ($hw['attachment']): ?>
        <div class="hw-attach">
            <a href="../<?= esc($hw['attachment']) ?>" target="_blank">
                📎 Download Attachment
            </a>

<?php if ($submission): ?>
    <p style="margin-top:10px;color:#0f5132;font-weight:600;">
        ✅ Homework submitted successfully
    </p>
<?php else: ?>
    <a href="homework-submit.php?id=<?= $hw['id'] ?>" class="card-button">
        📤 Submit Homework
    </a>
<?php endif; ?>

        </div>

        <?php
        $ext = strtolower(pathinfo($hw['attachment'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png'])):
        ?>
        <div class="hw-preview">
            <img src="../<?= esc($hw['attachment']) ?>" alt="Homework Image">
        </div>
        <?php endif; ?>
    <?php endif; ?>

</div>

</div>

<?php include '../partials/portal_footer.php'; ?>
