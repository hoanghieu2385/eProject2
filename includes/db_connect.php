<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // User is not logged in, display a message and a login button
    echo '<style>
    .login-message {
        font-size: 18px;
        color: #ff0000;
        text-align: center;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin: 20px auto;
        max-width: 400px;
    }
    .login-button {
        display: block;
        width: 100px;
        height: 40px;
        margin: 20px auto;
        background-color: #76919d;
        color: white;
        text-align: center;
        line-height: 40px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 200px;
    }
    </style>';
    include './includes/header.php';
    echo '<p class="login-message">You must login first</p>';
    echo '<a href="../login/login.php" class="login-button">Login</a>';
    echo '<div class="footer-space1"> </div>';
    include './includes/footer.php';
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
