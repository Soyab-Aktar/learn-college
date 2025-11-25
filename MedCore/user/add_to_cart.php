<?php
// user/add_to_cart.php - Add Item to Cart
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=products.php");
    exit();
}

include('../config/db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $medicine_id = intval($_POST['medicine_id']);
    $quantity = intval($_POST['quantity']);
    
    if ($quantity < 1) $quantity = 1;
    
    // Check if item already in cart
    $check_sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND medicine_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $medicine_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        // Update quantity
        $row = $check_result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        
        $update_sql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_quantity, $row['id']);
        $update_stmt->execute();
        $update_stmt->close();
        
        $_SESSION['cart_message'] = "Cart updated successfully!";
    } else {
        // Insert new item
        $insert_sql = "INSERT INTO cart (user_id, medicine_id, quantity) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $user_id, $medicine_id, $quantity);
        $insert_stmt->execute();
        $insert_stmt->close();
        
        $_SESSION['cart_message'] = "Item added to cart!";
    }
    
    $check_stmt->close();
}

$conn->close();
header("Location: cart.php");
exit();
?>
