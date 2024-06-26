<?php
session_start();
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $cookie_email = $_COOKIE['email'];
    $cookie_password = $_COOKIE['password'];

    $conn = mysqli_connect('localhost', 'root', '', 'project2') or die("Connect failed.");
    mysqli_set_charset($conn, 'utf8');

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $cookie_email, $cookie_password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $_SESSION['login'] = $row['email'];
        header('location:index.php');
        exit;
    }

    if (isset($_POST['submit-btn'])) {
        $error = array();

        if ($_POST['email'] != "") {
            $email = $_POST['email'];
        } else {
            $error[] = "Account name has not been entered.";
        }
        if ($_POST['password'] != "") {
            $password = $_POST['password'];
        } else {
            $error[] = "Password not entered.";
        }
    }
    $stmt->close();
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
    <link rel="stylesheet" href="../css/Login/login.css">
    <script src="../js/login and sign_up.js"></script>
</head>

<body>
    <?php include '../includes/header.php' ?>
    <div class="header-space" style="height: 100px;"></div>

    <main>
        <div class="login-container">
            <div class="form-login">
                <a href="./login.php" class="login-btn active" style="text-decoration: none;">LOG IN</a>
                <a href="./sign_up.php" class="signup-btn" style="text-decoration: none;">SIGN UP</a>
            </div>

            <div class="login-form">
                <form onsubmit="login()" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="email">Email <span class="required">*</span></label>
                    <input class="email" type="email" id="email" name="email" autofocus>
                    <div class="password-input">
                        <label for="password">Password <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <input class="password" type="password" id="password" name="password" required>
                            <i class="fas fa-eye-slash eye-icon" onclick="togglePasswordVisibility()"></i>
                        </div>
                    </div>
                    <div class="login-options">
                        <button type="submit" name="submit-btn" class="submit-btn">Log in</button>
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember password</label>
                        </div>
                    </div>
                    <?php
                    if (!empty($error)) {
                        echo '<p style="color: red;">' . implode('<br>', $error) . '</p>';
                    }
                    ?>
                    <a href="./forgotPassword.php" class="forgot-password">Forgot password?</a>
                </form>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php' ?>
</body>

</html>