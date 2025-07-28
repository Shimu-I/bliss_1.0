<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'config.php'; // Include your database connection file

// Initialize the message array for feedback
$message = [];

// Start session for managing user login state
session_start();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $contact_info = filter_input(INPUT_POST, 'contact_info', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $role = 'Parent'; // Default role is Parent


    // Check if email already exists in the database

    $check_email = $conn->prepare("SELECT user_id FROM users WHERE email = ?");

    $check_email->execute([$email]);
    $existing_user = $check_email->fetch();

    // If email already exists, show error message
    if ($existing_user) {
        $message[] = 'This email is already registered. Please use a different email address.';
    } else {


        // File upload handling
        if (!empty($_FILES['profile_image']['name'])) {
            $profile_image = $_FILES['profile_image']['name'];
            $target_dir = "uploaded_files/";
            $target_file = $target_dir . basename($profile_image);

            // Move uploaded file to the target directory
            if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $message[] = 'Failed to upload profile image.';
            }
        } else {
            $profile_image = null;
        }

        // Check if required fields are filled
        if ($name && $email && $contact_info && $password && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert user into the database
            $insert_user = $conn->prepare("INSERT INTO users (name, email, role, password, contact_info, profile_image) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $insert_user->execute([$name, $email, $role, $hashed_password, $contact_info, $profile_image]);

            if ($result) {
                $message[] = 'Registration successful! You are registering as a Parent.';
            } else {
                $message[] = 'Registration failed. Please try again.';
            }
        } else {
            $message[] = 'Please fill all required fields with valid data.';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets\css\caregiver_registration.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="wrapper">
        <!-- Registration Section -->
        <section class="caregiver_registration">
            <div class="row">
                <form action="" method="POST" class="caregiver_registration-form" enctype="multipart/form-data">
                    <h3>Register</h3>
                    <p class="role-info">You are registering as a Parent.</p>
                    <style>
                        .role-info {
                            text-align: center;
                            font-size: 1.2rem;
                            font-weight: bold;
                            color: #2c3e50;
                            /* Dark gray color */
                            margin-bottom: 1rem;
                            background-color: #f9f9f9;
                            /* Light background */
                            padding: 0.5rem;
                            border-radius: 5px;
                        }
                    </style>

                    <!-- Display Messages -->
                    <?php if (!empty($message)): ?>
                        <div class="message">
                            <?php foreach ($message as $msg): ?>
                                <p><?php echo htmlspecialchars($msg); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required class="input-box" maxlength="100">
                    </div>

                    <div>
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required class="input-box" maxlength="100">
                    </div>

                    <div>
                        <label for="contact_info">Contact Info</label>
                        <input type="text" id="contact_info" name="contact_info" required class="input-box" maxlength="15">
                    </div>

                    <div>
                        <label for="profile_image">Profile Image</label>
                        <input type="file" id="profile_image" name="profile_image" required class="input-box">
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required class="input-box" minlength="6">
                    </div>

                    <div>
                        <input type="submit" value="Register" class="inline-btn" name="submit">
                    </div>

                    <!-- Already Registered? -->
                    <div class="login-option">
                        <p>Already have an account?</p>
                        <a href="login.php" class="inline-btn">Log in now</a>
                    </div>
                </form>
            </div>
        </section>
    </div>



    <!-- Custom JS File -->
    <script src="assets/js/script.js"></script>
</body>

</html>