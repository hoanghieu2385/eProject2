<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once '../mail/mail.php'; // Include the Mailer class
require_once 'send_order_confirmation.php'; 

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Read the raw POST data
$json = file_get_contents('php://input');

// Decode JSON data
$orderData = json_decode($json, true);

// Validate the data
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit;
}

// Start a transaction
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
    $checkout_stmt->bind_param("issssss",
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
    $checkout_info_id = $conn->insert_id ?: $conn->query("SELECT id FROM checkout_info WHERE user_id = $user_id")->fetch_assoc()['id'];

    // Insert into shop_order table
    $order_query = "INSERT INTO shop_order (site_user_id, order_date, payment_shipment_id, order_total, order_status_id, checkout_info_id) 
                    VALUES (?, NOW(), ?, ?, 1, ?)";
    $order_stmt = $conn->prepare($order_query);
    $order_stmt->bind_param("iddi", $user_id, $orderData['payment_shipment_id'], $orderData['order_total'], $checkout_info_id);

    if (!$order_stmt->execute()) {
        throw new Exception("Error inserting shop_order: " . $order_stmt->error);
    }

    $order_id = $conn->insert_id;

    // Insert order items
    $item_query = "INSERT INTO order_items (shop_order_id, product_id, qty, price_at_order) VALUES (?, ?, ?, ?)";
    $item_stmt = $conn->prepare($item_query);

    foreach ($orderData['cart_items'] as $item) {
        if (!isset($item['id'])) {
            continue; // Skip if item doesn't have an ID
        }
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $price = floatval(str_replace(['$', ','], '', $item['price']));
        $item_stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
        if (!$item_stmt->execute()) {
            throw new Exception("Error inserting order_items: " . $item_stmt->error);
        }
    }
    
    // Commit the transaction
    $conn->commit();

    // Prepare order details for the email
    $orderDetails = [
        'recipient_name' => $orderData['checkout_info']['recipient_name'],
        'order_id' => $order_id,
        'order_date' => date('Y-m-d H:i:s'),
        'order_total' => $orderData['order_total'],
        'shipping_address' => $orderData['checkout_info']['address'] . "\n" . 
                             $orderData['checkout_info']['ward'] . ', ' . 
                             $orderData['checkout_info']['district'] . ', ' . 
                             $orderData['checkout_info']['city'],
    ];

    // Get user's email address (fetch from the database using $user_id)
    $user_email_query = "SELECT email_address FROM site_user WHERE id = ?";
    $user_email_stmt = $conn->prepare($user_email_query);
    $user_email_stmt->bind_param("i", $user_id);
    $user_email_stmt->execute();
    $user_email_result = $user_email_stmt->get_result();
    $user_data = $user_email_result->fetch_assoc();
    $userEmail = $user_data['email_address'];

    // Send the order confirmation email
    if (sendOrderConfirmationEmail($orderDetails, $userEmail)) {
        echo json_encode(['success' => true, 'order_id' => $order_id]); // Send success response to frontend
    } else {
        // Log the email sending failure but don't roll back the transaction
        error_log("Order placed successfully, but failed to send confirmation email.");
        echo json_encode(['success' => true, 'order_id' => $order_id, 'message' => 'Order placed, but check your email settings.']);
    }

} catch (Exception $e) {
    // An error occurred, rollback the transaction
    $conn->rollback();
    error_log("Order processing error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing the order: ' . $e->getMessage()]);
}

$conn->close();
