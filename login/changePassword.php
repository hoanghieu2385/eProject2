<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        echo "Mật khẩu không khớp.";
    } else {
        $conn = new mysqli('localhost', 'root', '', 'project2');

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        $email = $_SESSION['email'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE site_user SET password='$hashedPassword' WHERE email_address='$email'";

        if ($conn->query($sql) === TRUE) {
            echo "Password was successfully changed.";
        } else {
            echo "Lỗi: " . $conn->error;
        }

        $conn->close();

        session_unset();
        session_destroy();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="../css/Login/changePassword.css">
</head>

<body>
    <?php include '../includes/header.php' ?>

    <div class="main-content">
        <h2 class="main-title">Change Password</h2>
        <?php
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        if (isset($success_message)) {
            echo '<p class="success-message">' . $success_message . '</p>';
        }
        ?>
        <form class="password-change-form" method="post" action="">
            <label class="form-label" for="new_password">A new password <span class="required">*</span></label>
            <input class="form-input" type="password" id="new_password" name="new_password" required>
            <br>
            <label class="form-label" for="confirm_password">Confirm password <span class="required">*</span></label>
            <input class="form-input" type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <button class="form-button" type="submit">Change Password</button>
        </form>
    </div>

    <?php include '../includes/footer.php' ?>
</body>

</html>