<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function addToCart($productId, $productName, $price, $color, $size, $quantity, $imageUrl) {
    $cartKey = md5($productId . $color . $size); 

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

 
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

/**
 * Get all cart items
 */
function getCartItems() {
    return $_SESSION['cart'] ?? [];
}

/**
 * Calculate total price
 */
function getCartTotal() {
    $total = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

/**
 * Get number of items in cart
 */
function getCartItemCount() {
    $count = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}

/**
 * Remove a specific item from the cart
 */
function removeCartItem($cartKey) {
    if (isset($_SESSION['cart'][$cartKey])) {
        unset($_SESSION['cart'][$cartKey]);
        return true;
    }
    return false;
}

/**
 * Update an existing cart item
 */
function updateCartItem($cartKey, $newQuantity = null, $newColor = null, $newSize = null) {
    if (!isset($_SESSION['cart'][$cartKey])) {
        return false; // item not found
    }

    $item = $_SESSION['cart'][$cartKey];

    // Update fields
    if (!is_null($newQuantity)) $item['quantity'] = max(1, intval($newQuantity)); // avoid 0 or negative
    if (!is_null($newColor)) $item['color'] = $newColor;
    if (!is_null($newSize)) $item['size'] = $newSize;

    // Recalculate new unique key (in case color/size changed)
    $newKey = md5($item['product_id'] . $item['color'] . $item['size']);

    // If key changed, move item to new position
    if ($newKey !== $cartKey) {
        unset($_SESSION['cart'][$cartKey]);
        $_SESSION['cart'][$newKey] = $item;
    } else {
        $_SESSION['cart'][$cartKey] = $item;
    }

    return true;
}

/**
 * Clear the entire cart
 */
function clearCart() {
    unset($_SESSION['cart']);
}
?>