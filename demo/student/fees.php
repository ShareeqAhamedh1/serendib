<?php 
include '../partials/portal_header.php';
require_once __DIR__ . '/../backend/conn.php';

// ✅ Get logged-in student user_id
$user_id = $_SESSION['user_id'];

// ✅ Find student record
$stu = $conn->query("SELECT id FROM students WHERE user_id = $user_id")->fetch_assoc();
$student_id = $stu['id'] ?? 0;

if (!$student_id) {
    echo "<p style='color:red;'>Student record not found.</p>";
    include '../partials/portal_footer.php';
    exit;
}

/* ---------------------------------------------------------
   ✅ Fee Summary (Total Fee, Total Paid, Balance)
-----------------------------------------------------------*/
$feeSummaryQuery = "
    SELECT 
        SUM(sf.amount) AS total_fee,
        SUM(fp.paid_amount) AS total_paid
    FROM student_fees sf
    LEFT JOIN fee_payments fp ON sf.id = fp.student_fee_id
    WHERE sf.student_id = $student_id
";
$feeSummary = $conn->query($feeSummaryQuery)->fetch_assoc();

$total_fee  = $feeSummary['total_fee'] ?? 0;
$total_paid = $feeSummary['total_paid'] ?? 0;
$balance    = $total_fee - $total_paid;

/* ---------------------------------------------------------
   ✅ Payment History: JOIN fee_types → student_fees → fee_payments
-----------------------------------------------------------*/
$paymentsQuery = "
    SELECT 
        fp.id,
        fp.paid_amount,
        fp.payment_date,
        fp.method,
        fp.remarks,
        sf.amount AS total_fee,
        sf.term,
        ft.name AS fee_name
    FROM fee_payments fp
    JOIN student_fees sf ON fp.student_fee_id = sf.id
    JOIN fee_types ft ON sf.fee_type_id = ft.id
    WHERE sf.student_id = $student_id
    ORDER BY fp.payment_date DESC
";
$payments = $conn->query($paymentsQuery);
if (!$payments) {
    echo "<p style='color:red;'>SQL Error: " . htmlspecialchars($conn->error) . "</p>";
    include '../partials/portal_footer.php';
    exit;
}

?>

<!-- ✅ Page Title -->
<h2>💰 Fee Summary</h2>

<!-- ✅ Summary Boxes -->
<div style="display:flex; gap:20px; margin-bottom:20px; flex-wrap:wrap;">

    <div style="flex:1; min-width:220px; background:white; padding:20px; border-radius:10px;">
        <h3>📘 Total Fees</h3>
        <p style="font-size:24px; font-weight:bold;">
            <?= number_format($total_fee, 2) ?>
        </p>
    </div>

    <div style="flex:1; min-width:220px; background:white; padding:20px; border-radius:10px;">
        <h3>✅ Total Paid</h3>
        <p style="font-size:24px; font-weight:bold; color:green;">
            <?= number_format($total_paid, 2) ?>
        </p>
    </div>

    <div style="flex:1; min-width:220px; background:white; padding:20px; border-radius:10px;">
        <h3>❌ Remaining Balance</h3>
        <p style="font-size:24px; font-weight:bold; color:red;">
            <?= number_format($balance, 2) ?>
        </p>
    </div>

</div>

<!-- ✅ Payment History Table -->
<h3>🧾 Payment History</h3>

<table border="1" cellpadding="8" cellspacing="0" 
       style="width:100%; background:white; border-collapse:collapse;">
    <thead style="background:#007bff; color:white;">
        <tr>
            <th>Fee Type</th>
            <th>Term</th>
            <th>Fee Amount</th>
            <th>Paid Amount</th>
            <th>Method</th>
            <th>Remarks</th>
            <th>Date</th>
        </tr>
    </thead>

<tbody>
<?php if ($payments->num_rows == 0): ?>
    <tr>
        <td colspan="7" align="center" style="color:gray;">
            No payments made yet.
        </td>
    </tr>
<?php else: ?>
    <?php while($p = $payments->fetch_assoc()): ?>

        <?php
        // ✅ Convert term to readable label
        if ($p['term'] == 1)      $term = "Term 1";
        elseif ($p['term'] == 2)  $term = "Term 2";
        elseif ($p['term'] == 3)  $term = "Term 3";
        else                      $term = "-";
        ?>

        <tr>
            <td><?= htmlspecialchars($p['fee_name']) ?></td>
            <td><?= $term ?></td>
            <td><?= number_format($p['total_fee'], 2) ?></td>
            <td><?= number_format($p['paid_amount'], 2) ?></td>
            <td><?= htmlspecialchars($p['method']) ?></td>
            <td><?= htmlspecialchars($p['remarks']) ?></td>
            <td><?= date('Y-m-d', strtotime($p['payment_date'])) ?></td>
        </tr>

    <?php endwhile; ?>
<?php endif; ?>
</tbody>

</table>

<?php include '../partials/portal_footer.php'; ?>
