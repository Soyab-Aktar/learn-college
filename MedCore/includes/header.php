<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? $_SESSION['username'] : '';
$is_admin = $is_logged_in && $_SESSION['role'] === 'admin';

// Determine base path for links
$base_path = '';
$current_file = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));

// Set base path based on current directory
if ($current_dir === 'admin' || $current_dir === 'user') {
    $base_path = '../';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedCore - Your Trusted Medicine Store</title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/user.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="nav-brand">
                <a href="<?php echo $base_path; ?>index.php">
                    <i class="fas fa-heartbeat"></i>
                    <h1>MedCore</h1>
                </a>
            </div>
            
            <ul class="nav-links">
                <li><a href="<?php echo $base_path; ?>index.php"><i class="fas fa-home"></i> Home</a></li>
                
                <?php if ($is_admin): ?>
                    <!-- Admin Navigation -->
                    <li><a href="<?php echo $base_path; ?>admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="<?php echo $base_path; ?>admin/add_product.php"><i class="fas fa-plus-circle"></i> Add Medicine</a></li>
                    <!-- <li><a href="<?php echo $base_path; ?>admin/manage_orders.php"><i class="fas fa-shopping-bag"></i> Orders</a></li> -->
                <?php elseif ($is_logged_in): ?>
                    <!-- User Navigation -->
                    <li><a href="<?php echo $base_path; ?>user/products.php"><i class="fas fa-pills"></i> Medicines</a></li>
                    <li><a href="<?php echo $base_path; ?>user/cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                    <li><a href="<?php echo $base_path; ?>user/order_history.php"><i class="fas fa-history"></i> Orders</a></li>
                <?php else: ?>
                    <!-- Guest Navigation -->
                    <li><a href="<?php echo $base_path; ?>user/products.php"><i class="fas fa-pills"></i> Browse Medicines</a></li>
                <?php endif; ?>
                
                <?php if ($is_logged_in): ?>
                    <li class="user-menu">
                        <span><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($username); ?></span>
                        <a href="<?php echo $base_path; ?>user/logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                <?php else: ?>
                    <li><a href="<?php echo $base_path; ?>user/login.php" class="btn-login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                    <li><a href="<?php echo $base_path; ?>user/register.php" class="btn-register">Register</a></li>
                <?php endif; ?>
            </ul>
            
            <!-- Mobile Menu Toggle -->
            <div class="mobile-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </header>
    
    <main class="main-content">
