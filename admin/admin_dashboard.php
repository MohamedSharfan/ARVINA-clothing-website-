<?php

session_start();


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once '../php/db_connect.php';


$conn = getDBConnection();

$result = $conn->query("SELECT COUNT(*) as count FROM products");
$totalProducts = $result->fetch_assoc()['count'];


$result = $conn->query("SELECT COUNT(*) as count FROM orders");
$totalOrders = $result->fetch_assoc()['count'];


$result = $conn->query("SELECT COUNT(*) as count FROM orders WHERE order_status = 'pending'");
$pendingOrders = $result->fetch_assoc()['count'];


$result = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE order_status != 'cancelled'");
$totalRevenue = $result->fetch_assoc()['total'] ?? 0;


$result = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE status = 'new'");
$newMessages = $result->fetch_assoc()['count'];

closeDBConnection($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Admin Dashboard - Arvina</title>
</head>
<body class="admin-page">
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>ARVINA</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <a href="admin_dashboard.php" class="nav-item active">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
                <a href="admin_products.php" class="nav-item">
                    <i class="fa-solid fa-shirt"></i> Products
                </a>
                <a href="admin_orders.php" class="nav-item">
                    <i class="fa-solid fa-shopping-bag"></i> Orders
                </a>
                <a href="admin_messages.php" class="nav-item">
                    <i class="fa-solid fa-envelope"></i> Messages
                    <?php if ($newMessages > 0): ?>
                        <span style="background: #e74c3c; color: white; padding: 2px 8px; border-radius: 10px; margin-left: 5px; font-size: 11px;"><?php echo $newMessages; ?></span>
                    <?php endif; ?>
                </a>
                <a href="admin_logout.php" class="nav-item logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="main-content">
            <header class="admin-header">
                <h1>Dashboard</h1>
                <div class="admin-user">
                    <i class="fa-solid fa-user-circle"></i>
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>
            </header>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon products">
                        <i class="fa-solid fa-shirt"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo $totalProducts; ?></h3>
                        <p>Total Products</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon orders">
                        <i class="fa-solid fa-shopping-bag"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo $totalOrders; ?></h3>
                        <p>Total Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo $pendingOrders; ?></h3>
                        <p>Pending Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon revenue">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                    <div class="stat-details">
                        <h3>Rs <?php echo number_format($totalRevenue, 2); ?></h3>
                        <p>Total Revenue</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="stat-details">
                        <h3><?php echo $newMessages; ?></h3>
                        <p>New Messages</p>
                    </div>
                </div>
            </div>
            
            <div class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="admin_products.php?action=add" class="action-btn primary">
                        <i class="fa-solid fa-plus"></i> Add New Product
                    </a>
                    <a href="admin_orders.php" class="action-btn secondary">
                        <i class="fa-solid fa-eye"></i> View All Orders
                    </a>
                    <a href="admin_orders.php?status=pending" class="action-btn warning">
                        <i class="fa-solid fa-clock"></i> Pending Orders
                    </a>
                    <a href="admin_messages.php?status=new" class="action-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <i class="fa-solid fa-envelope"></i> New Messages
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
