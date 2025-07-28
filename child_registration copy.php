<?php
include 'config.php'; // Configuration file

// Check if the user is logged in
session_start(); // Start the session to access session variables

if (empty($_SESSION['user_id'])) {
    // If user_id is not set, redirect to login page
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $child_name = filter_input(INPUT_POST, 'child_name', FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $medical_history = filter_input(INPUT_POST, 'medical_history', FILTER_SANITIZE_STRING);
    $special_needs = filter_input(INPUT_POST, 'special_needs', FILTER_SANITIZE_STRING);

    // Check if the child is already registered under the current parent (user)
    $select_child = $conn->prepare("SELECT * FROM `child` WHERE name = ? AND user_id = ?");
    $select_child->execute([$child_name, $user_id]);

    if ($select_child->rowCount() > 0) {
        $message[] = 'Child is already registered!';
    } else {
        // Insert child registration data into the child table
        $insert_child = $conn->prepare(
            "INSERT INTO `child` (name, date_of_birth, gender, medical_history, special_needs, user_id) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        if ($insert_child->execute([$child_name, $dob, $gender, $medical_history, $special_needs, $user_id])) {
            $message[] = 'Child registered successfully!';
        } else {
            $message[] = 'Registration failed. Please try again.';
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
    <title>Child Registration</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets\css\child_registration.css">
</head>

<body>

    <?php include 'header.php'; ?>

     

    <!-- Child Registration Section -->
    <section class="child-registration">

    <!-- Go Back Button -->
    <button id="go-back-btn" onclick="window.history.back()">Go Back</button>





        <div class="row">
            <div class="image">
                <img src="assets/images/reg.png" alt="Child Registration">
            </div>

            <form action="" method="POST" class="child-registration-form">
                <h3>Register Your Child</h3>


                <!-- Display Messages -->
                <?php if (!empty($message)): ?>
                    <div class="message">
                        <?php foreach ($message as $msg): ?>
                            <p><?php echo htmlspecialchars($msg); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Child's Full Name -->
                <div>
                    <label for="child_name">Child's Full Name</label>
                    <input type="text" id="child_name" name="child_name" required class="input-box">
                </div>

                <!-- Date of Birth and Gender -->
                <div class="dob---gender-row">
                    <div>
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" required class="input-box">
                    </div>
                    <div>
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="input-box">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>

                <!-- Medical History and Special Needs -->
                <div class="medical_history---special_needs-row">
                    <div>
                        <label for="medical_history">Medical History / Special Needs</label>
                        <textarea id="medical_history" name="medical_history" class="input-box"></textarea>
                    </div>
                    <div>
                        <label for="special_needs">Special Needs</label>
                        <select id="special_needs" name="special_needs">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                </div>

                <!-- Register Button -->
                <div>
                    <input type="submit" value="Register Child" class="inline-btn" name="submit">
                </div>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Custom JS File -->
    <script src="assets/js/script.js"></script>
</body>

</html>