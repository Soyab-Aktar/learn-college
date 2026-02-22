<?php
$conn = new mysqli("localhost", "root", "admin123", "members");

$id = $_GET["id"];

$sql = "DELETE FROM users WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: display.php");
} else {
    echo "Error deleting record";
}
?>