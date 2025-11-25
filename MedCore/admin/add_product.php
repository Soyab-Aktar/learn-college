<?php
// admin/add_product.php - Add New Medicine
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('../config/db_config.php');

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $medicine_name = trim($_POST['medicine_name']);
    $generic_name = trim($_POST['generic_name']);
    $manufacturer = trim($_POST['manufacturer']);
    $dosage_form = $_POST['dosage_form'];
    $strength = trim($_POST['strength']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $expiry_date = $_POST['expiry_date'];
    $batch_number = trim($_POST['batch_number']);
    $image_url = trim($_POST['image_url']);
    
    // Validate required fields
    if (empty($medicine_name) || empty($price) || empty($expiry_date)) {
        $error = "Please fill in all required fields.";
    } else {
        // Insert into database
        $sql = "INSERT INTO medicines (medicine_name, generic_name, manufacturer, dosage_form, strength, description, price, stock_quantity, expiry_date, batch_number, image_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssdisss", $medicine_name, $generic_name, $manufacturer, $dosage_form, $strength, $description, $price, $stock_quantity, $expiry_date, $batch_number, $image_url);
        
        if ($stmt->execute()) {
            $success = "Medicine added successfully!";
            // Clear form
            $_POST = array();
        } else {
            $error = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine - MedCore Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <i class="fas fa-heartbeat"></i>
                <h2>MedCore</h2>
                <p>Admin Panel</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="add_product.php" class="active">
                    <i class="fas fa-plus-circle"></i> Add Medicine
                </a>
                <a href="../index.php" target="_blank">
                    <i class="fas fa-globe"></i> View Website
                </a>
                <a href="logout.php" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <p><i class="fas fa-user-shield"></i></p>
                <p><strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <header class="content-header">
                <h1><i class="fas fa-plus-circle"></i> Add New Medicine</h1>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </header>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    <a href="dashboard.php">View all medicines</a>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="medicine_name">Medicine Name *</label>
                            <input type="text" id="medicine_name" name="medicine_name" required 
                                   placeholder="e.g., Paracetamol 500mg">
                        </div>
                        
                        <div class="form-group">
                            <label for="generic_name">Generic Name</label>
                            <input type="text" id="generic_name" name="generic_name" 
                                   placeholder="e.g., Paracetamol">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="manufacturer">Manufacturer</label>
                            <input type="text" id="manufacturer" name="manufacturer" 
                                   placeholder="e.g., Cipla">
                        </div>
                        
                        <div class="form-group">
                            <label for="dosage_form">Dosage Form *</label>
                            <select id="dosage_form" name="dosage_form" required>
                                <option value="tablet">Tablet</option>
                                <option value="capsule">Capsule</option>
                                <option value="syrup">Syrup</option>
                                <option value="injection">Injection</option>
                                <option value="cream">Cream</option>
                                <option value="drops">Drops</option>
                                <option value="inhaler">Inhaler</option>
                                <option value="powder">Powder</option>
                                <option value="suspension">Suspension</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="strength">Strength</label>
                            <input type="text" id="strength" name="strength" 
                                   placeholder="e.g., 500mg or 100ml">
                        </div>
                        
                        <div class="form-group">
                            <label for="batch_number">Batch Number</label>
                            <input type="text" id="batch_number" name="batch_number" 
                                   placeholder="e.g., BATCH001">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="3" 
                                  placeholder="Brief description of the medicine..."></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Price (₹) *</label>
                            <input type="number" id="price" name="price" step="0.01" min="0" required 
                                   placeholder="0.00">
                        </div>
                        
                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity *</label>
                            <input type="number" id="stock_quantity" name="stock_quantity" min="0" required 
                                   placeholder="0">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="expiry_date">Expiry Date *</label>
                        <input type="date" id="expiry_date" name="expiry_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="image_url">Image URL</label>
                        <input type="url" id="image_url" name="image_url" 
                               placeholder="https://via.placeholder.com/300x300">
                        <small>Use placeholder URLs for now (e.g., https://via.placeholder.com/300x300)</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Add Medicine
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
