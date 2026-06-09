<?php
include '../partials/portal_header.php';
require_once __DIR__ . '../../backend/conn.php';

$parent = $conn->query("
    SELECT id FROM parents WHERE user_id={$_SESSION['user_id']} LIMIT 1
")->fetch_assoc();

$children = $conn->query("
    SELECT s.*, c.class_name, sec.section_name
    FROM students s
    LEFT JOIN classes c ON s.class_id=c.id
    LEFT JOIN sections sec ON s.section_id=sec.id
    WHERE s.parent_id={$parent['id']}
");
?>

<style>
/* ---------- PAGE ---------- */
.children-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 15px;
}

.children-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

/* ---------- CARD ---------- */
.child-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 15px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    transition: transform .2s ease, box-shadow .2s ease;
}

.child-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.12);
}

/* ---------- IMAGE ---------- */
.child-card img {
    width: 100%;
    height: 170px;
    object-fit: cover;
    border-radius: 10px;
}

/* ---------- TEXT ---------- */
.child-card h3 {
    margin: 12px 0 6px;
    color: #004080;
    font-size: 18px;
}

.child-card p {
    margin-bottom: 12px;
    color: #555;
    font-size: 14px;
}

/* ---------- ACTIONS ---------- */
.child-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.child-actions a {
    flex: 1;
    text-align: center;
    text-decoration: none;
    background: #004080;
    color: #fff;
    padding: 8px;
    border-radius: 6px;
    font-size: 14px;
}

.child-actions a:hover {
    background: #003060;
}

/* ---------- MOBILE ---------- */
@media (max-width: 600px) {
    .child-card img {
        height: 150px;
    }
}
/* ---------- HOMEWORK STATUS ---------- */
.hw-status {
    margin-bottom:10px;
    font-size:14px;
}

.hw-status.pending {
    color:#ff9800;
    font-weight:600;
}

.hw-status.overdue {
    color:#dc3545;
    font-weight:700;
}

</style>

<div class="children-container">

    <h2>👦 My Children</h2>

    <?php if ($children->num_rows === 0): ?>
        <p style="color:#555;">No children linked to your account.</p>
    <?php else: ?>

    <div class="children-grid">

        <?php while ($s = $children->fetch_assoc()): ?>
            <?php
// Pending homework
$pendingHW = $conn->query("
    SELECT COUNT(*) AS total
    FROM homeworks h
    LEFT JOIN homework_submissions sub
        ON sub.homework_id = h.id
       AND sub.student_id = {$s['id']}
    WHERE h.class_id = {$s['class_id']}
      AND h.section_id = {$s['section_id']}
      AND sub.id IS NULL
      AND h.due_date >= CURDATE()
")->fetch_assoc()['total'] ?? 0;

// Overdue homework
$overdueHW = $conn->query("
    SELECT COUNT(*) AS total
    FROM homeworks h
    LEFT JOIN homework_submissions sub
        ON sub.homework_id = h.id
       AND sub.student_id = {$s['id']}
    WHERE h.class_id = {$s['class_id']}
      AND h.section_id = {$s['section_id']}
      AND sub.id IS NULL
      AND h.due_date < CURDATE()
")->fetch_assoc()['total'] ?? 0;
?>

            <div class="child-card">

                <img src="<?= BASE_URL ?>uploads/<?= esc($s['photo'] ?: 'default.png') ?>">

                <h3><?= esc($s['first_name'].' '.$s['last_name']) ?></h3>

                <p>🎓 <?= esc(trim(($s['class_name'] ?? '') . ' ' . ($s['section_name'] ?? ''))) ?></p>
<?php if ($overdueHW > 0): ?>
    <div class="hw-status overdue">
        ⏰ <?= $overdueHW ?> overdue homework
    </div>
<?php elseif ($pendingHW > 0): ?>
    <div class="hw-status pending">
        📚 <?= $pendingHW ?> pending homework
    </div>
<?php else: ?>
    <div class="hw-status" style="color:#28a745;font-weight:600;">
        ✅ No homework issues
    </div>
<?php endif; ?>

<div class="child-actions">
    <a href="attendance-calendar.php?student_id=<?= $s['id'] ?>">📅 Attendance</a>
    <a href="fees.php?student=<?= $s['id'] ?>">💰 Fees</a>
    <a href="parent-homeworks.php?student_id=<?= $s['id'] ?>">📚 Homework</a>
</div>


            </div>
        <?php endwhile; ?>

    </div>

    <?php endif; ?>

</div>

<?php include '../partials/portal_footer.php'; ?>
