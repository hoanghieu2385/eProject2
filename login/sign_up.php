<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $servername = "localhost";
    $username = "root";
    $dbname = "login";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            echo "Email already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();
            echo "Sign up successful! Please confirm your account via the email we sent.";
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

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
                    <button class="login-btn">LOG IN</button>
                    <button class="signup-btn active">SIGN UP</button>
                </div>
                <div class="signup-form">
                    <form action="signup.php" method="post">
                    <label for="username">User/Email <span class="required">*</span></label>
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
