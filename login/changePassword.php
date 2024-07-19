<?php
session_start();

if (!isset($_SESSION['email'])) {
    die("Invalid access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (strlen($newPassword) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } elseif ($newPassword !== $confirmPassword) {
        $error_message = "Passwords do not match.";
    } else {
        $conn = new mysqli('localhost', 'root', '', 'project2');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $email = $_SESSION['email'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE site_user SET password=? WHERE email_address=?");
        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {
            session_unset();
            session_destroy();
            header("Location: login.php?message=Password changed successfully. Please log in again.");
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="icon" type="image/x-icon" href="../images/header/logo.png">
    <link rel="stylesheet" href="../css/Login/changePassword.css">
    <script src="../js/login/changePassword.js"></script>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div class="main-content">
        <h2 class="main-title">Change Password</h2>
        <?php
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>
        <form class="password-change-form" method="post" action="">
            <label class="form-label" for="new_password">A new password <span class="required">*</span></label>
            <div class="input-wrapper">
                <input class="form-input" type="password" id="new_password" name="new_password" required>
                <i class="fas fa-eye-slash eye-icon" onclick="togglePasswordVisibility('new_password')"></i>
            </div>
            <br>
            <label class="form-label" for="confirm_password">Confirm password <span class="required">*</span></label>
            <div class="input-wrapper">
                <input class="form-input" type="password" id="confirm_password" name="confirm_password" required>
                <i class="fas fa-eye-slash eye-icon" onclick="togglePasswordVisibility('confirm_password')"></i>
            </div>
            <br>
            <button class="form-button" type="submit">Change Password</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>