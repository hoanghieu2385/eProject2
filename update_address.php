<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo 'error';
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo 'error';
    exit;
}

$user_id = $_SESSION['user_id'];
$address = $_POST['address'];
$ward = $_POST['ward'];
$district = $_POST['district'];
$city = $_POST['city'];

$sql = "UPDATE address SET address = ?, ward = ?, district = ?, city = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $address, $ward, $district, $city, $user_id);

if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'error';
}

$conn->close();
?>