<?php
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "SELECT * FROM site_user WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE site_user SET token = NULL WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $message = "Your account has been successfully verified! You will be redirected to the login page in 3 seconds...";

        header("refresh:3;url=login.php");
    } else {
        $message = "The confirmation link is invalid or has expired.";
    }

    $stmt->close();
} else {
    $message = "There is no confirmation code.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <style>
        .header-space {
            height: 100px;
        }

        .message {
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php' ?>

    <div class="message">
        <h2><?php echo $message; ?></h2>
        <?php if (strpos($message, "success") !== false) : ?>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer.php' ?>
</body>

</html>