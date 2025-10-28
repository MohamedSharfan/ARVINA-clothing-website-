<?php

session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once '../php/db_connect.php';

$conn = getDBConnection();


if (!isset($_GET['id'])) {
    header('Location: admin_messages.php');
    exit;
}

$messageId = intval($_GET['id']);


$stmt = $conn->prepare("SELECT * FROM contact_messages WHERE message_id = ?");
$stmt->bind_param("i", $messageId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: admin_messages.php');
    exit;
}

$message = $result->fetch_assoc();
$stmt->close();

if ($message['status'] === 'new') {
    $updateStmt = $conn->prepare("UPDATE contact_messages SET status = 'read' WHERE message_id = ?");
    $updateStmt->bind_param("i", $messageId);
    $updateStmt->execute();
    $updateStmt->close();
    $message['status'] = 'read';
}

closeDBConnection($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Message Details - Admin Panel</title>
    <style>
        .message-detail {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 900px;
        }
        
        .message-header {
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        
        .message-header h2 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        
        .message-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .meta-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .meta-label {
            font-size: 12px;
            color: #7f8c8d;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .meta-value {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .message-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        
        .message-content h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        
        .message-text {
            line-height: 1.8;
            color: #34495e;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
        }
        
        .btn-success {
            background: #27ae60;
            color: white;
        }
        
        .btn-success:hover {
            background: #229954;
        }
        
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status-new {
            background: #e74c3c;
            color: white;
        }
        
        .status-read {
            background: #f39c12;
            color: white;
        }
        
        .status-replied {
            background: #27ae60;
            color: white;
        }
    </style>
</head>
<body class="admin-page">
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>ARVINA</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <a href="admin_dashboard.php" class="nav-item">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
                <a href="admin_products.php" class="nav-item">
                    <i class="fa-solid fa-shirt"></i> Products
                </a>
                <a href="admin_orders.php" class="nav-item">
                    <i class="fa-solid fa-shopping-bag"></i> Orders
                </a>
                <a href="admin_messages.php" class="nav-item active">
                    <i class="fa-solid fa-envelope"></i> Messages
                </a>
                <a href="admin_logout.php" class="nav-item logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="main-content">
            <header class="admin-header">
                <h1><i class="fa-solid fa-envelope-open"></i> Message Details</h1>
                <div class="admin-user">
                    <i class="fa-solid fa-user-circle"></i>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>
            </header>
            
            <div class="message-detail">
                <div class="message-header">
                    <h2><?php echo htmlspecialchars($message['subject']); ?></h2>
                    <span class="status-badge status-<?php echo $message['status']; ?>">
                        <?php echo ucfirst($message['status']); ?>
                    </span>
                </div>
                
                <div class="message-meta">
                    <div class="meta-item">
                        <div class="meta-label"><i class="fa-solid fa-user"></i> From</div>
                        <div class="meta-value"><?php echo htmlspecialchars($message['name']); ?></div>
                    </div>
                    
                    <div class="meta-item">
                        <div class="meta-label"><i class="fa-solid fa-envelope"></i> Email</div>
                        <div class="meta-value">
                            <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>" 
                               style="color: #3498db; text-decoration: none;">
                                <?php echo htmlspecialchars($message['email']); ?>
                            </a>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <div class="meta-label"><i class="fa-solid fa-phone"></i> Phone</div>
                        <div class="meta-value">
                            <?php if ($message['phone']): ?>
                                <a href="tel:<?php echo htmlspecialchars($message['phone']); ?>" 
                                   style="color: #3498db; text-decoration: none;">
                                    <?php echo htmlspecialchars($message['phone']); ?>
                                </a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="meta-item">
                        <div class="meta-label"><i class="fa-solid fa-calendar"></i> Date</div>
                        <div class="meta-value">
                            <?php echo date('F d, Y \a\t H:i', strtotime($message['created_at'])); ?>
                        </div>
                    </div>
                </div>
                
                <div class="message-content">
                    <h3><i class="fa-solid fa-message"></i> Message</h3>
                    <div class="message-text"><?php echo htmlspecialchars($message['message']); ?></div>
                </div>
                
                <div class="action-buttons">
                    <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>?subject=Re: <?php echo urlencode($message['subject']); ?>" 
                       class="btn btn-primary">
                        <i class="fa-solid fa-reply"></i> Reply via Email
                    </a>
                    
                    <?php if ($message['status'] !== 'replied'): ?>
                        <a href="admin_messages.php?action=mark_replied&id=<?php echo $message['message_id']; ?>" 
                           class="btn btn-success"
                           onclick="return confirm('Mark this message as replied?')">
                            <i class="fa-solid fa-check"></i> Mark as Replied
                        </a>
                    <?php endif; ?>
                    
                    <a href="admin_messages.php?action=delete&id=<?php echo $message['message_id']; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Are you sure you want to delete this message? This action cannot be undone.')">
                        <i class="fa-solid fa-trash"></i> Delete Message
                    </a>
                    
                    <a href="admin_messages.php" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Back to Messages
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
