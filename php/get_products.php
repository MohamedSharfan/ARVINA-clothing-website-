<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
require_once __DIR__ . '/db_connect.php';

$conn = getDBConnection();

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
$subcategory_id = isset($_GET['subcategory_id']) ? intval($_GET['subcategory_id']) : null;

$sql = "SELECT 
            product_id AS id,
            product_name AS title,
            price,
            discount_price,
            image_url AS thumbnail,
            description AS about,
            stock_quantity,
            available_colors,
            available_sizes
        FROM products";

$conditions = [];
$params = [];
$types = '';

if ($category_id) {
    $conditions[] = "category_id = ?";
    $params[] = $category_id;
    $types .= 'i';
}

if ($subcategory_id) {
    $conditions[] = "subcategory_id = ?";
    $params[] = $subcategory_id;
    $types .= 'i';
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

error_log("SQL QUERY: " . $sql);

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(["error" => "SQL Prepare failed: " . $conn->error]));
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
    die(json_encode(["error" => "Query execution failed: " . $stmt->error]));
}

$result = $stmt->get_result();
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products, JSON_PRETTY_PRINT);

$stmt->close();
closeDBConnection($conn);
?>