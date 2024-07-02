<?php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project2');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have the user's ID stored in the session
$user_id = $_SESSION['user_id'];

// Retrieve user's address
$sql = "SELECT a.*
        FROM address a
        INNER JOIN user_address ua ON a.id = ua.address_id
        WHERE ua.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $province = $row['tỉnh_thành_phố'];
    $district = $row['quận_huyện'];
    $ward = $row['xã_phường'];
    $detailedAddress = $row['địa_chỉ'];
} else {
    $province = 'Not set';
    $district = 'Not set';
    $ward = 'Not set';
    $detailedAddress = 'Not set';
}

$stmt->close();

// Update user's address
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $province = $_POST['province'];
    $district = $_POST['district'];
    $ward = $_POST['ward'];
    $detailedAddress = $_POST['detailedAddress'];

    $sql = "UPDATE address a
            INNER JOIN user_address ua ON a.id = ua.address_id
            SET a.tỉnh_thành_phố = ?, a.quận_huyện = ?, a.xã_phường = ?, a.địa_chỉ = ?
            WHERE ua.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $province, $district, $ward, $detailedAddress, $user_id);

    if ($stmt->execute()) {
        echo "Address updated successfully";
    } else {
        echo "Error updating address: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>