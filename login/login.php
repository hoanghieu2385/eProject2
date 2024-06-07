<?php
session_start();

if(isset($_POST['submit-btn'])){
    $error = array();

    if($_POST['username'] != ""){
        $username = $_POST['username'];
    } else {
        $error[] = "Tên tài khoản chưa nhập";
    }
    if($_POST['password'] != ""){
        $password = $_POST['password'];
    } else {
        $error[] = "Mật khẩu chưa nhập";
    }

    if(!empty($username) && !empty($password)){
        $conn = mysqli_connect('localhost', 'root', '', 'login') or die("Kết nối thất bại");
        mysqli_set_charset($conn, 'utf8');

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row){
            $_SESSION['login'] = $row['username'];
            header('location:index.php');
        } else {
            $error[] = "Đăng nhập không thành công.";
        }
        $stmt->close();
        $conn->close();
    }
    if($error){
        echo '<p style="color: red;">' . implode('<br>', $error) . '</p>';
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
            <?php
            if (isset($error_message)) {
                echo '<p style="color: red;">' . $error_message . '</p>';
            }
            ?>
            <div class="login-form">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="username">Email <span class="required">*</span></label>
                    <input type="text" id="username" name="username" required>
                
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>
                
                    <div class="login-options">
                        <button type="submit" name="submit-btn" class="submit-btn">Log in</button>
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
