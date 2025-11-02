<?php
session_start();

$isLoggedIn = isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] === true;

require_once '../php/session_cart.php';

$customerName = isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : 'User';
$cartCount = getCartItemCount(); // ✅ Get cart count from session


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/summer-sale.css">
    <link rel="stylesheet" href="../css/shop-nav.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/product-card.css">
    <link rel="stylesheet" href="../css/product-list.css">
    <link rel="stylesheet" href="../css/see-more.css">

    <title>Men Jackets</title>

    <style>
        @media (max-width: 850px) {
            .header-background {
                background-color: rgba(1, 1, 1, 0.3);
            }

            .home-text1 {
                color: white;
            }

            .home-text2 {
                color: white;
            }

            header .btn {
                margin-top: 40px;
                margin-left: 25%;
                padding: 20px 20px;
                background-color: transparent;
                border-radius: 0;
                color: #ffffff;
                font-family: "Poppins", sans-serif;
                font-size: 16px;
                border: 1px solid #ffffff;
            }

            header .btn:hover {
                border: 3px solid #ffffff;
                color: #ffffff;
                background-color: rgba(197, 197, 197, 0.3);
            }
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="h2">A R V I N A</div>
            <ul>
                <li class="li"><a href="home.php" class="aNav active">HOME</a></li>
                <li class="li"><a href="#" class="aNav">OFFERS</a></li>
                <li class="li"><a href="#" class="aNav">FAQ</a></li>
                <li class="li"><a href="./about.html" class="aNav">ABOUT US</a></li>
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
        <div class="header-background"
            style="background-image: url(../assest/men/suits/\(13\).jpg); margin-top: 70px; ">

            <div class="home-move-area" style="justify-content: flex-end; padding-right: 15%;">
                <section class="home ">
                    <div class="home-text2">ELEVATE YOUR STYLE</div>
                    <div class="home-text1">TIMELESS ELEGANCE</div>
                    <div class="best"><button class="btn">SHOP BEST SELLERS</button></div>
                </section>
            </div>
        </div>
    </header>

    <div class="sticky-area">
        <div class="shop-nav">
            <div class="nav-align">
                <div class="all"><button class="btn1" onclick="window.location.href = '../home.html';">ALL</button></div>
                <div class="bestsellers"><button class="btn1"
                        onclick="window.location.href = '../bestsellers/bestsellers.html';">BESTSELLERS</button></div>
                <div class="us"><button class="btn1" onclick="window.location.href = '../about/about.html';">THE
                        TEAM</button></div>
                <div class="men"><button class="btn1" onclick="window.location.href = '../men/men.html';">MEN</button>
                </div>
                <div class="women"><button class="btn1"
                        onclick="window.location.href = '../women/women.html';">WOMEN</button></div>
                <div class="watches"><button class="btn1"
                        onclick="window.location.href = '../watches/watches.html';">WATCHES</button></div>
                <div class="shoes"><button class="btn1"
                        onclick="window.location.href = '../shoes/shoes.html';">SHOES</button></div>
            </div>
        </div>
    </div>

    <div class="product-list"></div>

    <div class="see-more">
        <div class="see-more-btn"><button>SEE MORE</button></div>
    </div>

    <div class="summer-sale">
        <div class="summer">SUMMER SALE</div>
        <div class="off50">UP TO 50% OFF</div>
        <div class="shopnow"><button class="shopnow-btn">SHOP NOW</button></div>
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
                        apparel that exudes quiet luxury. Elevate your wardrobe with pieces inspired by the refined
                        aesthetics of the past. Stay connected with us for exclusive collections and style updates.
                    </p>
                </div>
            </div>
            <div class="social-wrapper">
                <h4>Contact Information</h4>
                <ul class="contact-list">
                    <li><i class="fa-solid fa-map-location"></i>67/2, Main street, Colombo</li>
                    <li><i class="fa-solid fa-id-badge"></i>+94777678678</li>
                    <li><i class="fa-solid fa-square-envelope"></i>oldmoneyclothing@gmail.com</li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const container = document.querySelector('.product-list');
            container.innerHTML = '<p>Loading jackets...</p>';

            try {
                const response = await fetch('../php/get_products.php?category_id=1&subcategory_id=4');

                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

                const text = await response.text();
                let products;

                try {
                    products = JSON.parse(text);
                } catch (e) {
                    console.error("❌ Invalid JSON received:");
                    console.log(text);
                    container.innerHTML = '<p style="color:red;">Server returned invalid data. Check PHP errors in console.</p>';
                    return;
                }

                console.log("✅ Loaded products:", products);
                container.innerHTML = '';

                if (!Array.isArray(products) || products.length === 0) {
                    container.innerHTML = '<p>No jackets found.</p>';
                    return;
                }

                products.forEach((product, index) => {
                    const card = document.createElement('div');
                    card.classList.add('product-card');

                    card.innerHTML = `
                <div class="thambnail" onclick="buyProduct(${product.id})">
                    <img class="thambnail-image" src="${product.thumbnail}" alt="${product.title}">
                </div>
                <div class="save">
                    <p>${product.discount_price ? `SAVE Rs ${(product.price - product.discount_price).toLocaleString()}` : ''}</p>
                </div>
                <div class="product-details">
                    <div class="title"><p>${product.title}</p></div>
                    <div class="price"><p>Rs ${Number(product.price).toLocaleString()}</p></div>
                    <div class="button-section">
                        <div class="thambnail-switch">
                            <div class="thambnail-switch-1">
                                <img class="thambnail-switch-image" src="${product.thumbnail}">
                            </div>
                            <div class="thambnail-switch-1">
                                <img class="thambnail-switch-image" src="${product.thumbnail}">
                            </div>
                        </div>
                        <div class="buy-btn">
                            <button onclick="buyProduct(${product.id})">Buy</button>
                        </div
                    </div>
                </div>
            `;

                    container.appendChild(card);
                });

            } catch (error) {
                console.error('⚠️ Error loading products:', error);
                container.innerHTML = `<p style="color:red;">Failed to load products: ${error.message}</p>`;
            }
        });

        function buyProduct(productId) {
            console.log(productId)
            window.location.href = `../buy.php?id=${productId}`;
        }
    </script>
</body>

</html>