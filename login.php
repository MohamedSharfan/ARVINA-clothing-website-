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
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
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

// Handle Signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    require_once 'php/db_connect.php';
    
    $fullName = sanitizeInput($_POST['fullName']);
    $email = sanitizeInput($_POST['email']);
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    if (empty($fullName) || empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
        $error = 'All fields are required';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } else {
        $conn = getDBConnection();
        
        // Check if username or email already exists
        $checkStmt = $conn->prepare("SELECT customer_id FROM customer_users WHERE username = ? OR email = ?");
        $checkStmt->bind_param("ss", $username, $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            $error = 'Username or email already exists';
        } else {
            // Insert new customer
            $insertStmt = $conn->prepare("INSERT INTO customer_users (username, password, email, full_name, created_at) VALUES (?, ?, ?, ?, NOW())");
            $insertStmt->bind_param("ssss", $username, $password, $email, $fullName);
            
            if ($insertStmt->execute()) {
                $success = 'Account created successfully! Please login.';
            } else {
                $error = 'Error creating account. Please try again.';
            }
            $insertStmt->close();
        }
        $checkStmt->close();
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
    <style>
        .hidden {
            display: none;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .toggle-form {
            text-align: center;
            margin-top: 24px;
            color: #718096;
            font-size: 14px;
        }

        .toggle-form a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .toggle-form a:hover {
            color: #2c3e50;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <!-- Sign In Form -->
            <div class="login-box" id="signInForm">
                <div class="brand-header">
                    <h1>A R V I N A</h1>
                    <p>Timeless Elegance</p>
                </div>
                
                <h2><i class="fa-solid fa-right-to-bracket"></i> Login</h2>
                <p class="subtitle">Admin & Customer Login Portal</p>
                
                <?php if (!empty($error) && !isset($_POST['signup'])): ?>
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
                    
                    <button type="submit" name="login" class="login-btn">
                        <i class="fa-solid fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                <div class="demo-credentials">
                    <p><strong><i class="fa-solid fa-info-circle"></i> Demo Credentials:</strong></p>
                    <p><strong>Admin:</strong> Username: <code>admin</code> | Password: <code>admin123</code></p>
                    <p><strong>Customer:</strong> Username: <code>user1</code> | Password: <code>user123</code></p>
                </div>
                
                <p class="toggle-form">
                    Don't have an account? <a href="#" id="showSignUp">Create your account</a>
                </p>
            </div>
            
            <!-- Sign Up Form -->
            <div class="login-box hidden" id="signUpForm">
                <div class="brand-header">
                    <h1>A R V I N A</h1>
                    <p>Timeless Elegance</p>
                </div>
                
                <h2><i class="fa-solid fa-user-plus"></i> Create Account</h2>
                <p class="subtitle">Register as a Customer</p>
                
                <?php if (!empty($error) && isset($_POST['signup'])): ?>
                    <div class="error-message">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="success-message">
                        <i class="fa-solid fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" id="registerForm">
                    <div class="form-group">
                        <label for="registerName"><i class="fa-solid fa-user"></i> Full Name</label>
                        <input type="text" id="registerName" name="fullName" placeholder="Enter your full name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="registerEmail"><i class="fa-solid fa-envelope"></i> Email Address</label>
                        <input type="email" id="registerEmail" name="email" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="registerUsername"><i class="fa-solid fa-user-circle"></i> Username</label>
                        <input type="text" id="registerUsername" name="username" placeholder="Choose a username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="registerPassword"><i class="fa-solid fa-lock"></i> Password</label>
                        <input type="password" id="registerPassword" name="password" placeholder="Create a password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirmPassword"><i class="fa-solid fa-lock"></i> Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                    </div>
                    
                    <button type="submit" name="signup" class="login-btn">
                        <i class="fa-solid fa-user-plus"></i> Create Account
                    </button>
                </form>
                
                <p class="toggle-form">
                    Already have an account? <a href="#" id="showSignIn">Sign in here</a>
                </p>
            </div>
        </div>
    </div>
       
    <script>
        // Get form elements
        const signInForm = document.getElementById('signInForm');
        const signUpForm = document.getElementById('signUpForm');
        const showSignUpLink = document.getElementById('showSignUp');
        const showSignInLink = document.getElementById('showSignIn');

        // Toggle between Sign In and Sign Up forms
        showSignUpLink.addEventListener('click', function(e) {
            e.preventDefault();
            signInForm.classList.add('hidden');
            signUpForm.classList.remove('hidden');
        });

        showSignInLink.addEventListener('click', function(e) {
            e.preventDefault();
            signUpForm.classList.add('hidden');
            signInForm.classList.remove('hidden');
        });

        // Add smooth animations on page load
        window.addEventListener('load', function() {
            signInForm.style.opacity = '0';
            signInForm.style.transform = 'translateY(20px)';
            
            setTimeout(function() {
                signInForm.style.transition = 'all 0.5s ease';
                signInForm.style.opacity = '1';
                signInForm.style.transform = 'translateY(0)';
            }, 100);
        });
        
        // Show signup form if there's a signup error
        <?php if (isset($_POST['signup']) && !empty($error)): ?>
        window.addEventListener('load', function() {
            signInForm.classList.add('hidden');
            signUpForm.classList.remove('hidden');
        });
        <?php endif; ?>

        // Show login form if signup was successful
        <?php if (!empty($success)): ?>
        window.addEventListener('load', function() {
            signUpForm.classList.add('hidden');
            signInForm.classList.remove('hidden');
        });
        <?php endif; ?>
    </script>
</body>
</html>