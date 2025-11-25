<?php
// user/order_history.php - View Order History
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('../config/db_config.php');

$user_id = $_SESSION['user_id'];
$message = isset($_SESSION['order_success']) ? $_SESSION['order_success'] : '';
unset($_SESSION['order_success']);

// Get all orders
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - MedCore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    
    <section class="orders-section">
        <div class="orders-container">
            <h1><i class="fas fa-history"></i> Order History</h1>
            
            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($orders_result->num_rows > 0): ?>
                <div class="orders-list">
                    <?php while ($order = $orders_result->fetch_assoc()): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <div>
                                    <h3>Order #<?php echo $order['id']; ?></h3>
                                    <p>Placed on <?php echo date('d M Y, h:i A', strtotime($order['order_date'])); ?></p>
                                </div>
                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </div>
                            
                            <div class="order-details">
                                <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['total_amount'], 2); ?></p>
                                <p><strong>Delivery Address:</strong> <?php echo nl2br(htmlspecialchars($order['delivery_address'])); ?></p>
                            </div>
                            
                            <div class="order-items">
                                <h4>Items:</h4>
                                <?php
                                // Get order items
                                $items_sql = "SELECT oi.*, m.medicine_name, m.generic_name 
                                             FROM order_items oi 
                                             JOIN medicines m ON oi.medicine_id = m.id 
                                             WHERE oi.order_id = ?";
                                $items_stmt = $conn->prepare($items_sql);
                                $items_stmt->bind_param("i", $order['id']);
                                $items_stmt->execute();
                                $items_result = $items_stmt->get_result();
                                
                                while ($item = $items_result->fetch_assoc()) {
                                    echo "<div class='order-item'>";
                                    echo "<span>" . htmlspecialchars($item['medicine_name']) . " (" . htmlspecialchars($item['generic_name']) . ")</span>";
                                    echo "<span>Qty: " . $item['quantity'] . " × ₹" . number_format($item['price_at_purchase'], 2) . " = ₹" . number_format($item['quantity'] * $item['price_at_purchase'], 2) . "</span>";
                                    echo "</div>";
                                }
                                
                                $items_stmt->close();
                                ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="empty-orders">
                    <i class="fas fa-shopping-bag"></i>
                    <h2>No orders yet</h2>
                    <p>Start shopping to see your orders here!</p>
                    <a href="products.php" class="btn btn-primary">
                        <i class="fas fa-pills"></i> Browse Medicines
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <?php 
    $conn->close();
    include('../includes/footer.php'); 
    ?>
</body>
</html>
