<?php
$conn = new mysqli("localhost", "root", "admin123", "members");

$id = $_GET["id"];

$result = $conn->query("SELECT * FROM users WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];

    $sql = "UPDATE users 
            SET name='$name',
                address='$address',
                email='$email',
                mobile='$mobile'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: display.php");
    } else {
        echo "Error updating record";
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Update User</h2>

<form method="post">
    Name: <br>
    <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>

    Address: <br>
    <input type="text" name="address" value="<?php echo $row['address']; ?>"><br><br>

    Email: <br>
    <input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br>

    Mobile: <br>
    <input type="text" name="mobile" value="<?php echo $row['mobile']; ?>"><br><br>

    <input type="submit" value="Update">
</form>

</body>
</html>