<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include your database connection file
include 'config.php';

// Start the session for managing user login state
session_start();

// Initialize the message array for feedback
$message = [];

// Function to handle a successful login
function handleSuccessfulLogin($caregiver)
{
    // Set session variables
    $_SESSION['caregiver_id'] = $caregiver['caregiver_id'];
    $_SESSION['name'] = $caregiver['name'];
    $_SESSION['email'] = $caregiver['email'];
    $_SESSION['qualification'] = $caregiver['qualification'];
    $_SESSION['experience'] = $caregiver['experience'];
    $_SESSION['special_training'] = $caregiver['special_training'];
    $_SESSION['profile_image'] = $caregiver['profile_image'];

    // Debugging statement
    echo "Redirecting to caregiver profile page...";

    // Redirect to the caregiver profile page
    header("Location: caregiver_profile.php");

    // Prevent browser caching to avoid returning to the login page
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    exit;
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

    // Ensure email and password are provided and valid
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL) && $password) {
        // Check if the caregiver exists in the database
        $select_caregiver = $conn->prepare("SELECT * FROM caregivers WHERE email = ?");
        $select_caregiver->execute([$email]);

        if ($select_caregiver->rowCount() > 0) {
            $caregiver = $select_caregiver->fetch(PDO::FETCH_ASSOC);
            $storedPassword = $caregiver['password'];

            // Check if the stored password is hashed
            if (password_verify($password, $storedPassword)) {
                // Password matches (hashed)
                handleSuccessfulLogin($caregiver);
            } elseif ($storedPassword === $password) {
                // Password matches (plain text)
                // Re-hash the password and update the database
                $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updatePassword = $conn->prepare("UPDATE caregivers SET password = ? WHERE email = ?");
                $updatePassword->execute([$newHashedPassword, $email]);

                handleSuccessfulLogin($caregiver);
            } else {
                $message[] = 'Incorrect password. Please try again.';
            }
        } else {
            $message[] = 'No caregiver found with this email address.';
        }
    } else {
        $message[] = 'Please enter a valid email and password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caregiver Login</title>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets/css/caregiver_registration.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="wrapper">
        <!-- Login Section -->
        <section class="caregiver_registration">
            <div class="row">
                <form action="" method="POST" class="caregiver_registration-form">
                    <h3>Caregiver Login</h3>
                    <!-- Display Messages -->
                    <?php if (!empty($message)): ?>
                        <div class="message">
                            <?php foreach ($message as $msg): ?>
                                <p><?php echo htmlspecialchars($msg); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required class="input-box" maxlength="100">
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required class="input-box" minlength="6">
                    </div>
                    <div>
                        <input type="submit" value="Login" class="inline-btn" name="submit">
                    </div>
                    <!-- Need an Account? -->
                    <div class="login-option">
                        <p>Don't have an account?</p>
                        <a href="caregiver_registration.php" class="inline-btn">Sign up now</a>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Custom JS File -->
    <script src="assets/js/script.js"></script>
</body>

</html>