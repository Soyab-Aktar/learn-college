<?php
// admin/delete_product.php - Delete Medicine
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('../config/db_config.php');

// Get medicine ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$medicine_id = intval($_GET['id']);

// Delete medicine
$sql = "DELETE FROM medicines WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $medicine_id);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Medicine deleted successfully!";
} else {
    $_SESSION['error_message'] = "Error deleting medicine: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: dashboard.php");
exit();
?>
