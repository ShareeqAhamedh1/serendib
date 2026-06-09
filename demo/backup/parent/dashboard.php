<?php
include '../partials/portal_header.php';
?>

<h2>👨‍👩‍👦 Parent Dashboard</h2>

<div style="display:flex; gap:20px; flex-wrap:wrap;">

    <div style="flex:1; min-width:200px; background:white; padding:20px; border-radius:10px;">
        <h3>👦 My Children</h3>
        <p>View all linked students.</p>
        <a href="children.php">View</a>
    </div>

    <div style="flex:1; min-width:200px; background:white; padding:20px; border-radius:10px;">
        <h3>📅 Attendance</h3>
        <p>Track attendance.</p>
        <a href="attendance.php">View</a>
    </div>

    <div style="flex:1; min-width:200px; background:white; padding:20px; border-radius:10px;">
        <h3>💰 Fees</h3>
        <p>Check payments and due balance.</p>
        <a href="fees.php">View</a>
    </div>

</div>

<?php include '../partials/portal_footer.php'; ?>
