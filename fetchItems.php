<?php
include 'dbConnect.php'; // Ensure this file contains database connection details

$query = "SELECT * FROM Item";
$result = $dbCon->query($query);
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);
?>
