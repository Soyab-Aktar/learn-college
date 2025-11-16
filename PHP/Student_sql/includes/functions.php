<?php
// Reusable functions for common tasks

/**
 * Sanitize user input to prevent SQL injection
 */
function clean_input($data, $conn) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

/**
 * Redirect to another page
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Display success or error messages
 */
function show_message($type, $message) {
    $class = ($type == 'success') ? 'alert-success' : 'alert-error';
    echo "<div class='alert $class'>$message</div>";
}

/**
 * Check if student exists
 */
function student_exists($conn, $id) {
    $id = clean_input($id, $conn);
    $sql = "SELECT id FROM students WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}
?>
