<?php

require_once 'php/auth_check.php'; 
require_once 'php/session_cart.php';

$cartItems = getCartItems();
$cartTotal = getCartTotal();
$cartCount = getCartItemCount();

if (empty($cartItems)) {
    header('Location: cart.php');
    exit;
}

$customerName = getCustomerName();
$customerEmail = getCustomerEmail();
$customerPhone = isset($_SESSION['customer_phone']) ? $_SESSION['customer_phone'] : '';
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
    <link rel="stylesheet" href="./css/checkout.css">
    <script src="./java-script/cart.js"></script>
    <title>Checkout - Arvina</title>
</head>
<body>
    <header>
        <nav>
            <div class="h2">A R V I N A</div>
            <ul>
                <li class="li"><a href="home.php" class="aNav">HOME</a></li>
                <li class="li"><a href="" class="aNav">OFFERS</a></li>
                <li class="li"><a href="" class="aNav">FAQ</a></li>
                <li class="li"><a href="./about.html" class="aNav">ABOUT US</a></li>
                <li class="li"><a href="contact.php" class="aNav">CONTACT</a></li>
                <li class="li cart-link">
                    <a href="cart.php" class="aNav">
                        <i class="fa-solid fa-shopping-cart"></i> CART
                        <span id="cart-count" style="display:inline-block; background-color: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; margin-left: 5px;"><?php echo $cartCount; ?></span>
                    </a>
                </li>
                <li class="li user-welcome">
                    <span style="color: #3498db;"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($customerName); ?></span>
                </li>
                <button onclick="window.location.href='logout.php'"><i class="fa-solid fa-sign-out-alt"></i> LOGOUT</button>
            </ul>
        </nav>
    </header>

    <div class="checkout-container">
        <h1 class="checkout-title">Checkout</h1>
        
        <div class="checkout-content">
            <div class="checkout-form-section">
                <h2>Billing Information</h2>
                <form id="checkout-form" method="POST" action="php/process_order.php">
                    <div class="form-group">
                        <label for="customer_name">Full Name <span class="required">*</span></label>
                        <input type="text" id="customer_name" name="customer_name" required value="<?php echo htmlspecialchars($customerName); ?>">
                        <span class="error-message" id="name-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="customer_email">Email Address <span class="required">*</span></label>
                        <input type="email" id="customer_email" name="customer_email" required value="<?php echo htmlspecialchars($customerEmail); ?>">
                        <span class="error-message" id="email-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="customer_phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="customer_phone" name="customer_phone" placeholder="+94 XXX XXX XXX" required value="<?php echo htmlspecialchars($customerPhone); ?>">
                        <span class="error-message" id="phone-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="customer_address">Address <span class="required">*</span></label>
                        <textarea id="customer_address" name="customer_address" rows="3" required></textarea>
                        <span class="error-message" id="address-error"></span>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City <span class="required">*</span></label>
                            <input type="text" id="city" name="city" required>
                            <span class="error-message" id="city-error"></span>
                        </div>

                        <div class="form-group">
                            <label for="postal_code">Postal Code <span class="required">*</span></label>
                            <input type="text" id="postal_code" name="postal_code" required>
                            <span class="error-message" id="postal-error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Payment Method <span class="required">*</span></label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="">Select Payment Method</option>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="credit_card">Credit Card</option>
                        </select>
                        <span class="error-message" id="payment-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="order_notes">Order Notes (Optional)</label>
                        <textarea id="order_notes" name="order_notes" rows="3" placeholder="Any special instructions for your order..."></textarea>
                    </div>

                    <button type="submit" class="place-order-btn">Place Order</button>
                </form>
            </div>

            <div class="order-summary-section">
                <h2>Order Summary</h2>
                <div class="summary-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="summary-item">
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                            <div class="summary-item-details">
                                <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                                <p><?php echo htmlspecialchars($item['color']); ?> | <?php echo htmlspecialchars($item['size']); ?> | Qty: <?php echo $item['quantity']; ?></p>
                                <p class="summary-item-price">Rs <?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary-totals">
                    <div class="summary-row">
                        <span>Subtotal</span>
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
                </div>
            </div>
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

    <script>
        // Form validation
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            
            // Validate name
            const name = document.getElementById('customer_name').value.trim();
            if (name.length < 3) {
                document.getElementById('name-error').textContent = 'Name must be at least 3 characters';
                isValid = false;
            }
            
            // Validate email
            const email = document.getElementById('customer_email').value.trim();
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('email-error').textContent = 'Please enter a valid email address';
                isValid = false;
            }
            
            // Validate phone
            const phone = document.getElementById('customer_phone').value.trim();
            const phonePattern = /^[0-9+\s-]{10,}$/;
            if (!phonePattern.test(phone)) {
                document.getElementById('phone-error').textContent = 'Please enter a valid phone number';
                isValid = false;
            }
            
            // Validate address
            const address = document.getElementById('customer_address').value.trim();
            if (address.length < 10) {
                document.getElementById('address-error').textContent = 'Please enter a complete address';
                isValid = false;
            }
            
            // Validate city
            const city = document.getElementById('city').value.trim();
            if (city.length < 2) {
                document.getElementById('city-error').textContent = 'Please enter a valid city';
                isValid = false;
            }
            
            // Validate postal code
            const postal = document.getElementById('postal_code').value.trim();
            if (postal.length < 4) {
                document.getElementById('postal-error').textContent = 'Please enter a valid postal code';
                isValid = false;
            }
            
            // Validate payment method
            const payment = document.getElementById('payment_method').value;
            if (!payment) {
                document.getElementById('payment-error').textContent = 'Please select a payment method';
                isValid = false;
            }
            
            if (isValid) {
                this.submit();
            }
        });
    </script>
</body>
</html>
