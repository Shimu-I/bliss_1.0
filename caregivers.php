<?php
// Include the database connection
include 'config.php';

// Check if a user is logged in
$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caregivers</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets\css\caregivers.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Caregivers Section Starts -->
    <section class="caregivers">


        <h1 class="heading text-box"><span>Our </span> <span>Caregivers</span></h1>

        <!-- Search Form -->
        <form action="caregiver_search.php" method="post" class="search-caregivers">
            <input type="text"
                name="search_caregiver"
                maxlength="100"
                placeholder="Search caregiver..."
                required>
            <button type="submit" name="search_caregiver_btn" class="fas fa-search"></button>
        </form>

        <div class="box-container">

            <!-- Become a Caregiver Box -->
            <div class="box offer">
                <h3>Become a Caregiver</h3>
                <p>Join our trusted team of caregivers</p>
                <a href="caregiver_registration.php" class="inline-btn">Get Started</a>
                <a href="caregiver_login.php" class="inline-btn">Login</a>

            </div>

            <?php
            // Fetch caregivers from the database
            try {
                $select_caregivers = $conn->prepare("SELECT * FROM `caregivers`");
                $select_caregivers->execute();

                if ($select_caregivers->rowCount() > 0) {
                    while ($fetch_caregiver = $select_caregivers->fetch(PDO::FETCH_ASSOC)) {

                        // Assign caregiver details
                        $caregiver_id = $fetch_caregiver['caregiver_id'];
                        $name = $fetch_caregiver['name'];
                        $qualification = $fetch_caregiver['qualification'];
                        $experience = $fetch_caregiver['experience'];
                        $special_training = $fetch_caregiver['special_training'];
                        $profile_image = $fetch_caregiver['profile_image'];

                        // Set default image if no profile image exists
                        $profile_image_url = !empty($profile_image) ? 'uploaded_files/' . $profile_image : 'assets/images/default-avatar.jpg';
            ?>

                        <div class="box">
                            <div class="caregiver">
                                <div class="caregiver-img">
                                    <!-- Display caregiver profile image -->
                                    <img src="<?= htmlspecialchars($profile_image_url); ?>" alt="<?= htmlspecialchars($name); ?>" />
                                </div>
                                <div>
                                    <h3><?= htmlspecialchars($name); ?></h3>
                                    <span class="qualification"><?= htmlspecialchars($qualification); ?></span>
                                </div>
                            </div>
                            <p>Experience: <span><?= htmlspecialchars($experience); ?> years</span></p>
                            <p>Special Training: <span><?= htmlspecialchars($special_training); ?></span></p>
                            <form action="caregiver_profile.php" method="post">
                                <input type="hidden" name="caregiver_id" value="<?= htmlspecialchars($caregiver_id); ?>">


                                <!--<input type="submit" value="View Profile" name="caregiver_fetch" class="inline-btn">
                                 -->


                            </form>
                        </div>

            <?php
                    }
                } else {
                    echo '<p class="empty">No caregivers found!</p>';
                }
            } catch (PDOException $e) {
                echo '<p class="error">Error fetching caregivers: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>

        </div>
    </section>
    <!-- Caregivers Section Ends -->



</body>

</html>