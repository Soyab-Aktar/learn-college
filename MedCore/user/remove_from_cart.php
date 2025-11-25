<?php
// user/remove_from_cart.php - Remove Item from Cart
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('../config/db_config.php');

if (isset($_GET['id'])) {
    $cart_id = intval($_GET['id']);
    
    $sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cart_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
    
    $_SESSION['cart_message'] = "Item removed from cart.";
}

$conn->close();
header("Location: cart.php");
exit();
?>
