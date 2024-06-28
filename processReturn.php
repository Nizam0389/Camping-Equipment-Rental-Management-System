<?php
include 'dbConnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rentId = $_POST['rent_id'];

    // Start transaction
    mysqli_begin_transaction($dbCon);

    try {
        // Update rent status
        $sql = "UPDATE Rent SET rent_status = FALSE WHERE rent_id = ?";
        if ($stmt = mysqli_prepare($dbCon, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $rentId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Update item quantity
        $sql = "SELECT item_id, RD_quantity FROM RentalDetail WHERE rent_id = ?";
        if ($stmt = mysqli_prepare($dbCon, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $rentId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($row = $result->fetch_assoc()) {
                $itemId = $row['item_id'];
                $RDQuantity = $row['RD_quantity'];

                $updateSql = "UPDATE Item SET item_quantity = item_quantity + ? WHERE item_id = ?";
                if ($updateStmt = mysqli_prepare($dbCon, $updateSql)) {
                    mysqli_stmt_bind_param($updateStmt, "ii", $RDQuantity, $itemId);
                    mysqli_stmt_execute($updateStmt);
                    mysqli_stmt_close($updateStmt);
                }
            }
            mysqli_stmt_close($stmt);
        }

        // Commit transaction
        mysqli_commit($dbCon);
        echo "Return confirmed successfully!";
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_roll_back($dbCon);
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($dbCon);
}
?>
