<?php
include 'dbConnect.php'; // Ensure this file contains database connection details

$itemType = $_GET['type']; // Get the item type from the query parameter

$stmt = $dbCon->prepare("SELECT * FROM Item WHERE item_type = ?");
$stmt->bind_param("s", $itemType);
$stmt->execute();
$result = $stmt->get_result();
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);
?>
