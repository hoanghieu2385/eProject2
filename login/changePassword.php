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
            echo "Mật khẩu đã được thay đổi thành công.";
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
    <title>Đổi Mật Khẩu</title>
</head>
<body>
    <h2>Đổi Mật Khẩu</h2>
    <form method="post" action="">
        <label for="new_password">Mật khẩu mới:</label>
        <input type="password" id="new_password" name="new_password" required>
        <br>
        <label for="confirm_password">Xác nhận mật khẩu:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br>
        <button type="submit">Đổi mật khẩu</button>
    </form>
</body>
</html>
