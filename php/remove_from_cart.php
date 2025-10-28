<?php


require_once 'session_cart.php';


header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array('success' => false, 'message' => 'Invalid request method'));
    exit;
}


$data = json_decode(file_get_contents('php://input'), true);


if (!isset($data['cart_key'])) {
    echo json_encode(array('success' => false, 'message' => 'Missing cart key'));
    exit;
}

$cartKey = htmlspecialchars(trim($data['cart_key']));


$result = removeFromCart($cartKey);
$result['cart_count'] = getCartItemCount();
$result['cart_total'] = getCartTotal();

echo json_encode($result);
?>
