<?php
// config/db_config.php - Database Connection

$servername = "localhost";
$username = "root";
$password = "admin123";
$database = "medcore";

// Create MySQLi connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// Uncomment below to test connection
// echo "Connected successfully to MedCore database!";
?>
