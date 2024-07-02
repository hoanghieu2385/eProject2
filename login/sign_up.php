<?php
session_start();
require_once '../mail/mail.php';

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "project2";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        $error_message = "Confirm password does not match";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $token = bin2hex(random_bytes(16));
        $sql = "INSERT INTO site_user (email_address, password, token) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $hashed_password, $token);

        if ($stmt->execute()) {
            $mailer = new Mailer();
            $confirm_link = "http://localhost:3000/login/confirm.php?token=" . $token;
            $email_body = "
                <html>
                <head>
                    <title>Confirm account registration</title>
                </head>
                <body>
                    <h1>Wellcome!</h1>
                    <p>Thank you for registering an account. Please click the button below to confirm your registration:</p>
                    <a href='$confirm_link' style='display: inline-block; padding: 10px 20px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;'>Confirm registration</a>
                </body>
                </html>
            ";

            $mail_sent = $mailer->sendMail("Confirm account registration", $email_body, $email);

            if ($mail_sent) {
                $success_message = "Sign Up Success! Confirmation email has been sent. Please check your email.";
            } else {
                $error_message = "Registration was successful, but there was an error sending the confirmation email. Please contact admin.";
            }
        } else {
            $error_message = "Registration failed. Please try again.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="icon" type="image/x-icon" href="../images/header/logo.png">
    <link rel="stylesheet" href="../css/Login/sign_up.css">
    <script src="../js/login/sign_up.js"></script>
</head>

<body>
    <?php include '../includes/header.php' ?>
    <main>
        <div class="form-outer">
            <div class="form-container">
                <div class="form-login">
                    <a href="./login.php" class="login-btn" style="text-decoration: none;">LOG IN</a>
                    <a href="./sign_up.php" class="signup-btn active" style="text-decoration: none;">SIGN UP</a>
                </div>
                <div class="signup-form">
                    <?php
                    if (!empty($error_message)) {
                        echo '<p style="color: red;">' . $error_message . '</p>';
                    }
                    if (!empty($success_message)) {
                        echo '<p style="color: green;">' . $success_message . '</p>';
                    }
                    ?>
                    <form action="sign_up.php" method="post">
                        <label for="email">Email <span class="required">*</span></label>
                        <input class="email" type="email" id="email" name="email" placeholder="Email" autofocus required>

                        <label for="password">Password <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <input class="password" type="password" id="password" name="password" placeholder="Password" required>
                            <i class="fas fa-eye-slash eye-icon" onclick="togglePasswordVisibility('password')"></i>
                        </div>

                        <label for="confirm_password">Re-enter Password <span class="required">*</span></label>
                        <div class="input-wrapper-confirm">
                            <input class="confirm_password" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                            <i class="fas fa-eye-slash eye-icon" onclick="togglePasswordVisibility('confirm_password')"></i>
                        </div>

                        <button type="submit">Sign up</button>
                        <p class="confirm_account">*Confirm your account by clicking the email we sent</p>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include '../includes/footer.php' ?>
</body>

</html>