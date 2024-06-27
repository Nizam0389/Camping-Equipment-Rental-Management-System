<?php
include 'dbConnect.php';

if (isset($_GET['item_id'])) {
    $itemId = $_GET['item_id'];

    $sql = "DELETE FROM Item WHERE item_id = ?";
    if ($stmt = mysqli_prepare($dbCon, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $itemId);
        if (mysqli_stmt_execute($stmt)) {
            echo "Item deleted successfully.";
        } else {
            echo "Error deleting item.";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement.";
    }

    mysqli_close($dbCon);
    header("Location: itemList.php");
    exit();
} else {
    echo "Invalid item ID.";
}
?>
