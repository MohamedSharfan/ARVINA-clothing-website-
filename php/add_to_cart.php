<?php
require_once __DIR__ . '/session_cart.php';

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$productId = intval($data['product_id']);
$productName = $data['product_name'];
$price = floatval($data['price']);
$color = $data['color'];
$size = $data['size'];
$quantity = intval($data['quantity']);
$imageUrl = $data['image_url'];

addToCart($productId, $productName, $price, $color, $size, $quantity, $imageUrl);

echo json_encode([
    'success' => true,
    'message' => 'Item added to cart',
    'cart_count' => getCartItemCount()
]);