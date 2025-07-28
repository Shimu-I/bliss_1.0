<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

     <!-- Font Awesome CDN -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../admin/admin_css/sidebar.css">
    <!-- Iconscout CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="../admin/admin_js/dashboard.js" defer></script>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div><i class="uil uil-bars sidebar-toggle"></i></div>
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
                <li><a href="admin_parents.php"><i class="fa fa-users"></i><span class="link-name">Parents</span></a></li>
                <li><a href="admin_caregivers.php"><i class="fa fa-hands-helping"></i><span class="link-name">Caregivers</span></a></li>
                <li><a href="admin_children.php"><i class="fa fa-child"></i><span class="link-name">Children</span></a></li>
                <li><a href="admin_payments.php"><i class="fa fa-credit-card"></i><span class="link-name">Payments</span></a></li>
            </ul>

            <ul class="logout-mode">
                <li><a href="#"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a></li>
                <li class="mode">
                    <a href="#"><i class="uil uil-moon"></i><span class="link-name">Dark Mode</span></a>
                    <div class="mode-toggle"><span class="switch"></span></div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
        </div>
        <!-- Dashboard content goes here -->
    </section>
</body>

</html>
