<?php
session_start();

// Ensure user is logged in
$isLoggedIn = isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] === true;
if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

// Load cart session helpers
require_once './php/session_cart.php';

$customerName = isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : 'User';
$cartCount = getCartItemCount();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accessories | Your Clothing Store</title>
    <link rel="stylesheet" href="accessories.css" />
    <link rel="stylesheet" href="footer.css" />
    <link rel="stylesheet" href="nav.css" />

</head>

<body>
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

    <!-- Hero Banner -->
    <section class="hero-banner">
        <h1>Accessories Collection</h1>
        <p>Complete your look with the perfect accessories!</p>
    </section>

    <!-- Accessories Grid -->
    <section class="accessories-container">
        <div class="accessory-card">
            <h3>Stylish Sunglasses</h3>
            <img src="images/sunglasses.jpg" alt="Sunglasses" />
            <p>$25</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Elegant Handbag</h3>
            <img src="images/handbag.jpg" alt="Handbag" />
            <p>$40</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Gold Necklace</h3>
            <img src="images/necklace.jpg" alt="Necklace" />
            <p>$30</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Fashionable Watch</h3>
            <img src="images/watch.jpg" alt="Sunglasses" />
            <p>$25</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Trendy Cap</h3>
            <img src="images/cap.jpg" alt="Handbag" />
            <p>$40</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Minimalist Tie</h3>
            <img src="images/tie.jpg" alt="Necklace" />
            <p>$30</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Leather Wallet</h3>
            <img src="images/wallet.jpg" alt="Sunglasses" />
            <p>$25</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Winter Gloves</h3>
            <img src="images/gloves.jpg" alt="Handbag" />
            <p>$40</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Sporty Duffel Bag</h3>
            <img src="images/duffelbag.jpg" alt="Necklace" />
            <p>$30</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Travel Backpack</h3>
            <img src="images/backpack.jpg" alt="Sunglasses" />
            <p>$25</p>
            <button>Add to Cart</button>
        </div>

        <div class="accessory-card">
            <h3>Hair Clip Set</h3>
            <img src="images/hairclip.jpg" alt="Handbag" />
            <p>$40</p>
            <button>Add to Cart</button>
        </div>
    </section>

    <footer class="foot">
        <div class="full-wrapper">
            <div class="about-wrapper">
                <div class="about">
                    <h4>More About Company</h4>
                </div>
                <div class="about-content">
                    <p>
                        Embrace timeless elegance with our Old Money Clothing collection—where sophistication meets heritage. We blend classic fashion with modern craftsmanship to bring you premium-quality apparel that exudes quiet luxury. Elevate your wardrobe with pieces inspired by the refined aesthetics of the past. Stay connected with us for exclusive collections and style updates.
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
        <div class="social-icons">

        </div>
    </footer>

    <script src="accessories.js"></script>
</body>

</html>