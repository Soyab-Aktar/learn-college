<?php
// admin/dashboard.php - View All Medicines
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('../config/db_config.php');

// Get search and filter parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Build SQL query
$sql = "SELECT * FROM medicines WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (medicine_name LIKE '%$search%' OR generic_name LIKE '%$search%')";
}

if ($filter === 'low_stock') {
    $sql .= " AND stock_quantity < 20";
} elseif ($filter === 'expiring_soon') {
    $sql .= " AND expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 90 DAY)";
} elseif ($filter === 'expired') {
    $sql .= " AND expiry_date < CURDATE()";
}

$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);

// Get statistics
$total_medicines = $conn->query("SELECT COUNT(*) as count FROM medicines")->fetch_assoc()['count'];
$low_stock = $conn->query("SELECT COUNT(*) as count FROM medicines WHERE stock_quantity < 20")->fetch_assoc()['count'];
$expiring_soon = $conn->query("SELECT COUNT(*) as count FROM medicines WHERE expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 90 DAY)")->fetch_assoc()['count'];
$expired = $conn->query("SELECT COUNT(*) as count FROM medicines WHERE expiry_date < CURDATE()")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MedCore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <i class="fas fa-heartbeat"></i>
                <h2>MedCore</h2>
                <p>Admin Panel</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="active">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="add_product.php">
                    <i class="fas fa-plus-circle"></i> Add Medicine
                </a>
                <a href="../index.php" target="_blank">
                    <i class="fas fa-globe"></i> View Website
                </a>
                <a href="logout.php" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <p><i class="fas fa-user-shield"></i></p>
                <p><strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
                <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <header class="content-header">
                <h1><i class="fas fa-pills"></i> Medicine Management</h1>
                <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            </header>
            
            <div class="table-controls">
                <form method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search medicines..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit"><i class="fas fa-search"></i> Search</button>
                </form>

                <div class="filter-buttons">
                    <a href="dashboard.php" class="filter-btn <?php echo $filter === 'all' ? 'active' : ''; ?>">
                        All (<?php echo $total_medicines; ?>)
                    </a>
                    <a href="?filter=low_stock" class="filter-btn <?php echo $filter === 'low_stock' ? 'active' : ''; ?>">
                        Low Stock (<?php echo $low_stock; ?>)
                    </a>
                    <a href="?filter=expiring_soon" class="filter-btn <?php echo $filter === 'expiring_soon' ? 'active' : ''; ?>">
                        Expiring Soon (<?php echo $expiring_soon; ?>)
                    </a>
                    <a href="?filter=expired" class="filter-btn <?php echo $filter === 'expired' ? 'active' : ''; ?>">
                        Expired (<?php echo $expired; ?>)
                    </a>
                </div>
            </div>

            
            <!-- Medicines Table -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Medicine Name</th>
                            <th>Generic Name</th>
                            <th>Form</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Expiry Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($medicine = $result->fetch_assoc()) {
                                // Check expiry status
                                $expiry_date = new DateTime($medicine['expiry_date']);
                                $today = new DateTime();
                                $interval = $today->diff($expiry_date);
                                $days_to_expiry = $interval->days;
                                
                                $is_expired = $expiry_date < $today;
                                $is_expiring_soon = $days_to_expiry <= 90 && !$is_expired;
                                $is_low_stock = $medicine['stock_quantity'] < 20;
                                
                                $row_class = '';
                                if ($is_expired) $row_class = 'row-expired';
                                elseif ($is_expiring_soon) $row_class = 'row-expiring';
                                elseif ($is_low_stock) $row_class = 'row-low-stock';
                                ?>
                                <tr class="<?php echo $row_class; ?>">
                                    <td><?php echo $medicine['id']; ?></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($medicine['image_url']); ?>" 
                                             alt="<?php echo htmlspecialchars($medicine['medicine_name']); ?>" 
                                             class="table-img">
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($medicine['medicine_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($medicine['generic_name']); ?></td>
                                    <td><?php echo ucfirst($medicine['dosage_form']); ?></td>
                                    <td>₹<?php echo number_format($medicine['price'], 2); ?></td>
                                    <td>
                                        <span class=" <?php echo $is_low_stock ?>">
                                            <?php echo $medicine['stock_quantity']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                        echo date('d-M-Y', strtotime($medicine['expiry_date']));
                                        ?>
                                    </td>
                                    <td class="action-buttons">
                                        <a href="edit_product.php?id=<?php echo $medicine['id']; ?>" 
                                           class="btn-icon btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_product.php?id=<?php echo $medicine['id']; ?>" 
                                           class="btn-icon btn-delete" title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this medicine?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No medicines found.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
