<?php
session_start();
include 'dbConnect.php'; // Ensure this file contains the database connection details

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['rent_id']) || !isset($data['total_fee'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit();
}

$rent_id = $data['rent_id'];
$total_fee = $data['total_fee'];
$payment_date = date('Y-m-d'); // Current date

try {
    // Insert payment details
    $stmt = $dbCon->prepare("INSERT INTO payment (total_fee, payment_date, rent_id) VALUES (?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $dbCon->error);
    }

    $stmt->bind_param("dsi", $total_fee, $payment_date, $rent_id);

    if (!$stmt->execute()) {
        throw new Exception("Execute statement failed: " . $stmt->error);
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log($e->getMessage()); // Log the error message
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
