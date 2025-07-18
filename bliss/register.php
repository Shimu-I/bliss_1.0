<?php
include 'includes/db_connect.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone']);
    $role_id = (int)$_POST['role_id'];
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($role_id) || empty($password)) {
        echo "<p class='text-danger'>All fields are required!</p>";
    } elseif (strlen($password) < 8) {
        echo "<p class='text-danger'>Password must be at least 8 characters long!</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p class='text-danger'>Invalid email format!</p>";
    } else {
        // Check for duplicate email
        $sql_check = "SELECT user_id FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        if (!$stmt_check) {
            echo "<p class='text-danger'>Database error: " . $conn->error . "</p>";
        } else {
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            if ($stmt_check->get_result()->num_rows > 0) {
                echo "<p class='text-danger'>Email already registered!</p>";
            } else {
                $sql = "INSERT INTO users (role_id, first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    echo "<p class='text-danger'>Database error: " . $conn->error . "</p>";
                } else {
                    $stmt->bind_param("isssss", $role_id, $first_name, $last_name, $email, $phone, $password);
                    if ($stmt->execute()) {
                        echo "<p class='text-success'>Registration successful!</p>";
                    } else {
                        echo "<p class='text-danger'>Registration failed: " . $conn->error . "</p>";
                    }
                    $stmt->close();
                }
            }
            $stmt_check->close();
        }
    }
}
?>

<h2>Register</h2>
<form method="POST">
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="role_id" class="form-label">Role</label>
        <select name="role_id" class="form-control" required>
            <option value="1">Parent</option>
            <option value="2">Caregiver</option>
            <option value="3">Admin</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>

<?php include 'includes/footer.php'; ?>