<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db_connect.php';
$conn = getDBConnection();

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product ID']);
    exit;
}

$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Database error', 'details' => $conn->error]);
    exit;
}

$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit;
}

$product = $result->fetch_assoc();

$stmt->close();
closeDBConnection($conn);

header('Content-Type: application/json');
echo json_encode($product, JSON_PRETTY_PRINT);
exit;
?>