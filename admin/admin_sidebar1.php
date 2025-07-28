<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link rel="stylesheet" href="sidebar1.css">
</head>
<body>
    <nav id="sidebar">
        <div class="logo-name">
            <div class="logo-image">
                <img src="path/to/logo.png" alt="Logo">
            </div>
            <span class="logo_name">Your Logo</span>
        </div>
        <ul class="menu-items nav-links">
            <li><a href="#"><i class="icon-class"></i><span class="link-name">Home</span></a></li>
            <li><a href="#"><i class="icon-class"></i><span class="link-name">Profile</span></a></li>
            <li><a href="#"><i class="icon-class"></i><span class="link-name">Messages</span></a></li>
            <!-- Add more menu items here -->
        </ul>
        <ul class="menu-items logout-mode">
            <li class="mode">
                <i class="icon-class"></i>
                <span class="link-name">Dark Mode</span>
                <div class="mode-toggle">
                    <span class="switch"></span>
                </div>
            </li>
            <li><a href="#"><i class="icon-class"></i><span class="link-name">Logout</span></a></li>
        </ul>
    </nav>
    <div class="dashboard">
        <div class="top">
            <i class="sidebar-toggle">☰</i>
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class="search-icon">🔍</i>
            </div>
        </div>
        <!-- Add the rest of your dashboard content here -->
    </div>
    <script src="sidebar.js"></script>
</body>
</html>
