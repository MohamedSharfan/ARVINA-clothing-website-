<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db_connect.php';
$conn = getDBConnection();

$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

if ($categoryId <= 0) {
    echo json_encode(["error" => "Invalid or missing category_id"]);
    exit;
}

$sql = "SELECT s.subcategory_id AS id, s.subcategory_name AS title, s.thumbnail, s.link
        FROM subcategories s
        WHERE s.category_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $categoryId);
$stmt->execute();
$result = $stmt->get_result();

$subcategories = [];
while ($row = $result->fetch_assoc()) {
    $subcategories[] = $row;
}

echo json_encode($subcategories);
?>