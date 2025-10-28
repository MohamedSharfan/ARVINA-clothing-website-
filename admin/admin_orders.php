<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once '../php/db_connect.php';

$conn = getDBConnection();


if (isset($_POST['update_status'])) {
    $orderId = intval($_POST['order_id']);
    $newStatus = sanitizeInput($_POST['order_status']);
    
    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $newStatus, $orderId);
    
    if ($stmt->execute()) {
        $success_message = "Order status updated successfully!";
    } else {
        $error_message = "Error updating order status.";
    }
    $stmt->close();
}


$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';


if ($statusFilter === 'all') {
    $result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
} else {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_status = ? ORDER BY order_date DESC");
    $stmt->bind_param("s", $statusFilter);
    $stmt->execute();
    $result = $stmt->get_result();
}

$orders = array();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
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
    <title>Orders Management - Arvina Admin</title>
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
                <h1>Orders Management</h1>
                <div class="admin-user">
                    <i class="fa-solid fa-user-circle"></i>
                    <span><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>
            </header>
            
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <div class="filter-bar">
                <a href="?status=all" class="filter-btn <?php echo $statusFilter === 'all' ? 'active' : ''; ?>">All Orders</a>
                <a href="?status=pending" class="filter-btn <?php echo $statusFilter === 'pending' ? 'active' : ''; ?>">Pending</a>
                <a href="?status=processing" class="filter-btn <?php echo $statusFilter === 'processing' ? 'active' : ''; ?>">Processing</a>
                <a href="?status=shipped" class="filter-btn <?php echo $statusFilter === 'shipped' ? 'active' : ''; ?>">Shipped</a>
                <a href="?status=delivered" class="filter-btn <?php echo $statusFilter === 'delivered' ? 'active' : ''; ?>">Delivered</a>
            </div>
            
            <div class="data-table">
                <div class="table-header">
                    <h2>Orders (<?php echo count($orders); ?>)</h2>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                <td>Rs <?php echo number_format($order['total_amount'], 2); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $order['order_status']; ?>">
                                        <?php echo ucfirst($order['order_status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($order['order_date'])); ?></td>
                                <td>
                                    <a href="admin_order_view.php?id=<?php echo $order['order_id']; ?>" class="btn-small btn-view">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                    <button onclick="showUpdateModal(<?php echo $order['order_id']; ?>, '<?php echo $order['order_status']; ?>')" class="btn-small btn-edit">
                                        <i class="fa-solid fa-edit"></i> Update
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <!-- Update Status Modal -->
    <div id="updateModal" style="display:none;">
        <div class="modal-overlay" onclick="closeModal()"></div>
        <div class="modal-content">
            <h2>Update Order Status</h2>
            <form method="POST" action="">
                <input type="hidden" name="order_id" id="modal_order_id">
                <div class="form-group">
                    <label for="order_status">Select New Status:</label>
                    <select name="order_status" id="modal_order_status" required>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="modal-buttons">
                    <button type="button" onclick="closeModal()" class="btn-secondary">Cancel</button>
                    <button type="submit" name="update_status" class="btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
    
    <style>
        .filter-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .filter-btn {
            padding: 10px 20px;
            background: white;
            color: #333;
            text-decoration: none;
            border-radius: 6px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background-color: #667eea;
            color: white;
            border-color: #667eea;
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
        
        #updateModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }
        
        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
        }
        
        .modal-content h2 {
            margin-bottom: 20px;
        }
        
        .modal-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .modal-buttons button {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: #28a745;
            color: white;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
    
    <script>
        function showUpdateModal(orderId, currentStatus) {
            document.getElementById('modal_order_id').value = orderId;
            document.getElementById('modal_order_status').value = currentStatus;
            document.getElementById('updateModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('updateModal').style.display = 'none';
        }
    </script>
</body>
</html>
