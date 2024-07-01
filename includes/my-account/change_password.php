<?php
ob_start();
include '../db_connect.php';
include '../../mail/mail.php';

$response = array();

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
                    // Password updated successfully, send email notification
                    $mailer = new Mailer();
                    $title = "Password Change Notification";
                    $content = "Hello,<br><br>
                    Your password has been successfully changed. If you did not make this change, please contact our support team immediately.<br><br>
                    Best regards,<br>
                    Hoot Records Store";
                    
                    if ($mailer->sendMail($title, $content, $email)) {
                        $response = array("success" => true, "message" => "Password updated successfully and notification email sent");
                    } else {
                        $response = array("success" => true, "message" => "Password updated successfully, but failed to send notification email");
                    }
                } else {
                    error_log("Error updating password: " . $conn->error);
                    $response = array("success" => false, "message" => "An error occurred while updating the password: " . $conn->error);
                }
            } else {
                $response = array("success" => false, "message" => "Current password is incorrect");
            }
        } else {
            $response = array("success" => false, "message" => "User not found");
        }
    } else {
        $response = array("success" => false, "message" => "New password and confirm password do not match");
    }
} else {
    $response = array("success" => false, "message" => "Invalid request method");
}

$output = ob_get_clean(); // Lấy và xóa buffer
if (!empty($output)) {
    error_log("Unexpected output before JSON: " . $output);
}

// Gửi phản hồi JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>