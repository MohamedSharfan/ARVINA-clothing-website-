<?php

require_once 'session_cart.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['cart_key']) || !isset($data['quantity'])) {
    echo json_encode(array('success' => false, 'message' => 'Missing required fields'));
    exit;
}

$cartKey = htmlspecialchars(trim($data['cart_key']));
$quantity = intval($data['quantity']);

if ($quantity < 0) {
    echo json_encode(array('success' => false, 'message' => 'Invalid quantity'));
    exit;
}

if ($quantity > 10) {
    echo json_encode(array('success' => false, 'message' => 'Maximum quantity is 10 per item'));
    exit;
}

$result = updateCartItem($cartKey, $quantity);
$result['cart_count'] = getCartItemCount();
$result['cart_total'] = getCartTotal();

echo json_encode($result);
?>
