<?php
session_start();

// Simple PHP cart handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $cartKey = $_POST['product_id'] . '_' . $_POST['color'] . '_' . $_POST['size'];
    
    $cartItem = [
        'product_id' => $_POST['product_id'],
        'product_name' => $_POST['product_name'],
        'price' => $_POST['price'],
        'color' => $_POST['color'],
        'size' => $_POST['size'],
        'quantity' => $_POST['quantity'],
        'image_url' => $_POST['image_url']
    ];
    
    $_SESSION['cart'][$cartKey] = $cartItem;
    
    echo '<script>alert("✅ ' . $_POST['product_name'] . ' added to cart!");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="footwear.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap">
    <title>ARVINA | Footwear Collection</title>
    <style>
        .cart-count {
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            margin-left: 5px;
        }
        .form-group {
            margin: 10px 0;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        select, input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <header id="navi">
        <nav>
            <div class="h2">A R V I N A</div>
            <ul>
                <li class="li"><a href="home.html" class="aNav">HOME</a></li>
                <li class="li"><a href="#off" class="aNav">OFFERS</a></li>
                <li class="li"><a href="about.html" class="aNav">ABOUT US</a></li>
                <li class="li"><a href="#contact" class="aNav">CONTACT</a></li>
                <li class="li">
                    <a href="cart.php" class="aNav">
                        <i class="fas fa-shopping-bag"></i>
                        CART 
                        <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="cart-count"><?php echo count($_SESSION['cart']); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <button onclick="displayLogin()">LOGIN</button>
            </ul>
        </nav>
    </header>

    <div id="full">
        <section class="footwear-hero">
            <div class="hero-text">
                <h1>ARVINA FOOTWEAR</h1>
                <p>Step into sophistication with our premium footwear collection</p>
            </div>
        </section>

        <!-- Categories -->
        <section class="footwear-categories">
            <h2>OUR COLLECTIONS</h2>
            <div class="category-grid">
                <div class="category-card">
                    <img src="pics/mencat.jpeg" alt="Men's Footwear">
                    <h3>MEN'S</h3>
                </div>
                <div class="category-card">
                    <img src="pics/womencat.jpeg" alt="Women's Footwear">
                    <h3>WOMEN'S</h3>
                </div>
                <div class="category-card">
                    <img src="pics/casualcat.jpg" alt="Casual Footwear">
                    <h3>CASUAL</h3>
                </div>
                <div class="category-card">
                    <img src="pics/formalcat.jpeg" alt="Formal Footwear">
                    <h3>FORMAL</h3>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="featured-footwear">
            <h2>FEATURED FOOTWEAR</h2>
            <div class="product-grid">
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="product-images">
                        <img src="pics/classic.webp" class="main-img" alt="Classic Oxford">
                        <img src="pics/classicside.webp" class="hover-img" alt="Classic Oxford Side View">
                    </div>
                    <h3>Classic Oxford</h3>
                    <p class="price">Rs.12,500.00</p>
                    
                    <form method="POST" class="product-form">
                        <input type="hidden" name="product_id" value="FW001">
                        <input type="hidden" name="product_name" value="Classic Oxford">
                        <input type="hidden" name="price" value="12500.00">
                        <input type="hidden" name="image_url" value="pics/classic.webp">
                        <input type="hidden" name="color" value="black">
                        
                        <div class="form-group">
                            <label>Size:</label>
                            <select name="size" required>
                                <option value="">Select Size</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Quantity:</label>
                            <input type="number" name="quantity" value="1" min="1" max="10" required>
                        </div>
                        
                        <button type="submit" class="add-to-cart">ADD TO CART</button>
                    </form>
                </div>
                
                <!-- Product 2 -->
                <div class="product-card">
                    <div class="product-images">
                        <img src="pics/loaferfront.webp" class="main-img" alt="Modern Loafers">
                        <img src="pics/loaferside.webp" class="hover-img" alt="Modern Loafers Side View">
                    </div>
                    <h3>Modern Loafers</h3>
                    <p class="price">Rs.10,800.00</p>
                    
                    <form method="POST" class="product-form">
                        <input type="hidden" name="product_id" value="FW002">
                        <input type="hidden" name="product_name" value="Modern Loafers">
                        <input type="hidden" name="price" value="10800.00">
                        <input type="hidden" name="image_url" value="pics/loaferfront.webp">
                        <input type="hidden" name="color" value="brown">
                        
                        <div class="form-group">
                            <label>Size:</label>
                            <select name="size" required>
                                <option value="">Select Size</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Quantity:</label>
                            <input type="number" name="quantity" value="1" min="1" max="10" required>
                        </div>
                        
                        <button type="submit" class="add-to-cart">ADD TO CART</button>
                    </form>
                </div>
                
                <!-- Product 3 -->
                <div class="product-card">
                    <div class="product-images">
                        <img src="pics/heelsside.jpeg.jpg" class="main-img" alt="Elegant Pumps">
                        <img src="pics/heels.jpg" class="hover-img" alt="Elegant Pumps Side View">
                    </div>
                    <h3>Elegant Pumps</h3>
                    <p class="price">Rs.9,900.00</p>
                    
                    <form method="POST" class="product-form">
                        <input type="hidden" name="product_id" value="FW003">
                        <input type="hidden" name="product_name" value="Elegant Pumps">
                        <input type="hidden" name="price" value="9900.00">
                        <input type="hidden" name="image_url" value="pics/heelsside.jpeg.jpg">
                        <input type="hidden" name="color" value="black">
                        
                        <div class="form-group">
                            <label>Size:</label>
                            <select name="size" required>
                                <option value="">Select Size</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Quantity:</label>
                            <input type="number" name="quantity" value="1" min="1" max="10" required>
                        </div>
                        
                        <button type="submit" class="add-to-cart">ADD TO CART</button>
                    </form>
                </div>
                
                <!-- Product 4 -->
                <div class="product-card">
                    <div class="product-images">
                        <img src="pics/sneakerfront.jpeg" class="main-img" alt="Sporty Sneakers">
                        <img src="pics/sneakerside.jpeg" class="hover-img" alt="Sporty Sneakers Side View">
                    </div>
                    <h3>Sporty Sneakers</h3>
                    <p class="price">Rs.8,500.00</p>
                    
                    <form method="POST" class="product-form">
                        <input type="hidden" name="product_id" value="FW004">
                        <input type="hidden" name="product_name" value="Sporty Sneakers">
                        <input type="hidden" name="price" value="8500.00">
                        <input type="hidden" name="image_url" value="pics/sneakerfront.jpeg">
                        <input type="hidden" name="color" value="white">
                        
                        <div class="form-group">
                            <label>Size:</label>
                            <select name="size" required>
                                <option value="">Select Size</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Quantity:</label>
                            <input type="number" name="quantity" value="1" min="1" max="10" required>
                        </div>
                        
                        <button type="submit" class="add-to-cart">ADD TO CART</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Special Offer -->
        <section class="footwear-offer" id="off">
            <div class="offer-content">
                <h2>LIMITED TIME OFFER</h2>
                <p>Get 20% off on all footwear collections</p>
                <p class="offer-code">Use code: STEPIN20</p>
                <button class="shop-now">SHOP NOW</button>
            </div>
        </section>

        <!-- Customer Support -->
        <section class="cutomersupport">
            <div class="sec">
                <div class="freeShipping">
                    <span class="material-symbols-outlined">package_2</span>
                    <div class="shippingtxt">FREE SHIPPING</div>
                    <div class="shippingpara">We offer free worldwide shipping on orders over Rs.50000.00</div>
                </div>
                <div class="cutomersup">
                    <span class="material-symbols-outlined">support_agent</span>
                    <div class="custtxt">CUSTOMER SERVICE</div>
                    <div class="shippingpara">Our customer service team will available Monday till Friday 9am to 9pm</div>
                </div>
                <div class="payment">
                    <span class="material-symbols-outlined">sell</span>
                    <div class="custtxt">SECURE PAYMENT</div>
                    <div class="shippingpara">We use trusted encryption technology and secure payment gateways.</div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="foot">
        <div class="full-wrapper">
            <div class="about-wrapper">
                <div class="about">
                    <h4>More About Company</h4>
                </div>
                <div class="about-content">
                    <p>Embrace timeless elegance with our Old Money Clothing collection—where sophistication meets heritage. We blend classic fashion with modern craftsmanship to bring you premium-quality apparel that exudes quiet luxury.</p>
                </div>
            </div>
            <div class="social-wrapper" id="contact">
                <h4>Contact Information</h4>
                <ul class="contact-list">
                    <li><i class="fa-solid fa-map-location"></i>67/2, Main street, Colombo</li>
                    <li><i class="fa-solid fa-id-badge"></i>+94777678678</li>
                    <li><i class="fa-solid fa-square-envelope"></i>oldmoneyclothing@gmail.com</li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>