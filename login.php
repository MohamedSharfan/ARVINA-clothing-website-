<?php

session_start();


if (isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] === true) {
    header('Location: home.php');
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
                
                header('Location: home.php');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username or password';
        }
        
        $stmt->close();
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
                
                <h2><i class="fa-solid fa-user"></i> Customer Login</h2>
                <p class="subtitle">Login to access your account and shop</p>
                
                <?php if (!empty($error)): ?>
                    <div class="error-message">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username"><i class="fa-solid fa-user"></i> Username</label>
                        <input type="text" id="username" name="username" required autofocus placeholder="Enter your username">
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" required placeholder="Enter your password">
                    </div>
                    
                    <button type="submit" class="login-btn">
                        <i class="fa-solid fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                <div class="demo-credentials">
                    <p><strong><i class="fa-solid fa-info-circle"></i> Demo Credentials:</strong></p>
                    <p>Username: <code>user1</code></p>
                    <p>Password: <code>user123</code></p>
                </div>
                
                <div class="register-link">
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
