<?php

session_start();

$isLoggedIn = isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] === true;

if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

$customerName = isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./nav.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <script src="./homeScript.js"></script>
    <script src="./java-script/load-product-category.js"></script>
    <script src="./java-script/cart.js"></script>
    <script>
        window.onload = function () {
            renderProducts();
        };
    </script>
    <title>Home - Arvina</title>
</head>
<body>
    <header id="navi">
        <nav>
            <div class="h2">A R V I N A</div>
            <ul>
                <li class="li"><a href="#o" class="aNav">OFFERS</a></li>
                <li class="li"><a href="" class="aNav">FAQ</a></li>
                <li class="li"><a href="./about.html" class="aNav">ABOUT US</a></li>
                <li class="li"><a href="contact.php" class="aNav">CONTACT</a></li>
                <li class="li cart-link">
                    <a href="cart.php" class="aNav">
                        <i class="fa-solid fa-shopping-cart"></i> CART
                        <span id="cart-count" style="display:none; background-color: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; margin-left: 5px;">0</span>
                    </a>
                </li>
                <li class="li user-welcome">
                    <span style="color: #3498db;"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($customerName); ?></span>
                </li>
                <button onclick="window.location.href='logout.php'"><i class="fa-solid fa-sign-out-alt"></i> LOGOUT</button>
            </ul>
        </nav>
    </header>

<div id="full">
    <section class="home">
        <div class="home-text2" reveal>ELEVATE YOUR STYLE</div>
        <div class="home-text1" reveal>TIMELESS ELEGANCE</div>
        <a href="#c"><div class="best"><button class="btn" onclick="scrollSmooth()">SHOP BEST SELLERS</button></div></a>
    </section>
    <section class="home2">
        <div class="homeButton">
            <div class="all"><a href="./accessories.html"><button class="btn1">ACCESSORIES</button></a></div>
            <div class="bestsellers"><a href=""><button class="btn1">FAQ</button></a></div>
            <a href="#c"><div class="us"><button class="btn1">BEST SELLERS</button></div></a>
            <div class="men"><a href="./men/men.html"><button class="btn1">MEN</button></a></div>
            <div class="women"><a href="./women/women.html"><button class="btn1">WOMEN</button></a></div>
            <div class="shoes"><a href="./footwear.php"><button class="btn1">FOOTWEAR</button></a></div>
        </div>
        <div class="oldmoney-text"><h5>OLD MONEY FOR THE MODERN WORLD</h5></div><a name="c"></a>
        <div class="oldmoney-text"><p>Crafted for those who appreciate the quiet luxury of well-made things. Every detail, every stitch, made to last.</p></div>
        
        <div class="bestCatog">
            <div class="bestTitle">Best Sellers</div>

            <div class="imgContainer">
                <div class="imgtxt">
                    <div class="txt">TeaBek sweat shirt Rs.5450.00</div>
                    <img src="./images/shirt five front.jpeg" width="300px" class="main_img1">
                    <img src="./images/shirt five zoom.jpeg" alt="" class="hover_img1">
                </div>
                <div class="imgtxt">
                    <div class="txt">Lined Kinin shirt Rs.4500.00</div>
                    <img src="./images/shirt one front.jpeg" width="300px" class="main_img1">
                    <img src="./images/shirt one back.jpeg" alt="" class="hover_img2">
                </div>
                <div class="imgtxt">
                    <div class="txt">Jakipak Shirt Rs.6700.00</div>
                    <img src="./images/shirt four front.jpeg" width="300px" class="main_img3">
                    <img src="./images/shirt four zoom.jpeg" alt="" class="hover_img3">
                </div>
                <div class="imgtxt">
                    <div class="txt">Pincy Skirt Rs.9700.00</div>
                    <img src="./images/women 13 front.jpg" width="300px" class="main_img3">
                    <img src="./images/women 13 side.jpg" alt="" class="hover_img3">
                </div>
            </div>
        </div>
        <a name="o"></a>

        <div class="sale">
            <div class="summer">SUMMER SALE</div>
            <div class="off50">UP TO 50% OFF</div>
            <div class="shopnow"><button class="shopnow-btn">SHOP NOW</button></div>
        </div>
    </section>

    <section class="cutomersupport">
        <div class="sec">
            <div class="freeShipping">
                <span class="material-symbols-outlined" style="font-size: 22pt;">package_2</span>
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
        <div class="social-icons"></div>
    </footer>
</div>
</body>
</html>
