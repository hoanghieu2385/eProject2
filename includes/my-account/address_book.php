<?php

include '../db_connect.php';

$user_id = $_SESSION['user_id'];

// Function to get user's address
function getUserAddress($conn, $user_id) {
    $sql = "SELECT a.* FROM address a
            JOIN user_address ua ON a.id = ua.address_id
            WHERE ua.user_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return [
            'tỉnh_thành_phố' => 'Not set',
            'quận_huyện' => 'Not set',
            'xã_phường' => 'Not set',
            'địa_chỉ' => 'Not set'
        ];
    }
}

// Handle POST request for updating address
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $province = $_POST['province'] ?? '';
    $district = $_POST['district'] ?? '';
    $ward = $_POST['ward'] ?? '';
    $detailedAddress = $_POST['detailedAddress'] ?? '';

    // Check if user already has an address
    $checkSql = "SELECT address_id FROM user_address WHERE user_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Update existing address
        $addressId = $checkResult->fetch_assoc()['address_id'];
        $updateSql = "UPDATE address SET tỉnh_thành_phố = ?, quận_huyện = ?, xã_phường = ?, địa_chỉ = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssssi", $province, $district, $ward, $detailedAddress, $addressId);
        $updateStmt->execute();
    } else {
        // Insert new address
        $insertAddressSql = "INSERT INTO address (tỉnh_thành_phố, quận_huyện, xã_phường, địa_chỉ) VALUES (?, ?, ?, ?)";
        $insertAddressStmt = $conn->prepare($insertAddressSql);
        $insertAddressStmt->bind_param("ssss", $province, $district, $ward, $detailedAddress);
        $insertAddressStmt->execute();
        $addressId = $conn->insert_id;

        // Link address to user
        $linkAddressSql = "INSERT INTO user_address (user_id, address_id) VALUES (?, ?)";
        $linkAddressStmt = $conn->prepare($linkAddressSql);
        $linkAddressStmt->bind_param("ii", $user_id, $addressId);
        $linkAddressStmt->execute();
    }

    echo json_encode(['success' => true, 'message' => 'Address updated successfully']);
    exit;
}

// Handle GET request for retrieving address
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $address = getUserAddress($conn, $user_id);
    echo json_encode($address);
    exit;
}

$conn->close();
?>