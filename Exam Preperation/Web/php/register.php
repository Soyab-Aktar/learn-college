<?php
$conn = new mysqli("localhost", "root", "admin123", "members");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];

    $sql = "INSERT INTO users (name, address, email, mobile)
            VALUES ('$name', '$address', '$email', '$mobile')";

    if ($conn->query($sql) === TRUE) {
        echo "User Registered Successfully <br>";
        echo "<a href='display.php'>View All Users</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
</head>
<body>

<h2>User Registration</h2>

<form method="post">
    Name: <br>
    <input type="text" name="name" required><br><br>

    Address: <br>
    <input type="text" name="address" required><br><br>

    Email: <br>
    <input type="email" name="email" required><br><br>

    Mobile: <br>
    <input type="text" name="mobile" required><br><br>

    <input type="submit" value="Register">
</form>

</body>
</html>