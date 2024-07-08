<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start logging
error_log("Starting saveRentalDetails.php script");

header('Content-Type: application/json');

// Include database connection
require_once 'dbConnect.php';

// Check connection
if ($dbCon === false) {
    error_log("ERROR: Could not connect. " . mysqli_connect_error());
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

error_log("Database connection successful");

$data = json_decode(file_get_contents('php://input'), true);

// Log received data
error_log("Received data: " . print_r($data, true));

if (!isset($data['rent_id']) || !isset($data['items']) || !isset($data['start_date']) || !isset($data['end_date'])) {
    error_log("Invalid data received");
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit();
}

$rent_id = $data['rent_id'];
$items = $data['items'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];

try {
    // Check if rent_id exists in rent table
    $stmt = $dbCon->prepare("SELECT * FROM rent WHERE rent_id = ?");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $dbCon->error);
    }
    $stmt->bind_param("i", $rent_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Invalid rent_id: " . $rent_id);
    }

    // Prepare statement for inserting rental details
    $stmt = $dbCon->prepare("INSERT INTO rentaldetail (RD_quantity, rd_fee, rent_id, item_id) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $dbCon->error);
    }

    foreach ($items as $item) {
        $quantity = $item['quantity'];
        $item_id = $item['product_id'];
        $item_fee = floatval($item['item_fee']);

        // Check if item_id exists in item table
        $checkStmt = $dbCon->prepare("SELECT * FROM item WHERE item_id = ?");
        $checkStmt->bind_param("i", $item_id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows === 0) {
            throw new Exception("Invalid item_id: " . $item_id);
        }

        $days = ceil((strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24));
        $rd_fee = $quantity * $item_fee * $days;

        error_log("Inserting RentalDetail: Quantity - $quantity, Fee - $rd_fee, Rent ID - $rent_id, Item ID - $item_id");

        $stmt->bind_param("idii", $quantity, $rd_fee, $rent_id, $item_id);

        if (!$stmt->execute()) {
            throw new Exception("Execute statement failed: " . $stmt->error);
        }
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Close the database connection
    mysqli_close($dbCon);
}
?>