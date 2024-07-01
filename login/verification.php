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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="../css/Login/verification.css">
</head>

<body>
    <?php include '../includes/header.php' ?>

    <div class="main-content">
        <h2 class="main-title">Confirm Code</h2>
        <?php
        if (isset($_SESSION['message'])) {
            echo '<p class="success-message">' . $_SESSION['message'] . '</p>';
            unset($_SESSION['message']);
        }
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>
        <form class="verification-form" method="post" action="">
            <label class="form-label" for="verification_code">Verification <span class="required">*</span></label>
            <input class="form-input" type="text" id="verification_code" name="verification_code" required>
            <button class="form-button" type="submit">Confirm</button>
        </form>
    </div>

    <?php include '../includes/footer.php' ?>
</body>

</html>