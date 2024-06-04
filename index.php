<?php
session_start();

if (isset($_POST['dark_mode'])) {  // Check if dark mode preference is submitted
    $_SESSION['dark_mode'] = $_POST['dark_mode'];  // Update session variable
}

$dark_mode = isset($_SESSION['dark_mode']) ? $_SESSION['dark_mode'] : false;  // Get dark mode preference
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
</head>

<body>
    <?php include './includes/header.php' ?>

    <p>Hoang Hieu demo</p>
    <p>Hoang Hieu demo</p>

    <img src="./images/header/logo.png" alt="">
    <br>
    <br>
    <img src="./images/header/logo.png" alt="">
    <br>
    <br>
    <img src="./images/header/logo.png" alt="">
    <br>
    <br>
    <img src="./images/header/logo.png" alt="">
    <br>
    <br>
    <img src="./images/header/logo.png" alt="">
    <br>
    <br>
    <img src="./images/header/logo.png" alt="">
    <br>
    <br>
    <img src="./images/header/logo.png" alt="">
    <br>
    <br>
    <img src="./images/header/logo.png" alt="">
    <br>
    <br>

    <?php include './includes/footer.php' ?>

</body>

</html>