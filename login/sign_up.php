<?php

// Kiểm tra nếu phương thức yêu cầu là POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lấy dữ liệu từ form và làm sạch dữ liệu
    $email = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu trùng khớp
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Kiểm tra tính hợp lệ của email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit();
    }

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $dbname = "login";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Kiểm tra xem email đã tồn tại chưa
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Email already exists!";
        } else {
            // Thêm người dùng mới vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();
            echo "Sign up successful! Your account has been created.";

            // Chuyển hướng về trang đăng nhập
            header("Location: login.php");
            exit();
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    // Đóng kết nối
    $conn = null;
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
</head>
<body>
    <?php include '../includes/header.php'?>
    
    <main>
        <div class="form-outer">
            <div class="form-container">
                <div class="form-login">
                    <a href="./login.php" class="login-btn" style="text-decoration: none;">LOG IN</a>
                    <a href="./sign_up.php" class="signup-btn active" style="text-decoration: none;">SIGN UP</a>
                </div>
                <div class="signup-form">
                    <form action="signup.php" method="post">
                    <label for="username">User/ Email <span class="required">*</span></label>
                    <input type="Username" id="username" name="username" required>

                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>

                    <label for="confirm_password">Re-enter Password <span class="required">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" required>

                    <button type="submit">Sign up</button>
                    <p>*Confirm your account by clicking the email we sent</p>
                    </form>
                </div>
            </div>
        </div>
        
    </main>

    <?php include '../includes/footer.php'?>
</body>
</html>
