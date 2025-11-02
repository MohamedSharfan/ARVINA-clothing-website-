<?php
header('Content-Type: application/json');

require_once 'db_connect.php';
// Fetch data
$sql = "SELECT id, title, thumbnails, link FROM categories";
$result = $conn->query($sql);

$categories = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Decode JSON thumbnails from DB
        $row['thumbnails'] = json_decode($row['thumbnails'], true);
        $categories[] = $row;
    }
}

echo json_encode($categories);

$conn->close();
?>
