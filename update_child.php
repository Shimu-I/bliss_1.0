<?php
session_start();
require_once 'config.php';

// Get the child_id and the field to update from the URL
$child_id = $_GET['child_id'] ?? null;
$field = $_GET['field'] ?? null;
if (!$child_id || !$field) {
    echo "Invalid request.";
    exit();
}

// Fetch the current data for the child
$query = "SELECT * FROM child WHERE child_id = :child_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
$stmt->execute();
$child = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$child) {
    echo "Child not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission and update only the specific field
    if ($field === 'name') {
        $updated_name = $_POST['name'];

        // Update query
        $update_query = "UPDATE child SET name = :name WHERE child_id = :child_id";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bindParam(':name', $updated_name);
        $update_stmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
        $update_stmt->execute();

        // Redirect back to parent profile page or show success message
        header("Location: parent_profile.php");
        exit();
    }
    // You can add more conditions here if you want to handle other fields like date_of_birth, caregiver, etc.
}
?>

<!-- Display the form for updating the selected field -->
<form method="POST">
    <?php if ($field === 'name') { ?>
        <label for="name">Child Name</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($child['name']); ?>" required>

        <button type="submit">Update Name</button>
    <?php } ?>
    <!-- You can add more conditions here to display other fields if necessary -->
</form>
