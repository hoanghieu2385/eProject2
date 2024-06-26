<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputCode = $_POST["verification_code"];
    if ($inputCode === $_SESSION['verification_code']) {
        header("Location: changePassword.php");
        exit();
    } else {
        $error_message = "Mã xác nhận không đúng.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xác Nhận Mã</title>
</head>
<body>
    <h2>Xác Nhận Mã</h2>
    <?php 
    if (isset($_SESSION['message'])) {
        echo '<p style="color:green;">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }
    if (isset($error_message)) {
        echo '<p style="color:red;">' . $error_message . '</p>';
    }
    ?>
    <form method="post" action="">
        <label for="verification_code">Mã xác nhận:</label>
        <input type="text" id="verification_code" name="verification_code" required>
        <button type="submit">Xác nhận</button>
    </form>
</body>
</html>
