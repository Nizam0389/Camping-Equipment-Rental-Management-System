<?php
session_start();
include 'dbConnect.php'; // Ensure this file contains the database connection details

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['rent_id']) || !isset($data['items']) || !isset($data['start_date']) || !isset($data['end_date'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit();
}

$username = $_SESSION['username'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];

try {
    // Insert rental details
    $stmt = $dbCon->prepare("INSERT INTO rentaldetail (RD_quantity, rd_fee, rent_id, item_id) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $dbCon->error);
    }
    $rent_status = 1;
    $stmt->bind_param("ssii", $start_date, $end_date, $rent_status, $cust_id);
    if (!$stmt->execute()) {
        throw new Exception("Execute statement failed: " . $stmt->error);
    }
    $rent_id = $stmt->insert_id;

    // Insert each item in rental details
    $stmt = $dbCon->prepare("INSERT INTO RentalDetail (rent_id, item_id, quantity) VALUES (?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $dbCon->error);
    }
    foreach ($items as $item) {
        $item_id = $item['item_id'];
        $quantity = $item['quantity'];
        $item_id = $item['product_id'];
        $item_fee = floatval($item['item_fee']); // Ensure item_fee is a float
        $days = ceil((strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24));
        $rd_fee = $quantity * $item_fee * $days;

        // Log details for debugging
        error_log("Inserting RentalDetail: Quantity - $quantity, Fee - $rd_fee, Rent ID - $rent_id, Item ID - $item_id");

        $stmt->bind_param("idii", $quantity, $rd_fee, $rent_id, $item_id);

        if (!$stmt->execute()) {
            throw new Exception("Execute statement failed: " . $stmt->error);
        }
    }

    $dbCon->commit();

    echo json_encode(['success' => true, 'rent_id' => $rent_id]);
} catch (Exception $e) {
    error_log($e->getMessage()); // Log the error message
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
