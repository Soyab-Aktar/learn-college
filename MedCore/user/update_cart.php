<?php
// user/update_cart.php - Update Cart Quantity
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('../config/db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = intval($_POST['cart_id']);
    $quantity = intval($_POST['quantity']);
    
    if ($quantity < 1) $quantity = 1;
    
    $sql = "UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $quantity, $cart_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
    
    $_SESSION['cart_message'] = "Cart updated successfully!";
}

$conn->close();
header("Location: cart.php");
exit();
?>
