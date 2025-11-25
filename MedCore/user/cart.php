<?php
// user/cart.php - Shopping Cart
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=cart.php");
    exit();
}

include('../config/db_config.php');

$user_id = $_SESSION['user_id'];
$message = isset($_SESSION['cart_message']) ? $_SESSION['cart_message'] : '';
unset($_SESSION['cart_message']);

// Get cart items
$sql = "SELECT c.id as cart_id, c.quantity, m.* 
        FROM cart c 
        JOIN medicines m ON c.medicine_id = m.id 
        WHERE c.user_id = ?
        ORDER BY c.added_at DESC";
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
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - MedCore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>
    
    <section class="cart-section">
        <div class="cart-container">
            <h1><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h1>
            
            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <?php if (count($cart_items) > 0): ?>
                <div class="cart-content">
                    <!-- Cart Items -->
                    <div class="cart-items">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-item">
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['medicine_name']); ?>">
                                
                                <div class="item-info">
                                    <h3><?php echo htmlspecialchars($item['medicine_name']); ?></h3>
                                    <p class="generic"><?php echo htmlspecialchars($item['generic_name']); ?></p>
                                    <p class="dosage"><?php echo ucfirst($item['dosage_form']) . ' - ' . $item['strength']; ?></p>
                                    <p class="price">₹<?php echo number_format($item['price'], 2); ?> per unit</p>
                                </div>
                                
                                <div class="item-actions">
                                    <form method="POST" action="update_cart.php" class="quantity-form">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                        <label>Quantity:</label>
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                               min="1" max="<?php echo $item['stock_quantity']; ?>">
                                        <button type="submit" class="btn-small btn-update">
                                            <i class="fas fa-sync"></i> Update
                                        </button>
                                    </form>
                                    
                                    <p class="subtotal">Subtotal: ₹<?php echo number_format($item['subtotal'], 2); ?></p>
                                    
                                    <a href="remove_from_cart.php?id=<?php echo $item['cart_id']; ?>" 
                                       class="btn-remove"
                                       onclick="return confirm('Remove this item from cart?');">
                                        <i class="fas fa-trash"></i> Remove
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <h2>Order Summary</h2>
                        
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>₹<?php echo number_format($total, 2); ?></span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Delivery Charges:</span>
                            <span>₹50.00</span>
                        </div>
                        
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span>₹<?php echo number_format($total + 50, 2); ?></span>
                        </div>
                        
                        <a href="checkout.php" class="btn btn-primary btn-block">
                            <i class="fas fa-credit-card"></i> Proceed to Checkout
                        </a>
                        
                        <a href="products.php" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <h2>Your cart is empty</h2>
                    <p>Add some medicines to your cart to get started!</p>
                    <a href="products.php" class="btn btn-primary">
                        <i class="fas fa-pills"></i> Browse Medicines
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <?php include('../includes/footer.php'); ?>
</body>
</html>
