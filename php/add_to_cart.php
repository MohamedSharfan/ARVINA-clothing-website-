<?php


require_once 'session_cart.php';

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
    exit;
}


$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['product_id']) || !isset($data['product_name']) || !isset($data['price']) || 
    !isset($data['color']) || !isset($data['size']) || !isset($data['quantity'])) {
    echo json_encode(array('success' => false, 'message' => 'Missing required fields'));
    exit;
}

$productId = intval($data['product_id']);
$productName = htmlspecialchars(trim($data['product_name']));
$price = floatval($data['price']);
$color = htmlspecialchars(trim($data['color']));
$size = htmlspecialchars(trim($data['size']));
$quantity = intval($data['quantity']);
$imageUrl = isset($data['image_url']) ? htmlspecialchars(trim($data['image_url'])) : '';

if ($quantity <= 0) {
    echo json_encode(array('success' => false, 'message' => 'Quantity must be greater than 0'));
    exit;
}

if ($quantity > 10) {
    echo json_encode(array('success' => false, 'message' => 'Maximum quantity is 10 per item'));
    exit;
}

if (empty($color)) {
    echo json_encode(array('success' => false, 'message' => 'Please select a color'));
    exit;
}

if (empty($size)) {
    echo json_encode(array('success' => false, 'message' => 'Please select a size'));
    exit;
}

$result = addToCart($productId, $productName, $price, $color, $size, $quantity, $imageUrl);

echo json_encode($result);
?>
