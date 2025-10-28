<?php


require_once 'session_cart.php';

header('Content-Type: application/json');

$cartItems = getCartItems();
$cartCount = getCartItemCount();
$cartTotal = getCartTotal();

echo json_encode(array(
    'success' => true,
    'items' => $cartItems,
    'count' => $cartCount,
    'total' => number_format($cartTotal, 2, '.', '')
));
?>
