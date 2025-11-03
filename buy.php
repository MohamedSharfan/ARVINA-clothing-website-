<?php
session_start();
require_once './php/session_cart.php';

$isLoggedIn = isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] === true;

if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}


$customerName = isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : 'User';
$cartCount = getCartItemCount();
// Get product ID from URL like buy.php?id=12
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate ID before loading
if ($product_id <= 0) {
    die("<p style='color:red; text-align:center; font-size:18px;'>Invalid Product ID.</p>");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product | ARVINA</title>

    <!-- CSS -->
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/product-buy-card.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .product-buy-card-main {
            display: flex;
            justify-content: center;
            padding: 60px 5%;
            margin-top: 60px;
            background-color: #f9f9f9;
        }

        .product-buy-card {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            background: #fff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 40px;
            max-width: 1100px;
            width: 100%;
            animation: fadeIn 0.5s ease-in;
           
        }

        .product-image {
            flex: 1 1 40%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .product-image img {
            width: 100%;
            max-width: 420px;
           
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-image img:hover {
            transform: scale(1.05);
        }

        .product-info {
            flex: 1 1 50%;
            display: flex;
            flex-direction: column;
            gap: 18px;
            font-family: "Poppins", sans-serif;
        }

        .product-info h1 {
            font-size: 28px;
            font-weight: 600;
            color: #111;
        }

        .product-info p {
            color: #555;
            line-height: 1.6;
        }

        #price p {
            margin: 5px 0;
            font-size: 17px;
        }

        .color-options,
        .size-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .color-option {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #ccc;
            cursor: pointer;
            transition: 0.3s;
        }

        .color-option.selected {
            border: 3px solid #000;
        }

        .size-options button {
            padding: 8px 14px;
            border-radius: 6px;
            border: 1px solid #aaa;
            background: #fff;
            cursor: pointer;
            transition: 0.2s;
            font-size: 14px;
        }

        .size-options button:hover,
        .size-options button.selected {
            background: #000;
            color: #fff;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-control button {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background: #f5f5f5;
            cursor: pointer;
            font-size: 18px;
        }

        .quantity-control input {
            width: 60px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .add-to-cart {
            background: #000;
            color: #fff;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.3s;
        }

        .add-to-cart:hover {
            background: #222;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
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

    <!-- Product Section -->
    <div class="product-buy-card-main">
        <div id="product-container" class="product-buy-card">
            <p style="text-align:center;">Loading product details...</p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="foot">
        <div class="full-wrapper">
            <p style="text-align:center; padding:20px;">© 2025 ARVINA — Crafted with elegance.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const productId = <?= $product_id ?>;
            const container = document.getElementById('product-container');

            try {
                const response = await fetch(`./php/get_product.php?id=${productId}`);
                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const product = await response.json();
                if (!product || !product.product_name) {
                    container.innerHTML = "<p style='color:red;'>Product not found.</p>";
                    return;
                }

                // Render product
                container.innerHTML = `
                    <div class="product-image">
                        <img src="${product.image_url.replace('../', './')}" alt="${product.product_name}">
                    </div>
                    <div class="product-info">
                        <h1>${product.product_name}</h1>
                        <p>${product.description || ''}</p>
                        <div id="price">
                            <p><strong>Price:</strong> Rs ${Number(product.discount_price || product.price).toLocaleString()}</p>
                        </div>
                        <h4>COLOR</h4>
                        <div class="color-options">
                            ${(product.available_colors || '').split(',').map(c => `
                                <span class="color-option" data-color="${c.trim()}" title="${c.trim()}" style="background-color:${c.trim().toLowerCase()}"></span>
                            `).join('')}
                        </div>
                        <h4>SIZE</h4>
                        <div class="size-options">
                            ${(product.available_sizes || '').split(',').map(s => `
                                <button>${s.trim()}</button>
                            `).join('')}
                        </div>
                        <h4>QUANTITY</h4>
                        <div class="quantity-control">
                            <button id="decrease">-</button>
                            <input type="number" id="quantity" value="1" min="1" max="${product.stock_quantity}">
                            <button id="increase">+</button>
                        </div>
                        <button class="add-to-cart" id="addToCartBtn">ADD TO CART</button>
                    </div>
                `;

                // Selection handling
                document.querySelectorAll('.color-option').forEach(opt => {
                    opt.addEventListener('click', () => {
                        document.querySelectorAll('.color-option').forEach(o => o.classList.remove('selected'));
                        opt.classList.add('selected');
                    });
                });
                document.querySelectorAll('.size-options button').forEach(btn => {
                    btn.addEventListener('click', () => {
                        document.querySelectorAll('.size-options button').forEach(b => b.classList.remove('selected'));
                        btn.classList.add('selected');
                    });
                });

                // Quantity controls
                document.getElementById('decrease').addEventListener('click', () => {
                    const q = document.getElementById('quantity');
                    if (q.value > 1) q.value--;
                });
                document.getElementById('increase').addEventListener('click', () => {
                    const q = document.getElementById('quantity');
                    if (parseInt(q.value) < parseInt(q.max)) q.value++;
                });

                // Add to cart
                document.getElementById('addToCartBtn').addEventListener('click', () => {
                    const color = document.querySelector('.color-option.selected')?.dataset.color || '';
                    const size = document.querySelector('.size-options button.selected')?.textContent.trim() || '';
                    const quantity = parseInt(document.getElementById('quantity').value);

                    if (!color || !size) {
                        alert('Please select color and size before adding to cart.');
                        return;
                    }

                    const data = {
                        product_id: product.product_id,
                        product_name: product.product_name,
                        price: parseFloat(product.discount_price || product.price),
                        color,
                        size,
                        quantity,
                        image_url: product.image_url.replace('../', './')
                    };

                    fetch('./php/add_to_cart.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(res => res.json())
                        .then(result => {
                            if (result.success) {
                                alert('✅ Added to cart!');
                            } else {
                                alert('❌ ' + result.message);
                            }
                        })
                        .catch(err => console.error('Add to cart error:', err));
                });

            } catch (error) {
                container.innerHTML = `<p style="color:red;">Failed to load product: ${error.message}</p>`;
            }
        });
    </script>
</body>

</html>