<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include('../config/db_config.php');

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$medicine_id = intval($_GET['id']);
$sql = "SELECT * FROM medicines WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $medicine_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $medicine = $result->fetch_assoc();
} else {
    header("Location: dashboard.php");
    exit();
}
$stmt->close();

$expiry_parts = explode('-', $medicine['expiry_date']);
$current_year = isset($expiry_parts[0]) ? $expiry_parts[0] : 2025;
$current_month = isset($expiry_parts[1]) ? $expiry_parts[1] : 1;
$current_day = isset($expiry_parts[2]) ? $expiry_parts[2] : 1;

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicine_name = trim($_POST['medicine_name']);
    $generic_name = trim($_POST['generic_name']);
    $manufacturer = trim($_POST['manufacturer']);
    $dosage_form = $_POST['dosage_form'];
    $strength = trim($_POST['strength']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $batch_number = trim($_POST['batch_number']);
    $image_url = trim($_POST['image_url']);
    
    $day = intval($_POST['day']);
    $month = intval($_POST['month']);
    $year = intval($_POST['year']);
    $expiry_date = sprintf('%04d-%02d-%02d', $year, $month, $day);
    
    if (empty($medicine_name) || empty($price)) {
        $error = "Required fields missing.";
    } else {
        $sql = "UPDATE medicines SET medicine_name=?, generic_name=?, manufacturer=?, dosage_form=?, strength=?, description=?, price=?, stock_quantity=?, expiry_date=?, batch_number=?, image_url=? WHERE id=?";
        
        $stmt = $conn->prepare($sql);
        
        // FIXED: Changed "ssssssdiissi" to "ssssssdisssi"
        //                          ^ This was 'i', now it's 's'
        $stmt->bind_param("ssssssdisssi", $medicine_name, $generic_name, $manufacturer, $dosage_form, $strength, $description, $price, $stock_quantity, $expiry_date, $batch_number, $image_url, $medicine_id);
        
        if ($stmt->execute()) {
            $success = "✅ Medicine updated successfully!";
            $current_year = $year;
            $current_month = $month;
            $current_day = $day;
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Medicine</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <i class="fas fa-heartbeat"></i>
            <h2>MedCore</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="add_product.php"><i class="fas fa-plus-circle"></i> Add</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>
    
    <main class="admin-content">
        <header class="content-header">
            <h1><i class="fas fa-edit"></i> Edit Medicine</h1>
            <a href="dashboard.php" class="btn btn-secondary">Back</a>
        </header>
        
        <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" class="admin-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Medicine Name *</label>
                        <input type="text" name="medicine_name" required value="<?php echo htmlspecialchars($medicine['medicine_name']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Generic Name</label>
                        <input type="text" name="generic_name" value="<?php echo htmlspecialchars($medicine['generic_name']); ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Manufacturer</label>
                        <input type="text" name="manufacturer" value="<?php echo htmlspecialchars($medicine['manufacturer']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Dosage Form</label>
                        <select name="dosage_form">
                            <?php
                            $forms = ['tablet', 'capsule', 'syrup', 'injection', 'cream'];
                            foreach($forms as $f) {
                                $sel = ($medicine['dosage_form']==$f) ? 'selected' : '';
                                echo "<option value='$f' $sel>".ucfirst($f)."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Strength</label>
                        <input type="text" name="strength" value="<?php echo htmlspecialchars($medicine['strength']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Batch Number</label>
                        <input type="text" name="batch_number" value="<?php echo htmlspecialchars($medicine['batch_number']); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3"><?php echo htmlspecialchars($medicine['description']); ?></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Price (₹) *</label>
                        <input type="number" name="price" step="0.01" required value="<?php echo $medicine['price']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Stock *</label>
                        <input type="number" name="stock_quantity" required value="<?php echo $medicine['stock_quantity']; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Expiry Date (Day / Month / Year)</label>
                    <div style="display:flex;gap:0.5rem;">
                        <select name="day" required style="flex:1;">
                            <?php for($d=1; $d<=31; $d++): ?>
                                <option value="<?php echo $d; ?>" <?php echo ($d==$current_day)?'selected':''; ?>><?php echo sprintf('%02d', $d); ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="month" required style="flex:1;">
                            <option value="1" <?php echo ($current_month==1)?'selected':''; ?>>January</option>
                            <option value="2" <?php echo ($current_month==2)?'selected':''; ?>>February</option>
                            <option value="3" <?php echo ($current_month==3)?'selected':''; ?>>March</option>
                            <option value="4" <?php echo ($current_month==4)?'selected':''; ?>>April</option>
                            <option value="5" <?php echo ($current_month==5)?'selected':''; ?>>May</option>
                            <option value="6" <?php echo ($current_month==6)?'selected':''; ?>>June</option>
                            <option value="7" <?php echo ($current_month==7)?'selected':''; ?>>July</option>
                            <option value="8" <?php echo ($current_month==8)?'selected':''; ?>>August</option>
                            <option value="9" <?php echo ($current_month==9)?'selected':''; ?>>September</option>
                            <option value="10" <?php echo ($current_month==10)?'selected':''; ?>>October</option>
                            <option value="11" <?php echo ($current_month==11)?'selected':''; ?>>November</option>
                            <option value="12" <?php echo ($current_month==12)?'selected':''; ?>>December</option>
                        </select>
                        <select name="year" required style="flex:1;">
                            <?php for($y=2025; $y<=2035; $y++): ?>
                                <option value="<?php echo $y; ?>" <?php echo ($y==$current_year)?'selected':''; ?>><?php echo $y; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <small style="color:#666;">Current: <?php echo date('d M Y', strtotime($medicine['expiry_date'])); ?></small>
                </div>
                
                <div class="form-group">
                    <label>Image URL</label>
                    <input type="url" name="image_url" value="<?php echo htmlspecialchars($medicine['image_url']); ?>">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Medicine</button>
                    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
