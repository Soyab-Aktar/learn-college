<?php
$page_title = "Update Student";
require_once '../config/config.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';

// Handle form submission
if (isset($_POST['update'])) {
    $id = clean_input($_POST['student_id'], $conn);
    $name = clean_input($_POST['name'], $conn);
    $age = clean_input($_POST['age'], $conn);
    $course = clean_input($_POST['course'], $conn);
    
    $sql = "UPDATE students SET name='$name', age='$age', course='$course' WHERE id='$id'";
    
    if (mysqli_query($conn, $sql)) {
        show_message('success', '✅ Student updated successfully!');
        echo "<script>setTimeout(() => window.location.href='index.php', 2000);</script>";
    } else {
        show_message('error', '❌ Error: ' . mysqli_error($conn));
    }
}

// Fetch student data
if (isset($_GET['id'])) {
    $id = clean_input($_GET['id'], $conn);
    
    if (student_exists($conn, $id)) {
        $sql = "SELECT * FROM students WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $student = mysqli_fetch_assoc($result);
    } else {
        redirect('index.php');
    }
} else {
    redirect('index.php');
}
?>

<div class="form-section">
    <h1>✏️ Update Student Information</h1>
    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
        
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" value="<?php echo $student['age']; ?>" min="1" max="100" required>
        </div>
        
        <div class="form-group">
            <label for="course">Course</label>
            <input type="text" id="course" name="course" value="<?php echo htmlspecialchars($student['course']); ?>" required>
        </div>
        
        <button type="submit" name="update" class="btn btn-primary">Update Student</button>
        <a href="index.php" class="btn btn-edit" style="margin-left: 10px;">Cancel</a>
    </form>
</div>

<?php
require_once '../includes/footer.php';
mysqli_close($conn);
?>
