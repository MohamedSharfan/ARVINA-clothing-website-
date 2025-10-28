<?php


require_once 'php/db_connect.php';
require_once 'php/session_cart.php';


if (!isset($_GET['order_id']) || !isset($_SESSION['last_order_id'])) {
    header('Location: home.php');
    exit;
}

$orderId = intval($_GET['order_id']);


if ($orderId !== $_SESSION['last_order_id']) {
    header('Location: home.php');
    exit;
}


$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    header('Location: home.php');
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
closeDBConnection($conn);

unset($_SESSION['last_order_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./css/confirmation.css">
    <title>Order Confirmation - Arvina</title>
</head>
<body>
    <header>
        <nav>
            <div class="h2">A R V I N A</div>
            <ul>
                <li class="li"><a href="home.html" class="aNav">HOME</a></li>
                <li class="li"><a href="" class="aNav">OFFERS</a></li>
                <li class="li"><a href="" class="aNav">FAQ</a></li>
                <li class="li"><a href="./about.html" class="aNav">ABOUT US</a></li>
                <li class="li"><a href="./contactus.html" class="aNav">CONTACT</a></li>
                <button onclick="window.location.href='home.html'">LOGIN</button>
            </ul>
        </nav>
    </header>

    <div class="confirmation-container">
        <div class="success-icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <h1>Order Placed Successfully!</h1>
        <p class="thank-you-message">Thank you for your order. We've received your order and will process it shortly.</p>
        
        <div class="order-details-box">
            <h2>Order Details</h2>
            <div class="detail-row">
                <span class="label">Order Number:</span>
                <span class="value">#<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Order Date:</span>
                <span class="value"><?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Total Amount:</span>
                <span class="value">Rs <?php echo number_format($order['total_amount'], 2); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Payment Method:</span>
                <span class="value"><?php echo ucwords(str_replace('_', ' ', $order['payment_method'])); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value status-pending"><?php echo ucfirst($order['order_status']); ?></span>
            </div>
        </div>

        <div class="shipping-details-box">
            <h2>Shipping Information</h2>
            <div class="detail-row">
                <span class="label">Name:</span>
                <span class="value"><?php echo htmlspecialchars($order['customer_name']); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value"><?php echo htmlspecialchars($order['customer_email']); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Phone:</span>
                <span class="value"><?php echo htmlspecialchars($order['customer_phone']); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Address:</span>
                <span class="value"><?php echo htmlspecialchars($order['customer_address']); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">City:</span>
                <span class="value"><?php echo htmlspecialchars($order['city']); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Postal Code:</span>
                <span class="value"><?php echo htmlspecialchars($order['postal_code']); ?></span>
            </div>
        </div>

        <div class="order-items-box">
            <h2>Order Items</h2>
            <?php foreach ($orderItems as $item): ?>
                <div class="order-item-row">
                    <div class="item-info">
                        <strong><?php echo htmlspecialchars($item['product_name']); ?></strong>
                        <span class="item-specs"><?php echo htmlspecialchars($item['selected_color']); ?> | <?php echo htmlspecialchars($item['selected_size']); ?> | Qty: <?php echo $item['quantity']; ?></span>
                    </div>
                    <div class="item-price">
                        Rs <?php echo number_format($item['subtotal'], 2); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="confirmation-message">
            <p><i class="fa-solid fa-envelope"></i> A confirmation email has been sent to <strong><?php echo htmlspecialchars($order['customer_email']); ?></strong></p>
            <p><i class="fa-solid fa-info-circle"></i> You can track your order status by contacting our customer service.</p>
        </div>

        <div class="action-buttons">
            <a href="home.html" class="btn-primary">Continue Shopping</a>
            <button onclick="window.print()" class="btn-secondary">Print Order</button>
        </div>
    </div>

    <footer class="foot">
        <div class="full-wrapper">
            <div class="about-wrapper">
                <div class="about">
                    <h4>More About Company</h4>
                </div>
                <div class="about-content">
                    <p>
                        Embrace timeless elegance with our Old Money Clothing collection—where sophistication meets
                        heritage. We blend classic fashion with modern craftsmanship to bring you premium-quality
                        apparel that exudes quiet luxury.
                    </p>
                </div>
            </div>
            <div class="social-wrapper">
                <h4>Contact Information</h4>
                <ul class="contact-list">
                    <li><i class="fa-solid fa-map-location"></i>67/2, Main street,Colombo</li>
                    <li><i class="fa-solid fa-id-badge"></i>+94777678678</li>
                    <li><i class="fa-solid fa-square-envelope"></i>oldmoneyclothing@gmail.com</li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
