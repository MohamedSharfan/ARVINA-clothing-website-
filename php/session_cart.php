<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Add item to cart
function addToCart($productId, $productName, $price, $color, $size, $quantity, $imageUrl) {
    $cartKey = md5($productId . $color . $size); // Unique key for item variant

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If same item exists, increase quantity
    if (isset($_SESSION['cart'][$cartKey])) {
        $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$cartKey] = [
            'product_id' => $productId,
            'product_name' => $productName,
            'price' => $price,
            'color' => $color,
            'size' => $size,
            'quantity' => $quantity,
            'image_url' => $imageUrl
        ];
    }
}

// ✅ Get all cart items
function getCartItems() {
    return $_SESSION['cart'] ?? [];
}

// ✅ Calculate total price
function getCartTotal() {
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

// ✅ Get number of items
function getCartItemCount() {
    $count = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}

// ✅ Remove a specific item
function removeCartItem($cartKey) {
    if (isset($_SESSION['cart'][$cartKey])) {
        unset($_SESSION['cart'][$cartKey]);
    }
}

// ✅ Clear cart
function clearCart() {
    unset($_SESSION['cart']);
}
?>