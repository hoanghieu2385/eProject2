<?php
include '../db_connect.php';

function getUserDetails($conn)
{
    if (!isset($_SESSION['user_email'])) {
        return null;
    }

    $user_email = $_SESSION['user_email'];
    $sql = "SELECT first_name, last_name, email_address, phone_number FROM site_user WHERE email_address = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Replace empty values with null
        foreach ($user as $key => $value) {
            if ($value === '' || $value === null) {
                $user[$key] = null;
            }
        }
        return $user;
    } else {
        return null;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = getUserDetails($conn);
    header('Content-Type: application/json');
    echo json_encode($user);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_email'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $userEmail = $_SESSION['user_email'];

    $sql = "UPDATE site_user SET first_name = ?, last_name = ?, phone_number = ? WHERE email_address = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $firstName, $lastName, $phoneNumber, $userEmail);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Account details updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating account details']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
