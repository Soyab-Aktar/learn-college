<?php
// index.php - Homepage
include('config/db_config.php');
include('includes/header.php');
?>

<section class="hero-section">
    <div class="hero-content">
        <h1><i class="fas fa-heartbeat"></i> Welcome to MedCore</h1>
        <p>Your Trusted Online Medicine Store</p>
        <p class="hero-subtitle">Quality medicines at affordable prices, delivered to your doorstep</p>
        <div class="hero-buttons">
            <a href="user/products.php" class="btn btn-primary">Browse Medicines</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="user/register.php" class="btn btn-secondary">Register Now</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="features-section">
    <h2>Why Choose MedCore?</h2>
    <div class="features-grid">
        <div class="feature-card">
            <i class="fas fa-shield-alt"></i>
            <h3>100% Authentic</h3>
            <p>All medicines are sourced from verified manufacturers</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-truck"></i>
            <h3>Fast Delivery</h3>
            <p>Get your medicines delivered within 24-48 hours</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-tags"></i>
            <h3>Best Prices</h3>
            <p>Competitive prices with regular discounts</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-headset"></i>
            <h3>24/7 Support</h3>
            <p>Customer support available round the clock</p>
        </div>
    </div>
</section>

<section class="medicines-section">
    <h2>Featured Medicines</h2>
    <p class="section-subtitle">Browse our most popular medicines</p>
    
    <div class="medicines-grid">
        <?php
        // Fetch featured medicines (limit to 8 for homepage)
        $sql = "SELECT id, medicine_name, generic_name, dosage_form, strength, price, stock_quantity, expiry_date, image_url 
                FROM medicines 
                WHERE stock_quantity > 0 AND expiry_date > CURDATE() 
                ORDER BY created_at DESC 
                LIMIT 8";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($medicine = $result->fetch_assoc()) {
                // Check if expiring soon (within 3 months)
                $expiry = new DateTime($medicine['expiry_date']);
                $today = new DateTime();
                $interval = $today->diff($expiry);
                $days_to_expiry = $interval->days;
                $expiring_soon = $days_to_expiry <= 90;
                ?>
                
                <div class="medicine-card">
                    <?php if ($expiring_soon): ?>
                        <span class="badge badge-warning">Expiring Soon</span>
                    <?php endif; ?>
                    
                    <?php if ($medicine['stock_quantity'] < 20): ?>
                        <span class="badge badge-danger">Low Stock</span>
                    <?php endif; ?>
                    
                    <img src="<?php echo htmlspecialchars($medicine['image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($medicine['medicine_name']); ?>">
                    
                    <div class="medicine-info">
                        <h3><?php echo htmlspecialchars($medicine['medicine_name']); ?></h3>
                        <p class="generic-name"><?php echo htmlspecialchars($medicine['generic_name']); ?></p>
                        <p class="dosage"><?php echo ucfirst($medicine['dosage_form']) . ' - ' . htmlspecialchars($medicine['strength']); ?></p>
                        
                        <div class="medicine-footer">
                            <span class="price">₹<?php echo number_format($medicine['price'], 2); ?></span>
                            <span class="stock">Stock: <?php echo $medicine['stock_quantity']; ?></span>
                        </div>
                        
                        <a href="user/products.php?id=<?php echo $medicine['id']; ?>" class="btn btn-view">View Details</a>
                    </div>
                </div>
                
                <?php
            }
        } else {
            echo "<p class='no-medicines'>No medicines available at the moment.</p>";
        }
        
        $conn->close();
        ?>
    </div>
    
    <div class="view-all-btn">
        <a href="user/products.php" class="btn btn-primary">View All Medicines</a>
    </div>
</section>

<?php include('includes/footer.php'); ?>
