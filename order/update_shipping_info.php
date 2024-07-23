<?php
session_start();
header('Content-Type: application/json');

// Báo cáo tất cả lỗi PHP và ghi log chúng
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log'); // Thay đổi đường dẫn này

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log('Connection failed: ' . $conn->connect_error);
    die(json_encode(['status' => 'error', 'message' => 'Connection failed']));
}

if (!isset($_SESSION['user_id'])) {
    error_log('User not logged in');
    die(json_encode(['status' => 'error', 'message' => 'User not logged in']));
}

$user_id = $_SESSION['user_id'];
$full_name = $_POST['full_name'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$ward = $_POST['ward'] ?? '';
$district = $_POST['district'] ?? '';
$city = $_POST['city'] ?? '';

try {
    // Start transaction
    $conn->begin_transaction();

    // Update user information
    $update_user = $conn->prepare("UPDATE site_user SET first_name = ?, last_name = ?, phone_number = ? WHERE id = ?");
    $names = explode(' ', $full_name, 2);
    $first_name = $names[0];
    $last_name = isset($names[1]) ? $names[1] : '';
    $update_user->bind_param("sssi", $first_name, $last_name, $phone, $user_id);

    if (!$update_user->execute()) {
        throw new Exception('Error updating user: ' . $conn->error);
    }

    // Check if address exists for the user
    $check_address = $conn->prepare("SELECT address_id FROM user_address WHERE user_id = ?");
    $check_address->bind_param("i", $user_id);
    $check_address->execute();
    $result = $check_address->get_result();

    if ($result->num_rows > 0) {
        // Update existing address
        $row = $result->fetch_assoc();
        $address_id = $row['address_id'];
        $update_address = $conn->prepare("UPDATE address SET address = ?, ward = ?, district = ?, city = ? WHERE id = ?");
        $update_address->bind_param("ssssi", $address, $ward, $district, $city, $address_id);
        if (!$update_address->execute()) {
            throw new Exception('Error updating address: ' . $conn->error);
        }
    } else {
        // Insert new address
        $insert_address = $conn->prepare("INSERT INTO address (address, ward, district, city) VALUES (?, ?, ?, ?)");
        $insert_address->bind_param("ssss", $address, $ward, $district, $city);
        if (!$insert_address->execute()) {
            throw new Exception('Error inserting address: ' . $conn->error);
        }
        $address_id = $conn->insert_id;
        $insert_user_address = $conn->prepare("INSERT INTO user_address (user_id, address_id) VALUES (?, ?)");
        $insert_user_address->bind_param("ii", $user_id, $address_id);
        if (!$insert_user_address->execute()) {
            throw new Exception('Error linking user to address: ' . $conn->error);
        }
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(['status' => 'success', 'message' => 'Shipping information updated successfully']);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    error_log('Error in update_shipping_info.php: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating shipping information']);
}

$conn->close();