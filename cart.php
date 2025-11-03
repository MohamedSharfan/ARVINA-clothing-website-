<?php
require_once 'php/auth_check.php';
require_once 'php/session_cart.php';

// Handle update/remove form actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'], $_POST['cartKey'])) {
        $cartKey = $_POST['cartKey'];
        $action = $_POST['action'];

        switch ($action) {
            case 'remove':
                removeCartItem($cartKey);
                break;

            case 'update':
                $newQty = intval($_POST['quantity'] ?? 1);
                if ($newQty > 0) {
                    updateCartItem($cartKey, $newQty);
                }
                break;
        }
    }

    // Redirect to avoid resubmission on refresh
    header("Location: cart.php");
    exit;
}

// Load cart data after any updates
$cartItems = getCartItems();
$cartTotal = getCartTotal();
$cartCount = getCartItemCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Arvina</title>

    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<header id="navi">
        <nav>
            <div class="h2">A R V I N A</div>
            <ul>
                <li class="li"><a href="home.php" class="aNav active">HOME</a></li>
                <li class="li"><a href="#" class="aNav">OFFERS</a></li>
                <li class="li"><a href="#" class="aNav">FAQ</a></li>
                <li class="li"><a href="./about.php" class="aNav">ABOUT US</a></li>
                <li class="li"><a href="contact.php" class="aNav">CONTACT</a></li>

                <!-- 🛒 CART LINK -->
                <li class="li cart-link">
                    <a href="cart.php" class="aNav">
                        <i class="fa-solid fa-shopping-cart"></i> CART
                        <span id="cart-count" style="<?php echo $cartCount > 0 ? 'display:inline-block;' : 'display:none;'; ?> background-color:red; color:white; border-radius:50%; padding:2px 6px; font-size:12px; margin-left:5px;">
                            <?php echo $cartCount; ?>
                        </span>
                    </a>
                </li>

                <!-- 👤 USER INFO -->
                <li class="li user-welcome">
                    <span style="color:#3498db;"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($customerName); ?></span>
                </li>

                <button onclick="window.location.href='logout.php'">
                    <i class="fa-solid fa-sign-out-alt"></i> LOGOUT
                </button>
            </ul>
        </nav>
        
    </header>
<div style="padding:40px;"></div>
<div class="cart-container">
    <h1 class="cart-title">Shopping Cart</h1>

    <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <i class="fa-solid fa-shopping-cart" style="font-size: 80px; color: #ccc;"></i>
            <h2>Your cart is empty</h2>
            <p>Add some products to get started!</p>
            <a href="home.php" class="continue-shopping">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="cart-content">
            <div class="cart-items">
                <?php foreach ($cartItems as $cartKey => $item): 
                    $imagePath = $item['image_url'];
                    if (strpos($imagePath, '../') === 0) {
                        $imagePath = substr($imagePath, 3);
                    }
                ?>
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                        </div>

                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                            <p class="item-specs">
                                Color: <strong><?php echo htmlspecialchars($item['color']); ?></strong> |
                                Size: <strong><?php echo htmlspecialchars($item['size']); ?></strong>
                            </p>
                            <p class="item-price">Rs <?php echo number_format($item['price'], 2); ?></p>
                        </div>

                        <div class="item-quantity">
                            <form method="post" style="display:inline-block;">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="cartKey" value="<?php echo htmlspecialchars($cartKey); ?>">
                                <input type="hidden" name="quantity" value="<?php echo max(1, $item['quantity'] - 1); ?>">
                                <button type="submit">-</button>
                            </form>

                            <input type="number" value="<?php echo $item['quantity']; ?>" min="1" max="10" readonly>

                            <form method="post" style="display:inline-block;">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="cartKey" value="<?php echo htmlspecialchars($cartKey); ?>">
                                <input type="hidden" name="quantity" value="<?php echo $item['quantity'] + 1; ?>">
                                <button type="submit">+</button>
                            </form>
                        </div>

                        <div class="item-subtotal">
                            <p>Rs <?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                        </div>

                        <div class="item-remove">
                            <form method="post" onsubmit="return confirm('Remove this item?');">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="cartKey" value="<?php echo htmlspecialchars($cartKey); ?>">
                                <button type="submit" title="Remove item">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <h2>Order Summary</h2>
                <div class="summary-row">
                    <span>Subtotal (<?php echo $cartCount; ?> items)</span>
                    <span>Rs <?php echo number_format($cartTotal, 2); ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rs <?php echo number_format($cartTotal, 2); ?></span>
                </div>

                <button class="checkout-btn" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
                <a href="home.php" class="continue-shopping">Continue Shopping</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<footer class="foot">
    <div class="full-wrapper">
        <div class="about-wrapper">
            <h4>More About Company</h4>
            <p>
                Embrace timeless elegance with our Old Money Clothing collection—where sophistication meets heritage.
                We blend classic fashion with modern craftsmanship to bring you premium-quality apparel that exudes
                quiet luxury.
            </p>
        </div>
        <div class="social-wrapper">
            <h4>Contact Information</h4>
            <ul class="contact-list">
                <li><i class="fa-solid fa-map-location"></i> 67/2, Main Street, Colombo</li>
                <li><i class="fa-solid fa-id-badge"></i> +94 777 767 8678</li>
                <li><i class="fa-solid fa-square-envelope"></i> oldmoneyclothing@gmail.com</li>
            </ul>
        </div>
    </div>
</footer>
</body>
</html>