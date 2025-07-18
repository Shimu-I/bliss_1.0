<?php
include 'includes/db_connect.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        echo "<p class='text-danger'>Email and password are required!</p>";
    } else {
        $sql = "SELECT user_id, role_id, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "<p class='text-danger'>Database error: " . $conn->error . "</p>";
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && $password === $user['password']) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role_id'] = $user['role_id'];
                header("Location: dashboard.php");
                exit;
            } else {
                // Log failed login attempt
                $sql_log = "INSERT INTO audit_logs (user_id, action, description) VALUES (NULL, 'Failed Login', 'Failed login attempt for email: ?')";
                $stmt_log = $conn->prepare($sql_log);
                $stmt_log->bind_param("s", $email);
                $stmt_log->execute();
                echo "<p class='text-danger'>Invalid credentials!</p>";
            }
            $stmt->close();
        }
    }
}
?>

<h2>Login</h2>
<form method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php include 'includes/footer.php'; ?>