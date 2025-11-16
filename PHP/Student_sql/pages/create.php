<?php
$page_title = "Add New Student";
require_once '../config/config.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = clean_input($_POST['name'], $conn);
    $age = clean_input($_POST['age'], $conn);
    $course = clean_input($_POST['course'], $conn);
    
    $sql = "INSERT INTO students (name, age, course) VALUES ('$name', '$age', '$course')";
    
    if (mysqli_query($conn, $sql)) {
        show_message('success', '✅ Student added successfully!');
        echo "<script>setTimeout(() => window.location.href='index.php', 2000);</script>";
    } else {
        show_message('error', '❌ Error: ' . mysqli_error($conn));
    }
}
?>

<div class="form-section">
    <h1>➕ Add New Student</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter student name" required>
        </div>
        
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" placeholder="Enter age" min="1" max="100" required>
        </div>
        
        <div class="form-group">
            <label for="course">Course</label>
            <input type="text" id="course" name="course" placeholder="Enter course name" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Student</button>
        <a href="index.php" class="btn btn-edit" style="margin-left: 10px;">Cancel</a>
    </form>
</div>

<?php
require_once '../includes/footer.php';
mysqli_close($conn);
?>
