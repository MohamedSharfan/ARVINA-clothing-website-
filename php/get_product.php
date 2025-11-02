<?php
// ✅ Show any PHP or database errors clearly in browser
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/db_connect.php';

// ✅ Connect to database
$conn = getDBConnection();

// ✅ Get product ID from URL like: ?id=1
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ✅ If no valid ID, show error message
if ($product_id <= 0) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product ID']);
    exit;
}

// ✅ Prepare SQL query
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Database error', 'details' => $conn->error]);
    exit;
}

// ✅ Run query
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// ✅ If product not found
if ($result->num_rows === 0) {
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit;
}

// ✅ Get product details
$product = $result->fetch_assoc();

// ✅ Close database
$stmt->close();
closeDBConnection($conn);

// ✅ Return JSON data to browser
header('Content-Type: application/json');
echo json_encode($product, JSON_PRETTY_PRINT);
exit;
?>