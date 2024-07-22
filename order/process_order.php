<?php
ini_set('display_errors', 0); // Disable displaying errors to the browser
error_reporting(E_ALL); // Still log all errors
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
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    error_log("User not logged in");
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

$json = file_get_contents('php://input');
$orderData = json_decode($json, true);

error_log("Received order data: " . print_r($orderData, true));

if (!$orderData || !isset($orderData['payment_shipment_id']) || !isset($orderData['order_total']) || !isset($orderData['cart_items']) || !isset($orderData['checkout_info'])) {
    error_log("Invalid order data");
    echo json_encode(['success' => false, 'message' => 'Invalid order data']);
    exit;
}

$conn->begin_transaction();

try {
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

    if (!$checkout_stmt->execute()) {
        throw new Exception("Error inserting/updating checkout_info: " . $checkout_stmt->error);
    }

    // Insert into shop_order table
    $order_query = "INSERT INTO shop_order (site_user_id, order_date, payment_shipment_id, order_total, order_status_id) 
                    VALUES (?, NOW(), ?, ?, 1)";
    $order_stmt = $conn->prepare($order_query);
    $order_stmt->bind_param("idd", $user_id, $orderData['payment_shipment_id'], $orderData['order_total']);

    if (!$order_stmt->execute()) {
        throw new Exception("Error inserting shop_order: " . $order_stmt->error);
    }

    $order_id = $conn->insert_id;

    // Insert order items
    $item_query = "INSERT INTO order_items (shop_order_id, product_id, qty, price_at_order) VALUES (?, ?, ?, ?)";
    $item_stmt = $conn->prepare($item_query);

    foreach ($orderData['cart_items'] as $item) {
        error_log("Processing item: " . print_r($item, true));

        if (!isset($item['id'])) {
            throw new Exception("Invalid item data: missing id");
        }

        $product_id = $item['product_id'];
        $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
        $price = isset($item['price']) ? floatval(str_replace(['$', ','], '', $item['price'])) : 0;

        $item_stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        if (!$item_stmt->execute()) {
            throw new Exception("Error inserting order_items: " . $item_stmt->error);
        }
    }

    $conn->commit();
    error_log("Order processed successfully. Order ID: " . $order_id);
    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (Exception $e) {
    $conn->rollback();
    error_log("Order processing error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing the order: ' . $e->getMessage()]);
}

$conn->close();
error_log("Order processing completed");
