<?php
// Start the session
session_start();

if (isset($_GET['logout'])) {
    // Destroy the session and redirect to login page
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: /login.php"); // Redirect to login page
    exit(); // Make sure no further code is executed after the redirect
}

// Include the database configuration file
include '../config.php';

// Get the admin's user ID from the session (make sure admin is logged in)
// $admin_id = $_SESSION['user_id']; // Assuming user_id is stored in session when logged in

try {
    // Fetch the total number of parents
    $stmt_total_parents = $conn->prepare("SELECT COUNT(user_id) as total_parents FROM users WHERE role = 'Parent'");
    $stmt_total_parents->execute();
    $total_parents_data = $stmt_total_parents->fetch(PDO::FETCH_ASSOC);

    // Fetch the total number of caregivers
    $stmt_total_caregivers = $conn->prepare("SELECT COUNT(caregiver_id) as total_caregivers FROM caregivers");
    $stmt_total_caregivers->execute();
    $total_caregivers_data = $stmt_total_caregivers->fetch(PDO::FETCH_ASSOC);

    // Fetch the total number of children
    $stmt_total_children = $conn->prepare("SELECT COUNT(child_id) as total_children FROM child");
    $stmt_total_children->execute();
    $total_children_data = $stmt_total_children->fetch(PDO::FETCH_ASSOC);

    // Fetch the total number of pending bill payments
    $stmt_total_pending_bills = $conn->prepare("SELECT COUNT(bill_id) as total_pending_bills FROM bill_payment WHERE payment_status = 'Pending'");
    $stmt_total_pending_bills->execute();
    $total_pending_bills_data = $stmt_total_pending_bills->fetch(PDO::FETCH_ASSOC);

    // Fetch the total number of payments
    $stmt_total_payments = $conn->prepare("SELECT COUNT(bill_id) as total_payments FROM bill_payment");
    $stmt_total_payments->execute();
    $total_payments_data = $stmt_total_payments->fetch(PDO::FETCH_ASSOC);

    // Total paid bill from bill payment table
    $stmt_total_paid_amount = $conn->prepare("SELECT SUM(total_amount) as total_paid_amount FROM bill_payment WHERE payment_status = 'Paid'");
    $stmt_total_paid_amount->execute();
    $total_paid_amount_data = $stmt_total_paid_amount->fetch(PDO::FETCH_ASSOC);
    $total_paid_amount = $total_paid_amount_data['total_paid_amount'] ?? 0; // Default to 0 if no rows are returned

} catch (PDOException $e) {
    // Handle PDO exception (error)
    echo "Error: " . $e->getMessage();
    exit;
}

// Close the connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS for Admin -->
    <link rel="stylesheet" href="../admin/admin_css/dashboard.css">

    <!-- Iconscout CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

</head>

<body>

    <!-- Admin Sidebar Navigation -->
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="../assets/images/admin.png" alt="Logo">
            </div>
            <div>
                <span class="logo_name">Admin Dashboard</span>
            </div>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="#"><i class="fa fa-home"></i><span class="link-name">Dashboard</span></a></li>

                <li><a href="admin_parents.php"><i class="fa fa-users"></i><span class="link-name">Parents (<?php echo $total_parents_data['total_parents']; ?>)</span></a></li>

                <li><a href="admin_caregivers.php"><i class="fa fa-hands-helping"></i><span class="link-name">Caregivers (<?php echo $total_caregivers_data['total_caregivers']; ?>)</span></a></li>

                <li><a href="admin_children.php"><i class="fa fa-child"></i><span class="link-name">Children (<?php echo $total_children_data['total_children']; ?>)</span></a></li>

                <li><a href="admin_payments.php"><i class="fa fa-credit-card"></i><span class="link-name">Payments (<?php echo $total_payments_data['total_payments']; ?>)</span></a></li>
            </ul>

            <ul class="logout-mode">
                <li><a href="/login.php"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a></li>
                <li class="mode">
                    <a href="#"><i class="uil uil-moon"></i><span class="link-name">Dark Mode</span></a>
                    <div class="mode-toggle"><span class="switch"></span></div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Dashboard Content -->
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div class="boxes">
                    <!-- Total parents -->
                    <div class="box box">
                        <i class="fa fa-users"></i>
                        <span class="text">Total Parents</span>
                        <span class="number">
                            <?php echo $total_parents_data['total_parents']; ?>
                        </span>
                    </div>

                    <!-- Total Caregivers -->
                    <div class="box box">
                        <i class="fa fa-hands-helping"></i>
                        <span class="text">Total Caregivers</span>
                        <span class="number">
                            <?php echo $total_caregivers_data['total_caregivers']; ?>
                        </span>
                    </div>

                    <!-- Total Children Box -->
                    <div class="box box">
                        <i class="fa fa-child"></i>
                        <span class="text">Total Children</span>
                        <span class="number">
                            <?php echo $total_children_data['total_children']; ?>
                        </span>
                    </div>

                    <!-- Unpaid accounts -->
                    <div class="box box">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="text">Unpaid Accounts</span>
                        <span class="number">
                            <?php echo $total_pending_bills_data['total_pending_bills']; ?>
                        </span>
                    </div>

                    <!-- Total Payments -->
                    <div class="box box">
                        <i class="fas fa-dollar-sign"></i>
                        <span class="text">Paid Account</span>
                        <span class="number">
                            <?php echo $total_payments_data['total_payments']; ?>
                        </span>
                    </div>

                    <div class="box box">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span class="text">Total Paid Amount </span>
                        <span class="number">
                            <?php echo number_format($total_paid_amount, 2); ?> <!-- Format to 2 decimal places -->
                        </span>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <script src="../admin/admin_js/dashboard.js"></script>
</body>

</html>
