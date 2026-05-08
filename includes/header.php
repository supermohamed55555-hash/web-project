<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
// Set your project folder name here
$project_folder = "blood-app"; 
$base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$project_folder/";
$current_page = basename($_SERVER['PHP_SELF']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LifeStream - Connecting blood donors with patients instantly.">
    <title>LifeStream | Blood Donation Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-heartbeat"></i> LifeStream
            </a>
            
            <ul class="nav-links" id="navLinks">
                <li><a href="<?= $base_url ?>index.php" class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>">Home</a></li>
                <li><a href="<?= $base_url ?>search.php" class="nav-link <?= $current_page == 'search.php' ? 'active' : '' ?>">Find Donors</a></li>
                <li><a href="<?= $base_url ?>map-view.php" class="nav-link <?= $current_page == 'map-view.php' ? 'active' : '' ?>">Map</a></li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="<?= $base_url ?>dashboard.php" class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a></li>
                    <?php if ($_SESSION['user_role'] == 'admin'): ?>
                        <li><a href="<?= $base_url ?>admin/dashboard.php" class="nav-link" style="color: var(--accent);">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="<?= $base_url ?>logout.php" class="btn btn-outline" style="padding: 0.5rem 1.2rem;">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= $base_url ?>login.php" class="nav-link <?= $current_page == 'login.php' ? 'active' : '' ?>">Login</a></li>
                    <li><a href="<?= $base_url ?>register.php" class="btn btn-primary">Register</a></li>
                <?php endif; ?>
                
                <!-- Theme Toggle Button -->
                <li class="theme-toggle" id="themeToggle" title="Toggle Dark Mode">
                    <i class="fas fa-moon"></i>
                </li>
            </ul>
            
            <button class="nav-toggle" id="navToggle" aria-label="Toggle Navigation">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>
