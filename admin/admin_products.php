<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once '../php/db_connect.php';

$conn = getDBConnection();


if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        $success_message = "Product deleted successfully!";
    } else {
        $error_message = "Error deleting product.";
    }
    $stmt->close();
}


$result = $conn->query("SELECT * FROM products ORDER BY product_id DESC");
$products = array();
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
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
    <title>Products Management - Arvina Admin</title>
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
                <a href="admin_products.php" class="nav-item active">
                    <i class="fa-solid fa-shirt"></i> Products
                </a>
                <a href="admin_orders.php" class="nav-item">
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
                <h1>Products Management</h1>
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
            
            <div class="data-table">
                <div class="table-header">
                    <h2>All Products (<?php echo count($products); ?>)</h2>
                    <a href="admin_product_add.php" class="action-btn primary">
                        <i class="fa-solid fa-plus"></i> Add New Product
                    </a>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['product_id']; ?></td>
                                <td>
                                    <?php if ($product['image_url']): ?>
                                        <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" 
                                             alt="Product" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    <?php else: ?>
                                        <i class="fa-solid fa-image" style="font-size: 30px; color: #ccc;"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['category']); ?></td>
                                <td>Rs <?php echo number_format($product['price'], 2); ?></td>
                                <td><?php echo $product['stock_quantity']; ?></td>
                                <td>
                                    <a href="admin_product_edit.php?id=<?php echo $product['product_id']; ?>" class="btn-small btn-edit">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </a>
                                    <a href="?delete_id=<?php echo $product['product_id']; ?>" 
                                       class="btn-small btn-delete"
                                       onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</body>
</html>
