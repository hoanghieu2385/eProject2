<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

error_log("Order processing started");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

error_log("Database connection successful");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    error_log("User not logged in");
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
error_log("User logged in. User ID: " . $user_id);

// Read the raw POST data
$json = file_get_contents('php://input');

// Decode JSON data
$orderData = json_decode($json, true);

// Log received data for debugging
error_log("Received order data: " . print_r($orderData, true));

// Validate the data
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("JSON decode error: " . json_last_error_msg());
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit;
}

error_log("Order data validation passed");

// Start a transaction
$conn->begin_transaction();

try {
    error_log("Starting transaction");

    // Insert or update checkout_info
    // Insert or update checkout_info
    $checkout_query = "INSERT INTO checkout_info (user_id, recipient_name, recipient_phone, address, ward, district, city) 
VALUES (?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE
recipient_name = VALUES(recipient_name),
recipient_phone = VALUES(recipient_phone),
address = VALUES(address),
ward = VALUES(ward),
district = VALUES(district),
city = VALUES(city)";
    $checkout_stmt = $conn->prepare($checkout_query);
    $checkout_stmt->bind_param(
        "issssss",
        $user_id,
        $orderData['checkout_info']['recipient_name'],
        $orderData['checkout_info']['recipient_phone'],
        $orderData['checkout_info']['address'],
        $orderData['checkout_info']['ward'],
        $orderData['checkout_info']['district'],
        $orderData['checkout_info']['city']
    );

    error_log("Executing checkout_info insert/update query");
    if (!$checkout_stmt->execute()) {
        throw new Exception("Error inserting/updating checkout_info: " . $checkout_stmt->error);
    }
    $checkout_info_id = $conn->insert_id ?: $conn->query("SELECT id FROM checkout_info WHERE user_id = $user_id")->fetch_assoc()['id'];
    error_log("Checkout info inserted/updated successfully. ID: " . $checkout_info_id);
    // Insert into shop_order table
    $order_query = "INSERT INTO shop_order (site_user_id, order_date, payment_shipment_id, order_total, order_status_id, checkout_info_id) 
                    VALUES (?, NOW(), ?, ?, 1, ?)";
    $order_stmt = $conn->prepare($order_query);
    $order_stmt->bind_param("iddi", $user_id, $orderData['payment_shipment_id'], $orderData['order_total'], $checkout_info_id);

    error_log("Executing shop_order insert query");
    if (!$order_stmt->execute()) {
        throw new Exception("Error inserting shop_order: " . $order_stmt->error);
    }

    $order_id = $conn->insert_id;
    error_log("Shop order inserted successfully. Order ID: " . $order_id);

    // Insert order items
    $item_query = "INSERT INTO order_items (shop_order_id, product_id, qty, price_at_order) VALUES (?, ?, ?, ?)";
    $item_stmt = $conn->prepare($item_query);

    error_log("Received cart items: " . print_r($orderData['cart_items'], true));

    foreach ($orderData['cart_items'] as $item) {
        error_log("Processing item: " . print_r($item, true));
        if (!isset($item['id'])) {
            error_log("Item missing 'id': " . print_r($item, true));
            continue;
        }
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $price = floatval(str_replace(['$', ','], '', $item['price']));
        $item_stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        if (!$item_stmt->execute()) {
            throw new Exception("Error inserting order_items: " . $item_stmt->error);
        }
    }

    error_log("All order items inserted successfully");

    // Commit the transaction
    $conn->commit();
    error_log("Transaction committed successfully");

    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (Exception $e) {
    // An error occurred, rollback the transaction
    $conn->rollback();
    error_log("Order processing error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing the order: ' . $e->getMessage()]);
}

$conn->close();
error_log("Order processing completed");
