<?php



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

function addToCart($productId, $productName, $price, $color, $size, $quantity, $imageUrl) {
    $cartKey = $productId . '_' . $color . '_' . $size;
    
    if (empty($productName) || empty($price) || empty($color) || empty($size) || $quantity <= 0) {
        return array('success' => false, 'message' => 'Invalid product data');
    }
    
    if (isset($_SESSION['cart'][$cartKey])) {
        $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$cartKey] = array(
            'product_id' => $productId,
            'product_name' => $productName,
            'price' => floatval($price),
            'color' => $color,
            'size' => $size,
            'quantity' => intval($quantity),
            'image_url' => $imageUrl
        );
    }
    
    return array('success' => true, 'message' => 'Product added to cart', 'cart_count' => getCartItemCount());
}

function updateCartItem($cartKey, $quantity) {
    if (isset($_SESSION['cart'][$cartKey])) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$cartKey]);
            return array('success' => true, 'message' => 'Item removed from cart');
        } else {
            $_SESSION['cart'][$cartKey]['quantity'] = intval($quantity);
            return array('success' => true, 'message' => 'Cart updated');
        }
    }
    return array('success' => false, 'message' => 'Item not found in cart');
}

function removeFromCart($cartKey) {
    if (isset($_SESSION['cart'][$cartKey])) {
        unset($_SESSION['cart'][$cartKey]);
        return array('success' => true, 'message' => 'Item removed from cart');
    }
    return array('success' => false, 'message' => 'Item not found in cart');
}

function getCartItems() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
}

function getCartItemCount() {
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}

function getCartTotal() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

function clearCart() {
    $_SESSION['cart'] = array();
    return array('success' => true, 'message' => 'Cart cleared');
}
?>
