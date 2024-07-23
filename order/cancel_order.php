<?php
// cancel_order.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/db_connect.php';

// Turn off output buffering
ob_start();

header('Content-Type: application/json');

function sendJsonResponse($success, $message) {
    ob_clean(); // Clear any output buffered up to this point
    $response = json_encode(['success' => $success, 'message' => $message]);
    echo $response;
    exit;
}

function logMessage($message) {
    error_log(date('[Y-m-d H:i:s] ') . "Cancel Order Log: " . $message . "\n", 3, "cancel_order_log.log");
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    logMessage("Unauthorized access attempt");
    sendJsonResponse(false, 'Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['order_id'])) {
    logMessage("Invalid request method or missing order_id");
    sendJsonResponse(false, 'Invalid request');
}

$order_id = intval($_POST['order_id']);
$user_id = $_SESSION['user_id'];

logMessage("Attempting to cancel order: Order ID {$order_id}, User ID {$user_id}");

try {
    // check if user has this order
    $check_sql = "SELECT id FROM shop_order WHERE id = ? AND site_user_id = ? AND order_status_id = 1";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $order_id, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows === 0) {
        logMessage("Order not found or cannot be canceled: Order ID {$order_id}, User ID {$user_id}");
        sendJsonResponse(false, 'Order not found or cannot be canceled');
    }
    
    // update order status to canceled
    $update_sql = "UPDATE shop_order SET order_status_id = 5 WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $order_id);
    
    if ($update_stmt->execute()) {
        logMessage("Order canceled successfully: Order ID {$order_id}");
        sendJsonResponse(true, 'Order canceled successfully');
    } else {
        logMessage("Failed to cancel order: " . $conn->error);
        sendJsonResponse(false, 'Failed to cancel order');
    }
} catch (Exception $e) {
    logMessage("Exception occurred: " . $e->getMessage());
    sendJsonResponse(false, 'An error occurred: ' . $e->getMessage());
} finally {
    if (isset($check_stmt)) $check_stmt->close();
    if (isset($update_stmt)) $update_stmt->close();
    $conn->close();
}
?>