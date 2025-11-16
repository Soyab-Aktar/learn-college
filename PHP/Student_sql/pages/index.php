<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$page_title = "Dashboard - All Students";
require_once '../config/config.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

// Fetch all students
$sql = "SELECT * FROM students ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="form-section">
    <h1>📊 Student Dashboard</h1>
    <p style="color: #666;">Manage all registered students from here</p>
</div>

<div class="cards-container">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='card'>";
            echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
            echo "<p><strong>Age:</strong> " . htmlspecialchars($row['age']) . "</p>";
            echo "<p><strong>Course:</strong> " . htmlspecialchars($row['course']) . "</p>";
            echo "<p><strong>Added:</strong> " . date('M d, Y', strtotime($row['created_at'])) . "</p>";
            echo "<div class='card-actions'>";
            echo "<a href='update.php?id=" . $row['id'] . "' class='btn btn-edit'>✏️ Edit</a>";
            echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete " . htmlspecialchars($row['name']) . "?\")'>🗑️ Delete</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='alert alert-error'>No students found. <a href='create.php'>Add your first student!</a></div>";
    }
    ?>
</div>

<?php
require_once '../includes/footer.php';
mysqli_close($conn);
?>
