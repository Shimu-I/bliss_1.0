login.php
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
    echo "Form submitted"; // Debugging message

    // Sanitize and validate input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)); // Trim password to avoid extra spaces
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING); // Get the role from the form (optional)

    // Check if both email and password are provided and email is valid
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL) && $password && $role) {
        // Prepare the query to check if the user exists in the database
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->execute([$email]);

        // If a user is found with the provided email
        if ($select_user->rowCount() > 0) {
            $user = $select_user->fetch(PDO::FETCH_ASSOC);

            // Check if the stored password is hashed
            if (password_verify($password, $user['password'])) {
                // Password is hashed and correct
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];

                // Redirect the user based on their role
                switch ($user['role']) {
                    case 'Parent':
                        header("Location: parent_profile.php");
                        exit;
                    case 'Admin':
                        header("Location: admin/admin_dashboard.php");
                        exit;
                    case 'Caregiver':
                        header("Location: caregiver_profile.php");
                        exit;
                    default:
                        $message[] = 'Unexpected role.';
                        break;
                }
            } else {
                // If password is plain text, compare directly
                if ($password === $user['password']) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect based on role
                    switch ($user['role']) {
                        case 'Parent':
                            header("Location: parent_profile.php");
                            exit;
                        case 'Admin':
                            header("Location: admin/admin_dashboard.php");
                            exit;
                        case 'Caregiver':
                            header("Location: caregiver_profile.php");
                            exit;
                        default:
                            $message[] = 'Unexpected role.';
                            break;
                    }
                } else {
                    $message[] = 'Incorrect password. Please try again.';
                }
            }
        } else {
            $message[] = 'No user found with this email address.';
        }
    } else {
        $message[] = 'Please enter a valid email, password, and role.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets\css\caregiver_registration.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="wrapper">
        <!-- Login Section -->
        <section class="caregiver_registration">
            <div class="row">
                <form action="" method="POST" class="caregiver_registration-form">
                    <h3>Login</h3>

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

                    <!-- Role Selection Field -->
                    <div>
                        <label for="role">Role</label>
                        <select id="role" name="role" required class="input-box">
                            <option value="Parent">Parent</option>
                            <option value="Admin">Admin</option>

                        </select>
                    </div>

                    <div>
                        <input type="submit" value="Login" class="inline-btn" name="submit">
                    </div>

                    <!-- Need an Account? -->
                    <div class="login-option">
                        <p>Don't have an account?</p>
                        <a href="register.php" class="inline-btn">Sign up now</a>
                    </div>
                </form>
            </div>
        </section>
    </div>



    <!-- Custom JS File -->
    <script src="assets/js/script.js"></script>
</body>

</html>