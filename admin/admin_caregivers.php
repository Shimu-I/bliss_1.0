<?php
// Include the database configuration file
include '../config.php';

try {
    // Fetch all caregivers from the caregivers table
    $stmt = $conn->prepare("SELECT * FROM caregivers");
    $stmt->execute();
    $caregivers = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../admin/admin_css/parents.css">
    <title>Caregivers Table</title>
</head>

<body>

    <button id="go-back-btn" onclick="window.history.back()">Go Back</button>
    <h1>Caregivers List</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Caregiver ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Qualification</th>
                <th>Experience</th>
                <th>Special Training</th>
                <th>Profile Image</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($caregivers)) { ?>
                <?php foreach ($caregivers as $caregiver) { ?>
                    <tr>
                        <td><?php echo $caregiver['caregiver_id']; ?></td>
                        <td><?php echo $caregiver['name']; ?></td>
                        <td><?php echo $caregiver['email']; ?></td>
                        <td><?php echo $caregiver['qualification']; ?></td>
                        <td><?php echo $caregiver['experience']; ?> years</td>
                        <td><?php echo $caregiver['special_training']; ?></td>
                        <td>
                            <?php if ($caregiver['profile_image']) { ?>
                                <img src="../uploaded_files/<?php echo $caregiver['profile_image']; ?>" alt="Profile Image" height="50">
                            <?php } else { ?>
                                No Image
                            <?php } ?>
                        </td>
                        <td data-label="Actions">
                            <!-- Update button -->
                            <button type="button" onclick="updateCaregiver(<?php echo $caregiver['caregiver_id']; ?>)">Update</button>

                            <!-- Delete button -->
                            <button type="button" onclick="deleteCaregiver(<?php echo $caregiver['caregiver_id']; ?>)">Delete</button>

                            
                        </td>

                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="8">No caregivers found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script src="../admin/admin_js/dashboard.js"></script>
</body>

</html>