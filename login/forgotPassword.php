<?php
require_once '../mail/mail.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $verificationCode = bin2hex(random_bytes(3));

    $_SESSION['verification_code'] = $verificationCode;
    $_SESSION['email'] = $email;

    $mailer = new Mailer();
    $subject = 'Confirmation code to change password';
    $body = 'Your confirmation code is: <b>' . $verificationCode . '</b>';

    if ($mailer->sendMail($subject, $body, $email)) {
        $_SESSION['message'] = 'The confirmation code has been sent to your email.';
        header('Location: verification.php');
        exit();
    } else {
        $_SESSION['error'] = 'An error occurred while sending the email.';
        header('Location: forgotPassword.php');
        exit();
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
    <link rel="stylesheet" href="../css/Login/forgotPassword.css">
</head>
<body>
    <?php include '../includes/header.php' ?>

    <div class="main-content">
        <h2 class="main-title">Forgot Password</h2>
        <?php 
        if (isset($_SESSION['error'])) {
            echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <form class="forgot-password-form" method="post" action="">
            <label class="form-label" for="email">Email <span class="required">*</span></label>
            <input class="form-input" type="email" id="email" name="email" required>
            <button class="form-button" type="submit">Send Confirmation Code</button>
            <a href="./sign_up.php" class="signup-password">Do not have an account ?</a>
        </form>
    </div>

    <?php include '../includes/footer.php' ?>
</body>
</html>
