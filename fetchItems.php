<?php
include 'dbConnect.php'; // Ensure this file contains database connection details

$typeCondition = "";
if (isset($_GET['type'])) {
    $itemType = $_GET['type'];
    $typeCondition = "WHERE item_type = ?";
}

$query = "SELECT * FROM Item $typeCondition";
$stmt = $dbCon->prepare($query);

if ($typeCondition) {
    $stmt->bind_param("s", $itemType);
}

$stmt->execute();
$result = $stmt->get_result();
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);
?>

