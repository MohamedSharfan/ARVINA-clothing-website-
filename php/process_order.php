<?php

require_once 'db_connect.php';
require_once 'session_cart.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../checkout.php');
    exit;
}

$customerName = sanitizeInput($_POST['customer_name']);
$customerEmail = sanitizeInput($_POST['customer_email']);
$customerPhone = sanitizeInput($_POST['customer_phone']);
$customerAddress = sanitizeInput($_POST['customer_address']);
$city = sanitizeInput($_POST['city']);
$postalCode = sanitizeInput($_POST['postal_code']);
$paymentMethod = sanitizeInput($_POST['payment_method']);
$orderNotes = isset($_POST['order_notes']) ? sanitizeInput($_POST['order_notes']) : '';

$errors = array();

if (strlen($customerName) < 3) {
    $errors[] = "Name must be at least 3 characters";
}

if (!validateEmail($customerEmail)) {
    $errors[] = "Invalid email address";
}

if (!validatePhone($customerPhone)) {
    $errors[] = "Invalid phone number";
}

if (strlen($customerAddress) < 10) {
    $errors[] = "Please provide a complete address";
}

if (strlen($city) < 2) {
    $errors[] = "Invalid city name";
}

if (strlen($postalCode) < 4) {
    $errors[] = "Invalid postal code";
}

if (empty($paymentMethod)) {
    $errors[] = "Please select a payment method";
}

// Get cart data
$cartItems = getCartItems();
$cartTotal = getCartTotal();

if (empty($cartItems)) {
    $errors[] = "Cart is empty";
}

if (!empty($errors)) {
    $_SESSION['checkout_errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: ../checkout.php');
    exit;
}

$conn = getDBConnection();
$conn->begin_transaction();

try {
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, city, postal_code, total_amount, payment_method, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("ssssssds", $customerName, $customerEmail, $customerPhone, $customerAddress, $city, $postalCode, $cartTotal, $paymentMethod);
    $stmt->execute();
    $orderId = $conn->insert_id;
    $stmt->close();
    
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, selected_color, selected_size, quantity, unit_price, subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($cartItems as $item) {
        $productId = $item['product_id'];
        $productName = $item['product_name'];
        $color = $item['color'];
        $size = $item['size'];
        $quantity = $item['quantity'];
        $unitPrice = $item['price'];
        $subtotal = $unitPrice * $quantity;
        
        $stmt->bind_param("iisssidd", $orderId, $productId, $productName, $color, $size, $quantity, $unitPrice, $subtotal);
        $stmt->execute();
    }
    $stmt->close();
    
    $conn->commit();
    
    clearCart();
    
    $_SESSION['last_order_id'] = $orderId;
    
    header('Location: ../order_confirmation.php?order_id=' . $orderId);
    exit;
    
} catch (Exception $e) {
    $conn->rollback();
    
    $_SESSION['checkout_errors'] = array("Error processing order: " . $e->getMessage());
    header('Location: ../checkout.php');
    exit;
}

closeDBConnection($conn);
?>
