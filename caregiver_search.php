<?php
// Include the database connection
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Caregiver</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets\css\caregiver_search.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="caregivers">

        <h1 class="heading text-box"><span>Our <span>Caregivers</span></h1>


        <!-- Search Form -->
        <form action="caregiver_search.php" method="post" class="search-caregivers">
            <input
                type="text"
                name="search_caregiver"
                placeholder="Search caregiver by name..."
                maxlength="100"
                value="<?= isset($_POST['search_caregiver']) ? htmlspecialchars($_POST['search_caregiver']) : ''; ?>"
                required>
            <button type="submit" name="search_caregiver_btn" class="fas fa-search"></button>
        </form>

        <!-- Caregivers List -->
        <div class="box-container">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_caregiver_btn'])) {
                // Sanitize user input
                $search_query = htmlspecialchars($_POST['search_caregiver']);

                try {
                    // Fetch caregivers matching the search query
                    if (!empty($search_query)) {
                        $stmt = $conn->prepare("
                        SELECT * 
                        FROM `caregivers` 
                        WHERE `name` LIKE :query
                    ");
                        $stmt->execute([':query' => $search_query . '%']);
                    } else {
                        $stmt = $conn->prepare("SELECT * FROM `caregivers`");
                        $stmt->execute();
                    }

                    // Generate caregiver cards
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // Get the profile image and set default if not found
                            $profile_image = $row['profile_image'];
                            $profile_image_url = !empty($profile_image) ? 'uploaded_files/' . $profile_image : 'assets/images/default-avatar.jpg';
            ?>
                            <div class="box">
                                <div class="caregiver">
                                    <div class="caregiver-img">
                                        <!-- Display caregiver profile image -->
                                        <img src="<?= htmlspecialchars($profile_image_url); ?>" alt="<?= htmlspecialchars($row['name']); ?>" />
                                    </div>
                                    <div>
                                        <h3><?= htmlspecialchars($row['name']); ?></h3>
                                        <span class="qualification"><?= htmlspecialchars($row['qualification']); ?></span>
                                    </div>
                                </div>
                                <p>Experience: <span><?= htmlspecialchars($row['experience']); ?> years</span></p>
                                <p>Special Training: <span><?= htmlspecialchars($row['special_training']); ?></span></p>
                                <form action="caregiver_profile.php" method="post">
                                    <input type="hidden" name="caregiver_id" value="<?= htmlspecialchars($caregiver_id); ?>">
                                    <input type="submit" value="View Profile" name="caregiver_fetch" class="inline-btn">
                                </form>
                            </div>

                        <?php
                        }
                    } else {
                        echo '<p class="no-results">No caregivers found matching your search!</p>';
                    }
                } catch (Exception $e) {
                    echo '<p class="error">Error fetching caregivers: ' . $e->getMessage() . '</p>';
                }
            } else {
                // Show all caregivers by default
                try {
                    $stmt = $conn->prepare("SELECT * FROM `caregivers`");
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // Get the profile image and set default if not found
                            $profile_image = $row['profile_image'];
                            $profile_image_url = !empty($profile_image) ? 'uploaded_files/' . $profile_image : 'assets/images/default-avatar.jpg';
                        ?>
                            <div class="box">
                                <div class="caregiver">
                                    <div class="caregiver-img">
                                        <!-- Display caregiver profile image -->
                                        <img src="<?= htmlspecialchars($profile_image_url); ?>" alt="<?= htmlspecialchars($row['name']); ?>" />
                                    </div>
                                    <div>
                                        <h3><?= htmlspecialchars($row['name']); ?></h3>
                                        <span class="qualification"><?= htmlspecialchars($row['qualification']); ?></span>
                                    </div>
                                </div>
                                <p>Experience: <span><?= htmlspecialchars($row['experience']); ?> years</span></p>
                                <p>Special Training: <span><?= htmlspecialchars($row['special_training']); ?></span></p>
                                <form action="caregiver_profile.php" method="post">
                                    <input type="hidden" name="caregiver_id" value="<?= htmlspecialchars($row['caregiver_id']); ?>">
                                    <input type="submit" value="View Profile" name="caregiver_fetch" class="inline-btn">
                                </form>
                            </div>

            <?php
                        }
                    } else {
                        echo '<p class="empty">No caregivers found!</p>';
                    }
                } catch (Exception $e) {
                    echo '<p class="error">Error fetching caregivers: ' . $e->getMessage() . '</p>';
                }
            }
            ?>
        </div>
    </section>



</body>

</html>