<?php
// Include the database connection
include 'config.php';

// Check if the caregiver is logged in by verifying session data
if (!isset($_SESSION['caregiver_id'])) {
    // If not logged in, redirect to the login page
    header('Location: caregiver_login.php');
    exit();
}

// Check if caregiver details are being fetched
if (isset($_POST['caregiver_fetch'])) {
    $caregiver_id = $_POST['caregiver_id'];
    $caregiver_id = filter_var($caregiver_id, FILTER_SANITIZE_NUMBER_INT);

    // Fetch caregiver details
    $select_caregiver = $conn->prepare("SELECT * FROM `caregivers` WHERE caregiver_id = ?");
    $select_caregiver->execute([$caregiver_id]);
    $fetch_caregiver = $select_caregiver->fetch(PDO::FETCH_ASSOC);

    if (!$fetch_caregiver) {
        echo "<script>alert('Caregiver not found!'); window.location.href = 'caregivers.php';</script>";
        exit();
    }

    // Fetch children assigned to the caregiver
    $select_children = $conn->prepare("SELECT * FROM `child` WHERE user_id = ?");
    $select_children->execute([$caregiver_id]);
} else {
    header('location:caregivers.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caregiver Profile</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets\css\caregiver_profile.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Caregiver Profile Section Starts -->
    <section class="caregiver-profile">
        <h1 class="heading">
        <span>Caregiver </span>    
        <span>Profile</span> 
         </h1>

        <div class="profile-details">
            <div class="caregiver-info" style="text-align: center;">
                <img src="<?= !empty($fetch_caregiver['profile_image']) ? 'uploaded_files/' . htmlspecialchars($fetch_caregiver['profile_image']) : 'assets/images/default-avatar.jpg'; ?>" 
                     alt="<?= htmlspecialchars($fetch_caregiver['name']); ?>" />

                <h2><?= htmlspecialchars($fetch_caregiver['name']); ?></h2>
                <p><strong>Qualification:</strong> <?= htmlspecialchars($fetch_caregiver['qualification']); ?></p>
                <p><strong>Experience:</strong> <?= htmlspecialchars($fetch_caregiver['experience']); ?> years</p>
                <p><strong>Special Training:</strong> <?= htmlspecialchars($fetch_caregiver['special_training'] ?: 'N/A'); ?></p>
            </div>
        </div>

        <!-- Assigned Children Section -->
        <div class="assigned-children">
            <h2>Assigned Children</h2>
            <?php if ($select_children->rowCount() > 0) { ?>
                <div class="children-list">
                    <?php while ($fetch_child = $select_children->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="child-card">
                            <h3><?= htmlspecialchars($fetch_child['name']); ?></h3>
                            <p><strong>Date of Birth:</strong> <?= htmlspecialchars($fetch_child['date_of_birth']); ?></p>
                            <p><strong>Gender:</strong> <?= ucfirst(htmlspecialchars($fetch_child['gender'])); ?></p>
                            <a href="child_profile.php?child_id=<?= htmlspecialchars($fetch_child['child_id']); ?>" class="btn">View Full Profile</a>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p>No children assigned to this caregiver yet.</p>
            <?php } ?>
        </div>
    </section>
    <!-- Caregiver Profile Section Ends -->

    <?php include 'footer.php'; ?>

</body>

</html>
