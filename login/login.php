<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $conn = new PDO('mysql:host=localhost;dbname=login', 'username', 'password');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid username or password";
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
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
</head>
<body>
    <?php include '../includes/header.php'?>

    <main>
        <div class="login-container">
            <div class="form-login">
                <a href="./login.php" class="login-btn active" style="text-decoration: none;">LOG IN</a>
                <a href="./sign_up.php" class="signup-btn" style="text-decoration: none;">SIGN UP</a>
            </div>
            <div class="login-form">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="username">Email <span class="required">*</span></label>
                    <input type="Username" id="username" name="username" required>
                
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>
                
                    <div class="login-options">
                        <button type="submit" class="submit-btn">Log in</button>
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember password</label>
                        </div>
                    </div>
                
                    <a href="#" class="forgot-password">Forgot password?</a>
                </form>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'?>
</body>
</html>
