<?php
header('Content-Type: application/json');
require_once 'db_connect.php'; // make sure path is correct

$sql = "SELECT id, title, thumbnail, link FROM men_categories";
$result = $conn->query($sql);

$categories = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

echo json_encode($categories);
$conn->close();
?>
