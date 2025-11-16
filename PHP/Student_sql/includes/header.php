<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Student Management System'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <h2>📚 Student Management</h2>
            </div>
            <ul class="nav-links">
                <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Dashboard</a></li>
                <li><a href="create.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'create.php' ? 'active' : ''; ?>">Add Student</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Main Content Container -->
    <div class="main-container">
