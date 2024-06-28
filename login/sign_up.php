<?php
session_start();

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

        $sql = "INSERT INTO site_user (email_address, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $hashed_password);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: ../my_account.php");
            exit();
        } else {
            $error_message = "Failed to register user";
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
    <script src="../js/login and sign_up.js"></script>
</head>

<body>
    <?php include '../includes/header.php' ?>
    <div class="header-space" style="height: 100px;"></div>
    <main>
        <div class="form-outer">
            <div class="form-container">
                <div class="form-login">
                    <a href="./login.php" class="login-btn" style="text-decoration: none;">LOG IN</a>
                    <a href="./sign_up.php" class="signup-btn active" style="text-decoration: none;">SIGN UP</a>
                </div>
                <div class="signup-form">
                    <form action="sign_up.php" method="post">
                        <label for="email">Email <span class="required">*</span></label>
                        <input class="email" type="email" id="email" name="email" autofocus>

                        <label for="password">Password <span class="required">*</span></label>
                        <input class="password" type="password" id="password" name="password" required>

                        <label for="confirm_password">Re-enter Password <span class="required">*</span></label>
                        <input class="password" type="password" id="confirm_password" name="confirm_password" required>

                        <?php if (isset($error_message)) {
                            echo '<p style="color: red;">' . $error_message . '</p>';
                        } ?>

                        <button href="./login.php" type="submit">Sign up</button>
                        <p class="confirm_account">*Confirm your account by clicking the email we sent</p>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include '../includes/footer.php' ?>
</body>

</html>