<?php
session_start();

// Check if data exists
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission Result</title>
</head>

<body>
    <h2>Your Submitted Information</h2>

    <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION["name"]); ?></p>

    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION["email"]); ?></p>

    <p><strong>Website:</strong> <?php echo htmlspecialchars($_SESSION["website"]); ?></p>

    <p><strong>Comment:</strong> <?php echo htmlspecialchars($_SESSION["comment"]); ?></p>

    <p><strong>Gender:</strong> <?php echo htmlspecialchars($_SESSION["gender"]); ?></p>

    <br>
    <a href="index.php">Go Back to Form</a>
</body>

</html>

<?php
// Clear session data after displaying
session_destroy();
?>