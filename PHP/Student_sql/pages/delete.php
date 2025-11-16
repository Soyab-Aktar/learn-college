<?php
require_once '../config/config.php';
require_once '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = clean_input($_GET['id'], $conn);
    
    if (student_exists($conn, $id)) {
        $sql = "DELETE FROM students WHERE id='$id'";
        mysqli_query($conn, $sql);
    }
}

redirect('index.php');
mysqli_close($conn);
?>
