<?php
// Include the database configuration file
include '../config.php';

try {
    // Fetch all children from the child table
    $stmt = $conn->prepare("SELECT * FROM child");
    $stmt->execute();
    $children = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle PDO exception (error)
    echo "Error: " . htmlspecialchars($e->getMessage());
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
    <title>Children Table</title>
    
    <link rel="stylesheet" href="../admin/admin_css/children.css">
</head>
<body>
<button id="go-back-btn" onclick="window.history.back()">Go Back</button>



<h1>Children List</h1>
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Child ID</th>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Medical History</th>
            <th>Special Needs</th>
            <th>User ID</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($children)) { ?>
            <?php foreach ($children as $child) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($child['child_id']); ?></td>
                    <td><?php echo htmlspecialchars($child['name']); ?></td>
                    <td><?php echo htmlspecialchars($child['date_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($child['gender'])); ?></td>
                    <td><?php echo htmlspecialchars($child['medical_history']); ?></td>
                    <td><?php echo htmlspecialchars($child['special_needs']); ?></td>
                    <td><?php echo htmlspecialchars($child['user_id']); ?></td>
                    <td data-label="Actions">
                            <!-- Update button -->
                            <button type="button" onclick="updateChild(<?php echo $child['child_id']; ?>)">Update</button>

                            <!-- Delete button -->
                            <button type="button" onclick="deleteChild(<?php echo $child['child_id']; ?>)">Delete</button>

                            
                        </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="7">No children found.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script src="../admin/admin_js/dashboard.js"></script>
</body>
</html>
