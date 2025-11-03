<?php
header('Content-Type: application/json');

require_once 'db_connect.php';

$sql = "SELECT id, title, thumbnails, link FROM categories";
$result = $conn->query($sql);

$categories = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $row['thumbnails'] = json_decode($row['thumbnails'], true);
        $categories[] = $row;
    }
}

echo json_encode($categories);

$conn->close();
?>
