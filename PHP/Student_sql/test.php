<?php
echo "PHP is working!<br>";

// Test database connection
$conn = mysqli_connect('localhost', 'root', '', 'students_db');

if ($conn) {
    echo "✅ Database connected successfully!";
} else {
    echo "❌ Connection failed: " . mysqli_connect_error();
}

mysqli_close($conn);
?>
