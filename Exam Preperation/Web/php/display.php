<?php
$conn = new mysqli("localhost", "root", "admin123", "members");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
</head>
<body>

<h2>Registered Users</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Email</th>
        <th>Mobile</th>
<th>Action</th>

    </tr>

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
echo "<tr>
        <td>".$row["id"]."</td>
        <td>".$row["name"]."</td>
        <td>".$row["address"]."</td>
        <td>".$row["email"]."</td>
        <td>".$row["mobile"]."</td>
        <td>
            <a href='update.php?id=".$row["id"]."'>Edit</a> |
            <a href='delete.php?id=".$row["id"]."'>Delete</a>
        </td>
      </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No records found</td></tr>";
}
?>

</table>

</body>
</html>