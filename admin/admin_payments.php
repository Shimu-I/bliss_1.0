<?php
// Include the database configuration file
include '../config.php';

try {
    // Fetch all bill payments from the bill_payment table
    $stmt = $conn->prepare("SELECT * FROM bill_payment");
    $stmt->execute();
    $billPayments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle PDO exception (error)
    echo "Error: " . $e->getMessage();
    exit;
}

// Close the connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Payments Table</title>
</head>
<body>

<button id="go-back-btn" onclick="window.history.back()">Go Back</button>

    <h1>Bill Payments List</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Section Type</th>
                <th>Section Description</th>
                <th>Total Amount</th>
                <th>Payment Date</th>
                <th>Payment Status</th>
                <th>User ID</th>
                <th>Child Type</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($billPayments)) { ?>
                <?php foreach ($billPayments as $bill) { ?>
                    <tr>
                        <td><?php echo $bill['bill_id']; ?></td>
                        <td><?php echo $bill['section_type']; ?></td>
                        <td><?php echo $bill['section_description'] ; ?></td>
                        <td><?php echo number_format($bill['total_amount'], 2); ?></td>
                        <td><?php echo $bill['payment_date']; ?></td>
                        <td><?php echo $bill['payment_status']; ?></td>
                        <td><?php echo $bill['user_id']; ?></td>
                        <td><?php echo $bill['child_type']; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="8">No bill payments found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
