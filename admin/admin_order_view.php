<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once '../php/db_connect.php';

if (!isset($_GET['id'])) {
    header('Location: admin_orders.php');
    exit;
}

$orderId = intval($_GET['id']);
$conn = getDBConnection();

$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    header('Location: admin_orders.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$orderItems = array();
while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row;
}
$stmt->close();

if (isset($_POST['update_status'])) {
    $newStatus = sanitizeInput($_POST['order_status']);
    
    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $newStatus, $orderId);
    
    if ($stmt->execute()) {
        $success_message = "Order status updated successfully!";
        $order['order_status'] = $newStatus;
    } else {
        $error_message = "Error updating order status.";
    }
    $stmt->close();
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
    <title>Order #<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?> - Arvina Admin</title>
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
                <a href="admin_orders.php" class="nav-item active">
                    <i class="fa-solid fa-shopping-bag"></i> Orders
                </a>
                <a href="admin_messages.php" class="nav-item">
                    <i class="fa-solid fa-envelope"></i> Messages
                </a>
                <a href="admin_logout.php" class="nav-item logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="main-content">
            <header class="admin-header">
                <h1>Order Details #<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></h1>
                <div class="admin-user">
                    <i class="fa-solid fa-user-circle"></i>
                    <span><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>
            </header>
            
            <div class="back-link-container">
                <a href="admin_orders.php" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i> Back to Orders
                </a>
            </div>
            
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <div class="order-view-container">
                <div class="order-info-section">
                    <div class="info-card">
                        <h3><i class="fa-solid fa-info-circle"></i> Order Information</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Order ID:</label>
                                <span>#<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Order Date:</label>
                                <span><?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Total Amount:</label>
                                <span class="amount">Rs <?php echo number_format($order['total_amount'], 2); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Payment Method:</label>
                                <span><?php echo ucwords(str_replace('_', ' ', $order['payment_method'])); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Current Status:</label>
                                <span class="status-badge status-<?php echo $order['order_status']; ?>">
                                    <?php echo ucfirst($order['order_status']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3><i class="fa-solid fa-user"></i> Customer Information</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Name:</label>
                                <span><?php echo htmlspecialchars($order['customer_name']); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Email:</label>
                                <span><?php echo htmlspecialchars($order['customer_email']); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Phone:</label>
                                <span><?php echo htmlspecialchars($order['customer_phone']); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3><i class="fa-solid fa-truck"></i> Shipping Address</h3>
                        <div class="shipping-address">
                            <p><?php echo htmlspecialchars($order['customer_address']); ?></p>
                            <p><?php echo htmlspecialchars($order['city']); ?>, <?php echo htmlspecialchars($order['postal_code']); ?></p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3><i class="fa-solid fa-edit"></i> Update Order Status</h3>
                        <form method="POST" action="" class="status-update-form">
                            <div class="form-group">
                                <select name="order_status" class="status-select" required>
                                    <option value="pending" <?php echo $order['order_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="processing" <?php echo $order['order_status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                    <option value="shipped" <?php echo $order['order_status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                    <option value="delivered" <?php echo $order['order_status'] === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                    <option value="cancelled" <?php echo $order['order_status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" name="update_status" class="btn-primary">
                                <i class="fa-solid fa-check"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="order-items-section">
                    <div class="info-card">
                        <h3><i class="fa-solid fa-shopping-bag"></i> Order Items</h3>
                        <div class="items-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderItems as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($item['selected_color']); ?></td>
                                            <td><?php echo htmlspecialchars($item['selected_size']); ?></td>
                                            <td><?php echo $item['quantity']; ?></td>
                                            <td>Rs <?php echo number_format($item['unit_price'], 2); ?></td>
                                            <td>Rs <?php echo number_format($item['subtotal'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
                                        <td><strong>Rs <?php echo number_format($order['total_amount'], 2); ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <style>
        .back-link-container {
            margin-bottom: 20px;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 6px;
            border: 1px solid #667eea;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            background: #667eea;
            color: white;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .order-view-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .order-items-section {
            grid-column: 1 / -1;
        }
        
        .info-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        
        .info-card h3 {
            margin-bottom: 20px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-grid {
            display: grid;
            gap: 15px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-item label {
            font-weight: 600;
            color: #666;
        }
        
        .info-item span {
            color: #333;
        }
        
        .amount {
            font-size: 1.2em;
            font-weight: bold;
            color: #28a745;
        }
        
        .shipping-address {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        
        .shipping-address p {
            margin: 5px 0;
            color: #333;
        }
        
        .status-update-form {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }
        
        .status-update-form .form-group {
            flex: 1;
            margin: 0;
        }
        
        .status-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }
        
        .btn-primary {
            padding: 12px 30px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #218838;
        }
        
        .items-table {
            overflow-x: auto;
        }
        
        .items-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .items-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .items-table tfoot td {
            font-weight: bold;
            border-top: 2px solid #333;
            border-bottom: none;
        }
        
        @media (max-width: 768px) {
            .order-view-container {
                grid-template-columns: 1fr;
            }
            
            .status-update-form {
                flex-direction: column;
            }
            
            .btn-primary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</body>
</html>
