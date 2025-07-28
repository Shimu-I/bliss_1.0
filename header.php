<?php
// Initialize $notifications to an empty array
$notifications = [];

// If you are fetching notifications from a session or database:
if (isset($_SESSION['notifications'])) {
    $notifications = $_SESSION['notifications'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Day Care Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/header.css">
</head>

<body>

    <header class="header">
        <a href="#" class="logo">
            <img src="assets/images/logo.png" alt="Bliss Daycare Logo"> Bliss
        </a>

        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="about_us.php">About</a>
            <a href="services.php">Services</a>
            <a href="caregivers.php">Caregivers</a>
            <a href="register.php">Registration</a>
        </nav>

        <div class="icons">
            <!-- Notification Icon with Badge -->
            <div class="notification-container">
<!--
      <span class="notification-badge" id="notification-count">
                    <?= count($notifications) ?>
                </span>      
-->

            </div>    
                        <!-- <div class="fas fa-user" id="login-btn"></div>


-->
            
            
        </div>
    </header>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationIcon = document.getElementById('notification-icon');
        const modal = document.getElementById('notification-modal');
        const overlay = document.getElementById('modal-overlay');
        const closeModal = modal.querySelector('.close');

        notificationIcon.addEventListener('click', function() {
            modal.style.display = 'block';
            overlay.style.display = 'block';
        });

        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
            overlay.style.display = 'none';
        });
        overlay.addEventListener('click', function() {
            modal.style.display = 'none';
            overlay.style.display = 'none';
        });
    });
    </script>

</body>

</html>