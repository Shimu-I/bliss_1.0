<?php
// Include the database configuration file
include 'config.php';

// Hardcoded child_id
$child_id = 4;

try {
    // Fetch child information
    $childStmt = $conn->prepare("SELECT * FROM child WHERE child_id = :child_id");
    $childStmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
    $childStmt->execute();
    $childInfo = $childStmt->fetch(PDO::FETCH_ASSOC);

    if (!$childInfo) {
        echo "Child not found.";
        exit;
    }

    // Fetch learning information
    $learningStmt = $conn->prepare("SELECT * FROM learning WHERE child_id = :child_id");
    $learningStmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
    $learningStmt->execute();
    $learningRecords = $learningStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch meal information
    $mealStmt = $conn->prepare("SELECT * FROM meal WHERE child_id = :child_id");
    $mealStmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
    $mealStmt->execute();
    $mealRecords = $mealStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch pickdrop information
    $pickdropStmt = $conn->prepare("SELECT * FROM pickdrop WHERE child_id = :child_id");
    $pickdropStmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
    $pickdropStmt->execute();
    $pickdropRecords = $pickdropStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch activity information
    $activityStmt = $conn->prepare("SELECT * FROM activity WHERE child_id = :child_id");
    $activityStmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
    $activityStmt->execute();
    $activityRecords = $activityStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
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
    <title>Child Profile</title>
    <link rel="stylesheet" href="assets/css/caregiver_profile.css">
    <link rel="stylesheet" href="assets/css/child_profile.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <h1 class="heading">Child Profile</h1>

    <div class="box2">
        <!-- Child Information -->
        <div class="box_box_1_1">
            <h2 class="section-heading">Child Information</h2>
            <div class="card-container_1">
                <div class="card_1">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($childInfo['name']); ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($childInfo['date_of_birth']); ?></p>
                    <p><strong>Gender:</strong> <?php echo ucfirst($childInfo['gender']); ?></p>
                    <p><strong>Medical History:</strong> <?php echo htmlspecialchars($childInfo['medical_history']); ?></p>
                    <p><strong>Special Needs:</strong> <?php echo htmlspecialchars($childInfo['special_needs']); ?></p>
                </div>
            </div>
        </div>

        <!-- Learning Records -->
        <div class="box_box_1">
            <h2 class="section-heading">Learning Records</h2>
            <div class="card-container">
                <?php if (!empty($learningRecords)) { ?>
                    <?php foreach ($learningRecords as $learning) { ?>
                        <div class="card">
                            <p><strong>Type:</strong> <?php echo htmlspecialchars($learning['learning_type']); ?></p>
                            <p><strong>Progress Notes:</strong> <?php echo htmlspecialchars($learning['progress_notes']); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($learning['date']); ?></p>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No learning records found.</p>
                <?php } ?>
            </div>
        </div>

        <!-- Meal Records -->
        <div class="box_box_1">
            <h2 class="section-heading">Meal Records</h2>
            <div class="card-container">
                <?php if (!empty($mealRecords)) { ?>
                    <?php foreach ($mealRecords as $meal) { ?>
                        <div class="card">
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($meal['meal_name']); ?></p>
                            <p><strong>Allergies:</strong> <?php echo htmlspecialchars($meal['allergies']) ?: 'N/A'; ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($meal['date']); ?></p>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No meal records found.</p>
                <?php } ?>
            </div>
        </div>

        <!-- Pick & Drop Records -->
        <div class="box_box_2">
            <h2 class="section-heading">Pick & Drop Records</h2>
            <div class="card-container">
                <?php if (!empty($pickdropRecords)) { ?>
                    <?php foreach ($pickdropRecords as $pickdrop) { ?>
                        <div class="card">
                            <p><strong>Time:</strong> <?php echo htmlspecialchars($pickdrop['time']); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($pickdrop['status']); ?></p>
                            <p><strong>Notification Status:</strong> <?php echo htmlspecialchars($pickdrop['notification_status']); ?></p>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No pick & drop records found.</p>
                <?php } ?>
            </div>
        </div>

        <!-- Activity Records -->
        <div class="box_box_2">
            <h2 class="section-heading">Activity Records</h2>
            <div class="card-container">
                <?php if (!empty($activityRecords)) { ?>
                    <?php foreach ($activityRecords as $activity) { ?>
                        <div class="card">
                            <p><strong>Type:</strong> <?php echo htmlspecialchars($activity['activity_type']); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($activity['description']); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($activity['date']); ?></p>
                            <p><strong>Time:</strong> <?php echo htmlspecialchars($activity['time']); ?></p>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No activity records found.</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>
