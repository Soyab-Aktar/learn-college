<?php
// user/products.php - Browse All Medicines
session_start();
include('../config/db_config.php');

// Get search and category filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Build query
$sql = "SELECT * FROM medicines WHERE stock_quantity > 0 AND expiry_date > CURDATE()";

if (!empty($search)) {
    $sql .= " AND (medicine_name LIKE '%$search%' OR generic_name LIKE '%$search%')";
}

if ($category !== 'all') {
    $sql .= " AND dosage_form = '$category'";
}

$sql .= " ORDER BY medicine_name ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Medicines - MedCore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    
    <section class="products-hero">
        <h1><i class="fas fa-pills"></i> Browse Medicines</h1>
        <p>Find the medicine you need from our extensive collection</p>
    </section>
    
    <section class="products-section">
        <!-- Search and Filter -->
        <div class="products-controls">
            <form method="GET" class="search-box">
                <input type="text" name="search" placeholder="Search medicines..." 
                       value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit"><i class="fas fa-search"></i> Search</button>
            </form>
            
            <div class="category-filter">
                <label>Filter by Type:</label>
                <a href="?category=all" class="filter-tag <?php echo $category === 'all' ? 'active' : ''; ?>">All</a>
                <a href="?category=tablet" class="filter-tag <?php echo $category === 'tablet' ? 'active' : ''; ?>">Tablets</a>
                <a href="?category=capsule" class="filter-tag <?php echo $category === 'capsule' ? 'active' : ''; ?>">Capsules</a>
                <a href="?category=syrup" class="filter-tag <?php echo $category === 'syrup' ? 'active' : ''; ?>">Syrups</a>
                <a href="?category=injection" class="filter-tag <?php echo $category === 'injection' ? 'active' : ''; ?>">Injections</a>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="products-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($medicine = $result->fetch_assoc()) {
                    // Check expiry warning
                    $expiry = new DateTime($medicine['expiry_date']);
                    $today = new DateTime();
                    $interval = $today->diff($expiry);
                    $days_to_expiry = $interval->days;
                    $expiring_soon = $days_to_expiry <= 90;
                    ?>
                    
                    <div class="product-card">
                        <?php if ($expiring_soon): ?>
                            <span class="badge badge-warning">Expiring Soon</span>
                        <?php endif; ?>
                        
                        <?php if ($medicine['stock_quantity'] < 20): ?>
                            <span class="badge badge-stock">Only <?php echo $medicine['stock_quantity']; ?> left</span>
                        <?php endif; ?>
                        
                        <div class="product-image">
                            <img src="<?php echo htmlspecialchars($medicine['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($medicine['medicine_name']); ?>">
                        </div>
                        
                        <div class="product-details">
                            <h3><?php echo htmlspecialchars($medicine['medicine_name']); ?></h3>
                            <p class="generic"><?php echo htmlspecialchars($medicine['generic_name']); ?></p>
                            <p class="dosage">
                                <i class="fas fa-prescription-bottle"></i>
                                <?php echo ucfirst($medicine['dosage_form']) . ' - ' . htmlspecialchars($medicine['strength']); ?>
                            </p>
                            
                            <?php if (!empty($medicine['manufacturer'])): ?>
                                <p class="manufacturer">
                                    <i class="fas fa-industry"></i> <?php echo htmlspecialchars($medicine['manufacturer']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="product-footer">
                                <span class="price">₹<?php echo number_format($medicine['price'], 2); ?></span>
                                <span class="stock-info">
                                    <i class="fas fa-box"></i> <?php echo $medicine['stock_quantity']; ?> in stock
                                </span>
                            </div>
                            
                            <form method="POST" action="add_to_cart.php" class="add-cart-form">
                                <input type="hidden" name="medicine_id" value="<?php echo $medicine['id']; ?>">
                                <div class="quantity-selector">
                                    <label>Qty:</label>
                                    <input type="number" name="quantity" value="1" min="1" 
                                           max="<?php echo $medicine['stock_quantity']; ?>">
                                </div>
                                <button type="submit" class="btn btn-cart">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <?php
                }
            } else {
                echo "<div class='no-products'>";
                echo "<i class='fas fa-search'></i>";
                echo "<p>No medicines found matching your criteria.</p>";
                echo "<a href='products.php' class='btn btn-primary'>View All Medicines</a>";
                echo "</div>";
            }
            
            $conn->close();
            ?>
        </div>
    </section>
    
    <?php include('../includes/footer.php'); ?>
</body>
</html>
