<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once '../php/db_connect.php';

$success_message = '';
$error_message = '';

if (!isset($_GET['id'])) {
    header('Location: admin_products.php');
    exit;
}

$productId = intval($_GET['id']);
$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = sanitizeInput($_POST['product_name']);
    $category = sanitizeInput($_POST['category']);
    $subcategory = sanitizeInput($_POST['subcategory']);
    $description = sanitizeInput($_POST['description']);
    $price = floatval($_POST['price']);
    $discountPrice = isset($_POST['discount_price']) && $_POST['discount_price'] !== '' ? floatval($_POST['discount_price']) : 0.0;
    $stockQuantity = intval($_POST['stock_quantity']);
    $imageUrl = sanitizeInput($_POST['image_url']);
    
    $colors = isset($_POST['colors']) && $_POST['colors'] !== '' ? json_encode(array_map('trim', explode(',', $_POST['colors']))) : '[]';
    $sizes = isset($_POST['sizes']) && $_POST['sizes'] !== '' ? json_encode(array_map('trim', explode(',', $_POST['sizes']))) : '[]';
    
    $stmt = $conn->prepare("UPDATE products SET product_name = ?, category = ?, subcategory = ?, description = ?, price = ?, discount_price = ?, image_url = ?, stock_quantity = ?, available_colors = ?, available_sizes = ? WHERE product_id = ?");
    $stmt->bind_param("ssssddsissi", $productName, $category, $subcategory, $description, $price, $discountPrice, $imageUrl, $stockQuantity, $colors, $sizes, $productId);
    
    if ($stmt->execute()) {
        $success_message = "Product updated successfully!";
    } else {
        $error_message = "Error updating product: " . $stmt->error;
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    header('Location: admin_products.php');
    exit;
}

$colorsArray = json_decode($product['available_colors'], true);
$sizesArray = json_decode($product['available_sizes'], true);
$colorsString = is_array($colorsArray) ? implode(', ', $colorsArray) : '';
$sizesString = is_array($sizesArray) ? implode(', ', $sizesArray) : '';

closeDBConnection($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Edit Product - Arvina Admin</title>
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
                <a href="admin_logout.php" class="nav-item logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </nav>
        </aside>
        
        <main class="main-content">
            <header class="admin-header">
                <h1>Edit Product #<?php echo $product['product_id']; ?></h1>
                <a href="admin_products.php" class="action-btn secondary">
                    <i class="fa-solid fa-arrow-left"></i> Back to Products
                </a>
            </header>
            
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="POST" action="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="product_name">Product Name *</label>
                            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="category">Category *</label>
                            <select id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Men" <?php echo $product['category'] === 'Men' ? 'selected' : ''; ?>>Men</option>
                                <option value="Women" <?php echo $product['category'] === 'Women' ? 'selected' : ''; ?>>Women</option>
                                <option value="Accessories" <?php echo $product['category'] === 'Accessories' ? 'selected' : ''; ?>>Accessories</option>
                                <option value="Footwear" <?php echo $product['category'] === 'Footwear' ? 'selected' : ''; ?>>Footwear</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="subcategory">Subcategory</label>
                            <input type="text" id="subcategory" name="subcategory" value="<?php echo htmlspecialchars($product['subcategory']); ?>" placeholder="e.g., Shirts, Dresses">
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="price">Price (Rs) *</label>
                            <input type="number" step="0.01" id="price" name="price" value="<?php echo $product['price']; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="discount_price">Discount Price (Rs)</label>
                            <input type="number" step="0.01" id="discount_price" name="discount_price" value="<?php echo $product['discount_price'] > 0 ? $product['discount_price'] : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity *</label>
                            <input type="number" id="stock_quantity" name="stock_quantity" value="<?php echo $product['stock_quantity']; ?>" required>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="image_url">Image URL</label>
                            <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>" placeholder="./images/product.jpg">
                        </div>
                        
                        <div class="form-group">
                            <label for="colors">Available Colors (comma separated)</label>
                            <input type="text" id="colors" name="colors" value="<?php echo htmlspecialchars($colorsString); ?>" placeholder="Red, Blue, Green, White">
                        </div>
                        
                        <div class="form-group">
                            <label for="sizes">Available Sizes (comma separated)</label>
                            <input type="text" id="sizes" name="sizes" value="<?php echo htmlspecialchars($sizesString); ?>" placeholder="S, M, L, XL, XXL">
                        </div>
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="submit-btn">
                            <i class="fa-solid fa-save"></i> Update Product
                        </button>
                        <a href="admin_products.php" class="cancel-btn">
                            <i class="fa-solid fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
    
    <style>
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .button-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        
        .submit-btn {
            padding: 12px 30px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        
        .submit-btn:hover {
            background-color: #218838;
        }
        
        .cancel-btn {
            padding: 12px 30px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .cancel-btn:hover {
            background-color: #5a6268;
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
    </style>
</body>
</html>
