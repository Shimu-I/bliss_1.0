<?php
// Include the database configuration file
include '../config.php';

try {
    // Fetch all parents from the users table where role is 'Parent'
    $stmt = $conn->prepare("SELECT * FROM users WHERE role = 'Parent'");
    $stmt->execute();
    $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../admin/admin_css/parents.css"> <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="../admin/admin_css/main.css">
    
    <title>Parents Table</title>
</head>

<body>

<button id="go-back-btn" onclick="window.history.back()">Go Back</button>



    <div>
        <h1 class="header">Parents List</h1>
    </div>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>

                <th>Contact Info</th>
                <th>Profile Image</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($parents)) { ?>
                <?php foreach ($parents as $parent) { ?>
                    <tr>
                        <td data-label="User ID"><?php echo $parent['user_id']; ?></td>
                        <td data-label="Name"><?php echo $parent['name']; ?></td>
                        <td data-label="Email"><?php echo $parent['email']; ?></td>
                        <td data-label="Role"><?php echo $parent['role']; ?></td>
                        <td data-label="Contact Info"><?php echo $parent['contact_info']; ?></td>
                        <td data-label="Profile Image">
                            <?php if ($parent['profile_image']) { ?>
                                <img src="../uploaded_files/<?php echo $parent['profile_image']; ?>" alt="Profile Image" height="50">
                            <?php } else { ?>
                                No Image
                            <?php } ?>
                        </td>
                        <td data-label="Actions">
                            <button type="button" onclick="editParent(<?php echo $parent['user_id']; ?>)">Edit</button>
                            <button type="button" onclick="deleteParent(<?php echo $parent['user_id']; ?>)">Delete</button>
                        </td>

                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6">No parents found.</td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
</body>

</html>