<?php
include 'config.php'; // Configuration file

// Retrieve the user ID from cookies
$user_id = $_COOKIE['user_id'] ?? '';

$message = []; // Initialize the message array for feedback

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Sanitize and validate input
   $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
   $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
   $qualification = filter_input(INPUT_POST, 'qualification', FILTER_SANITIZE_STRING);
   $experience = filter_input(INPUT_POST, 'experience', FILTER_SANITIZE_NUMBER_INT);
   $special_training = filter_input(INPUT_POST, 'special_training', FILTER_SANITIZE_STRING);

   // Handle profile image upload
   if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
      $image_name = $_FILES['profile_image']['name'];
      $image_tmp_name = $_FILES['profile_image']['tmp_name'];
      $image_size = $_FILES['profile_image']['size'];
      $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
      $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];

      // Validate image size and type
      if ($image_size > 5000000) {
         $message[] = 'Image size is too large. Maximum size is 5MB.';
      } elseif (!in_array($image_extension, $valid_extensions)) {
         $message[] = 'Invalid image format. Please upload a JPG, JPEG, PNG, or GIF.';
      } else {
         // Generate a unique file name for the image
         $new_image_name = uniqid('profile_', true) . '.' . $image_extension;
         $image_upload_path = 'uploaded_files/' . $new_image_name;

         // Move the uploaded file to the "uploaded_files" directory
         if (move_uploaded_file($image_tmp_name, $image_upload_path)) {
            // Image uploaded successfully
         } else {
            $message[] = 'Failed to upload image. Please try again.';
         }
      }
   } else {
      $message[] = 'Please select a profile image.';
   }

   // Validate other fields
   if ($name && $email && filter_var($email, FILTER_VALIDATE_EMAIL) && $password && $qualification && $experience && $special_training) {
      // Check if the caregiver already exists
      $select_caregiver = $conn->prepare("SELECT * FROM `caregivers` WHERE email = ?");
      $select_caregiver->execute([$email]);

      if ($select_caregiver->rowCount() > 0) {
         $message[] = 'Caregiver with this email is already registered!';
      } else {
         // Hash the password before storing it
         $hashed_password = password_hash($password, PASSWORD_DEFAULT);

         // Insert caregiver registration data into the caregiver table
         $insert_caregiver = $conn->prepare(
            "INSERT INTO `caregivers` (name, email, password, qualification, experience, special_training, profile_image) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
         );
         $inserted = $insert_caregiver->execute([$name, $email, $hashed_password, $qualification, $experience, $special_training, $new_image_name]);

         if ($inserted) {
            $message[] = 'Caregiver registered successfully!';
         } else {
            $message[] = 'Registration failed. Please try again.';
         }
      }
   } else {
      $message[] = 'Please fill in all the fields correctly.';
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Caregiver Registration</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="assets\css\caregiver_registration.css">
</head>

<body>

   <?php include 'header.php'; ?>

   <div class="wrapper">
      <!-- Caregiver Registration Section -->
      <section class="caregiver_registration">
         <div class="row">
            <form action="" method="POST" class="caregiver_registration-form" enctype="multipart/form-data">
               <h3>Register a Caregiver</h3>

               <!-- Display Messages -->
               <?php if (!empty($message)): ?>
                  <div class="messages">
                     <?php foreach ($message as $msg): ?>
                        <p><?php echo htmlspecialchars($msg); ?></p>
                     <?php endforeach; ?>
                  </div>
               <?php endif; ?>

               <div>
                  <label for="name">Caregiver's Full Name</label>
                  <input type="text" id="name" name="name" required class="input-box" maxlength="100">
               </div>

               <div>
                  <label for="email">Email Address</label>
                  <input type="email" id="email" name="email" required class="input-box" maxlength="100">
               </div>

               <div>
                  <label for="password">Password</label>
                  <input type="password" id="password" name="password" required class="input-box" minlength="6">
               </div>

               <div>
                  <label for="qualification">Qualification</label>
                  <input type="text" id="qualification" name="qualification" required class="input-box" maxlength="255">
               </div>

               <div>
                  <label for="experience">Years of Experience</label>
                  <input type="number" id="experience" name="experience" required class="input-box" min="0">
               </div>

               <div>
                  <label for="special_training">Special Training</label>
                  <textarea id="special_training" name="special_training" class="input-box" maxlength="255"></textarea>
               </div>

               <div>
                  <label for="profile_image">Profile Image</label>
                  <input type="file" id="profile_image" name="profile_image" accept="image/*" required class="input-box">
               </div>

               <div>
                  <input type="submit" value="Register Caregiver" class="inline-btn" name="submit">
               </div>

               <!-- Already a Caregiver? -->
               <div class="login-option">
                  <p>Already a caregiver?</p>
                  <a href="caregiver_login.php" class="inline-btn">Log in now</a>
               </div>
            </form>
         </div>
      </section>
   </div>



   <!-- Custom JS File -->
   <script src="assets/js/script.js"></script>
</body>

</html>