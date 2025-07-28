<?php
// Initialize session
session_start();

// Include the database configuration file
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission for login
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prevent SQL Injection using prepared statements
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
        $stmt->execute([':email' => $email, ':password' => $password]);

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin/admin_dashboard.php");
                exit;
            } elseif ($user['role'] == 'parent') {
                header("Location: parent_dashboard.php");
                exit;
            } elseif ($user['role'] == 'caregiver') {
                header("Location: caregiver_dashboard.php");
                exit;
            }
        } else {
            echo "Invalid login credentials.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
    <!-- Home Section -->
    <section class="home" id="home">
        <div class="content">
            <h3 class="welcome-text" data-aos="fade-right"
                data-aos-offset="300"
                data-aos-easing="ease-in-sine">
                Welcome to our <span>Day Care</span>
            </h3>
            <p data-aos="fade-right"
                data-aos-offset="300"
                data-aos-easing="ease-in-sine">
                We’re here to provide a safe, joyful, and nurturing space where your child can thrive.<br>
                Let’s create a world of smiles and cherished memories together!
            </p>
            <a href=" register.php" class="btn">Register Today</a>
        </div>
        <div class="image" data-aos="zoom-in" data-aos-duration="2000">
            <img src="assets/images/h1.png" alt="">
        </div>
    </section>



    <!-- AOS JS (must be placed before </body>) -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1200, // Default animation duration
            once: true // Animation runs only once
        });
    </script>
</body>

</html>