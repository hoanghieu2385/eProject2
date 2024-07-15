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
        $address = $result->fetch_assoc();
        // Replace empty values with 'Not set'
        foreach ($address as $key => $value) {
            if ($value === '' || $value === null) {
                $address[$key] = 'Not set';
            }
        }
        return $address;
    } else {
        return [
            'city' => 'Not set',
            'district' => 'Not set',
            'ward' => 'Not set',
            'address' => 'Not set'
        ];
    }
}

// Handle POST request for updating address
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $province = trim($_POST['province']) ?? '';
    $district = trim($_POST['district']) ?? '';
    $ward = trim($_POST['ward']) ?? '';
    $detailedAddress = trim($_POST['detailedAddress']) ?? '';

    // Check if all fields are empty or just whitespace
    if (empty($province) && empty($district) && empty($ward) && empty($detailedAddress)) {
        echo json_encode(['success' => false, 'message' => 'All fields cannot be empty']);
        exit;
    }

    // Check if user already has an address
    $checkSql = "SELECT address_id FROM user_address WHERE user_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Update existing address
        $addressId = $checkResult->fetch_assoc()['address_id'];
        $updateSql = "UPDATE address SET city = ?, district = ?, ward = ?, address = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssssi", $province, $district, $ward, $detailedAddress, $addressId);
        $updateStmt->execute();
    } else {
        // Insert new address
        $insertAddressSql = "INSERT INTO address (city, district, ward, address) VALUES (?, ?, ?, ?)";
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