<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    if ($password !== $confirm_password) {
        echo "Confirm password does not match";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Failed to register user";
        }

        $conn->close();
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
                    <form action="sign_up.php" method="post">
                    <label for="username">Email <span class="required">*</span></label>
                    <input type="Username" id="username" name="username" required>

                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>

                    <label for="confirm_password">Re-enter Password <span class="required">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" required>

                    <button href="./login.php" type="submit">Sign up</button>
                    <p>*Confirm your account by clicking the email we sent</p>
                    </form>
                </div>
            </div>
        </div>
        
    </main>

    <?php include '../includes/footer.php'?>
</body>
</html>
