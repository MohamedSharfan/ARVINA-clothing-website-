<?php

session_start();

if (isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] === true) {
    header('Location: home.php');
    exit;
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin/admin_dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'php/db_connect.php';
    
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        $conn = getDBConnection();
        
        $adminStmt = $conn->prepare("SELECT admin_id, username, password FROM admin_users WHERE username = ?");
        $adminStmt->bind_param("s", $username);
        $adminStmt->execute();
        $adminResult = $adminStmt->get_result();
        
        if ($adminResult->num_rows === 1) {
            $admin = $adminResult->fetch_assoc();
            
            if ($password === 'admin123') {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_username'] = $admin['username'];
                
                $adminStmt->close();
                closeDBConnection($conn);
                
                header('Location: admin/admin_dashboard.php');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $adminStmt->close();
            
            $stmt = $conn->prepare("SELECT customer_id, username, password, email, full_name, phone FROM customer_users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $customer = $result->fetch_assoc();
                
                if ($password === $customer['password']) {
                    $_SESSION['customer_logged_in'] = true;
                    $_SESSION['customer_id'] = $customer['customer_id'];
                    $_SESSION['customer_username'] = $customer['username'];
                    $_SESSION['customer_name'] = $customer['full_name'];
                    $_SESSION['customer_email'] = $customer['email'];
                    $_SESSION['customer_phone'] = $customer['phone'];
                    
                    $updateStmt = $conn->prepare("UPDATE customer_users SET last_login = NOW() WHERE customer_id = ?");
                    $updateStmt->bind_param("i", $customer['customer_id']);
                    $updateStmt->execute();
                    $updateStmt->close();
                    
                    $stmt->close();
                    closeDBConnection($conn);
                    
                    header('Location: home.php');
                    exit;
                } else {
                    $error = 'Invalid username or password';
                }
            } else {
                $error = 'Invalid username or password';
            }
            
            $stmt->close();
        }
        
        closeDBConnection($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./css/login.css">
    <title>Customer Login - Arvina</title>
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="login-box">
                <div class="brand-header">
                    <h1>A R V I N A</h1>
                    <p>Timeless Elegance</p>
                </div>
                
                <h2><i class="fa-solid fa-right-to-bracket"></i> Login</h2>
                <p class="subtitle">Admin & Customer Login Portal</p>
                
                <?php if (!empty($error)): ?>
                    <div class="error-message">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username"><i class="fa-solid fa-user"></i> Username</label>
                        <input type="text" id="username" name="username" autofocus placeholder="Enter your username">
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password">
                    </div>
                    
                    <button type="submit" class="login-btn">
                        <i class="fa-solid fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                <div class="demo-credentials">
                    <p><strong><i class="fa-solid fa-info-circle"></i> Demo Credentials:</strong></p>
                    <p><strong>Admin:</strong> Username: <code>admin</code> | Password: <code>admin123</code></p>
                    <p><strong>Customer:</strong> Username: <code>user1</code> | Password: <code>user123</code></p>
                </div>
                
                <div class="register-link">
                               </div>
            </div>
        </div>
    </div>
</body>
</html>
