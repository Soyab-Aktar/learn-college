<?php
// user/register.php - User Registration
session_start();

// If already logged in, redirect
if (isset($_SESSION['user_id'])) {
    header("Location: products.php");
    exit();
}

include('../config/db_config.php');

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if email already exists
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $error = "Email already registered. Please login.";
        } else {
            // Insert new user (plain password for learning)
            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $password);
            
            if ($stmt->execute()) {
                $success = "Registration successful! You can now login.";
                // Clear form
                $_POST = array();
            } else {
                $error = "Error: " . $stmt->error;
            }
            
            $stmt->close();
        }
        
        $check_stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MedCore</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <i class="fas fa-user-plus"></i>
                <h2>Create Account</h2>
                <p>Join MedCore Today</p>
            </div>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    <a href="login.php">Login now</a>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login-form">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Full Name
                    </label>
                    <input type="text" id="username" name="username" required 
                           placeholder="John Doe" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input type="email" id="email" name="email" required 
                           placeholder="your@email.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Minimum 6 characters" minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">
                        <i class="fas fa-lock"></i> Confirm Password
                    </label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           placeholder="Re-enter password" minlength="6">
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </form>
            
            <div class="login-footer">
                <p>Already have an account? <a href="login.php">Login here</a></p>
                <p><a href="../index.php"><i class="fas fa-home"></i> Back to Home</a></p>
            </div>
        </div>
    </div>
</body>
</html>
