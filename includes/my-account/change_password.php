<?php
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword == $confirmPassword) {
        $email = $_SESSION['user_email'];
        $sql = "SELECT password FROM site_user WHERE email_address = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($currentPassword, $row['password'])) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateSql = "UPDATE site_user SET password = '$hashedPassword' WHERE email_address = '$email'";

                if ($conn->query($updateSql) === TRUE) {
                    echo json_encode(array("success" => true, "message" => "Password updated successfully"));
                } else {
                    error_log("Error updating password: " . $conn->error);
                    echo json_encode(array("success" => false, "message" => "An error occurred while updating the password: " . $conn->error));
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Current password is incorrect"));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "User not found"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "New password and confirm password do not match"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}

$conn->close();
?>