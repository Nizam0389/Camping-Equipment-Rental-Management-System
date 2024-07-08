<?php
include 'dbConnect.php';

if (isset($_GET['rent_id']) && isset($_GET['item_id'])) {
    $rentId = $_GET['rent_id'];
    $itemId = $_GET['item_id'];

    $sql = "SELECT p.payment_image_url
            FROM Payment p
            JOIN rentaldetail rd ON p.rent_id = rd.rent_id
            WHERE p.rent_id = ? AND rd.item_id = ?";

    if ($stmt = mysqli_prepare($dbCon, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $rentId, $itemId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $paymentImageUrl);
        if (mysqli_stmt_fetch($stmt)) {
            echo json_encode(['status' => 'success', 'payment_image_url' => $paymentImageUrl]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error']);
    }

    mysqli_close($dbCon);
} else {
    echo json_encode(['status' => 'error']);
}
?>
