<?php
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_GET['email'];

$sql = "SELECT * FROM site_user WHERE email_address = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode(['exists' => $result->num_rows > 0]);

$stmt->close();
$conn->close();
?>