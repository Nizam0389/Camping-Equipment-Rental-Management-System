<?php
session_start();
include 'dbConnect.php'; // Ensure this file contains the database connection details

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

error_log('Data received: ' . print_r($data, true)); // Debugging line

if (!isset($_SESSION['username']) || !isset($data['start_date']) || !isset($data['end_date']) || !isset($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data or user not logged in']);
    exit();
}

$username = $_SESSION['username'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];
$items = $data['items'];

// Debugging lines
error_log('Username: ' . $username);
error_log('Start date: ' . $start_date);
error_log('End date: ' . $end_date);
error_log('Items: ' . print_r($items, true));

try {
    // Get customer ID
    $stmt = $dbCon->prepare("SELECT cust_id FROM customer WHERE username = ?");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $dbCon->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Customer not found");
    }
    $customer = $result->fetch_assoc();
    $cust_id = $customer['cust_id'];

    // Insert rent details
    $stmt = $dbCon->prepare("INSERT INTO Rent (rent_date, return_date, rent_status, cust_id) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $dbCon->error);
    }
    $rent_status = 1;
    $stmt->bind_param("ssii", $start_date, $end_date, $rent_status, $cust_id);
    if (!$stmt->execute()) {
        throw new Exception("Execute statement failed: " . $stmt->error);
    }
    $rent_id = $stmt->insert_id;

    echo json_encode(['success' => true, 'rent_id' => $rent_id]);
} catch (Exception $e) {
    error_log($e->getMessage()); // Log the error message
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
