<?php
// user/checkout.php - Checkout and Place Order
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('../config/db_config.php');

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Get cart items
$sql = "SELECT c.*, m.medicine_name, m.price, m.stock_quantity, m.batch_number 
        FROM cart c 
        JOIN medicines m ON c.medicine_id = m.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $subtotal = $row['price'] * $row['quantity'];
    $row['subtotal'] = $subtotal;
    $total += $subtotal;
    $cart_items[] = $row;
}

$stmt->close();

if (count($cart_items) == 0) {
    header("Location: cart.php");
    exit();
}

// Process order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $delivery_address = trim($_POST['delivery_address']);
    
    if (empty($delivery_address)) {
        $error = "Please enter delivery address.";
    } else {
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Create order
            $total_with_delivery = $total + 50;
            $order_sql = "INSERT INTO orders (user_id, total_amount, delivery_address, status) VALUES (?, ?, ?, 'pending')";
            $order_stmt = $conn->prepare($order_sql);
            $order_stmt->bind_param("ids", $user_id, $total_with_delivery, $delivery_address);
            $order_stmt->execute();
            $order_id = $conn->insert_id;
            $order_stmt->close();
            
            // Add order items and update stock
            foreach ($cart_items as $item) {
                // Insert order item
                $item_sql = "INSERT INTO order_items (order_id, medicine_id, quantity, price_at_purchase, batch_number) 
                            VALUES (?, ?, ?, ?, ?)";
                $item_stmt = $conn->prepare($item_sql);
                $item_stmt->bind_param("iiids", $order_id, $item['medicine_id'], $item['quantity'], $item['price'], $item['batch_number']);
                $item_stmt->execute();
                $item_stmt->close();
                
                // Update stock
                $update_stock = "UPDATE medicines SET stock_quantity = stock_quantity - ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_stock);
                $update_stmt->bind_param("ii", $item['quantity'], $item['medicine_id']);
                $update_stmt->execute();
                $update_stmt->close();
            }
            
            // Clear cart
            $clear_sql = "DELETE FROM cart WHERE user_id = ?";
            $clear_stmt = $conn->prepare($clear_sql);
            $clear_stmt->bind_param("i", $user_id);
            $clear_stmt->execute();
            $clear_stmt->close();
            
            // Commit transaction
            $conn->commit();
            
            $_SESSION['order_success'] = "Order placed successfully! Order ID: #" . $order_id;
            header("Location: order_history.php");
            exit();
            
        } catch (Exception $e) {
            $conn->rollback();
            $error = "Error placing order. Please try again.";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - MedCore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    
    <section class="checkout-section">
        <div class="checkout-container">
            <h1><i class="fas fa-credit-card"></i> Checkout</h1>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <div class="checkout-content">
                <!-- Order Summary -->
                <div class="checkout-items">
                    <h2>Order Summary</h2>
                    
                    <?php foreach ($cart_items as $item): ?>
                        <div class="checkout-item">
                            <div>
                                <h4><?php echo htmlspecialchars($item['medicine_name']); ?></h4>
                                <p>Quantity: <?php echo $item['quantity']; ?> × ₹<?php echo number_format($item['price'], 2); ?></p>
                            </div>
                            <span class="item-total">₹<?php echo number_format($item['subtotal'], 2); ?></span>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="checkout-totals">
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span>₹<?php echo number_format($total, 2); ?></span>
                        </div>
                        <div class="total-row">
                            <span>Delivery Charges:</span>
                            <span>₹50.00</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Grand Total:</span>
                            <span>₹<?php echo number_format($total + 50, 2); ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Delivery Form -->
                <div class="checkout-form">
                    <h2>Delivery Information</h2>
                    
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="form-group">
                            <label for="delivery_address">
                                <i class="fas fa-map-marker-alt"></i> Delivery Address *
                            </label>
                            <textarea id="delivery_address" name="delivery_address" rows="4" required 
                                      placeholder="Enter your complete delivery address..."></textarea>
                        </div>
                        
                        <div class="payment-info">
                            <h3><i class="fas fa-money-bill-wave"></i> Payment Method</h3>
                            <p class="payment-note">Cash on Delivery (COD) - Pay when you receive</p>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-check-circle"></i> Place Order
                        </button>
                        
                        <a href="cart.php" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Back to Cart
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <?php include('../includes/footer.php'); ?>
</body>
</html>
