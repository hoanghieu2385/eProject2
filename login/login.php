<?php
session_start();
$error = array();

$conn = mysqli_connect('localhost', 'root', '', 'project2') or die("Connect failed.");
mysqli_set_charset($conn, 'utf8');

if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $cookie_email = $_COOKIE['email'];
    $cookie_password = $_COOKIE['password'];

    $stmt = $conn->prepare("SELECT * FROM site_user WHERE email_address = ?");
    $stmt->bind_param("s", $cookie_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($cookie_password, $row['password'])) {
        $_SESSION['login'] = $row['email'];
        header('Location: ../index.php');
        exit;
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-btn'])) {
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        $error[] = "Account name has not been entered.";
    }
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $error[] = "Password not entered.";
    }

    if (empty($error)) {
        $stmt = $conn->prepare("SELECT * FROM site_user WHERE email_address = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user_email'] = $email;

            if (isset($_POST['remember'])) {
                setcookie('email', $email, time() + (86400 * 30), "/");
                setcookie('password', $password, time() + (86400 * 30), "/");
            }

            header('Location: ../index.php');
            exit;
        } else {
            $error[] = "Invalid email or password.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="icon" type="image/x-icon" href="../images/header/logo.png">
    <link rel="stylesheet" href="../css/Login/login.css">
</head>

<body>
    <?php include '../includes/header.php' ?>
    
    <main>
        <div class="login-container">
            <div class="form-login">
                <a href="./login.php" class="login-btn active" style="text-decoration: none;">LOG IN</a>
                <a href="./sign_up.php" class="signup-btn" style="text-decoration: none;">SIGN UP</a>
            </div>
<<<<<<< HEAD
            <?php
            if (isset($error_message)) {
                echo '<p style="color: red;">' . $error_message . '</p>';
            }
            ?>
            <div class="login-form">
                <form onsubmit="login()" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="username">Email <span class="required">*</span></label>
                    <input type="username" id="username" name="username" required>
                
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>
                
=======

            <div class="login-form">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="email">Email <span class="required">*</span></label>
                    <input class="email" type="email" id="email" name="email" required autofocus>
                    <div class="password-input">
                        <label for="password">Password <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <input class="password" type="password" id="password" name="password" required>
                            <i class="fas fa-eye-slash eye-icon" onclick="togglePasswordVisibility()"></i>
                        </div>
                    </div>
                    <?php
                    if (!empty($error)) {
                        echo '<p style="color: red;">' . implode('<br>', $error) . '</p>';
                    }
                    ?>
>>>>>>> 8bf649c41518fba88c86e2360556b25ae78041e7
                    <div class="login-options">
                        <button type="submit" name="submit-btn" class="submit-btn">Log in</button>
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember password</label>
                        </div>
                    </div>
<<<<<<< HEAD
                
                    <a href="#" class="forgot-password">Forgot password?</a>
=======
                    <a href="./forgotPassword.php" class="forgot-password">Forgot password?</a>
>>>>>>> 8bf649c41518fba88c86e2360556b25ae78041e7
                </form>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php' ?>
</body>

</html>
