<?php

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
    echo '<p class="login-message">You must login first</p>';
    echo '<a href="../login/login.php" class="login-button">Login</a>';
    echo '<div class="footer-space1"> </div>';
    exit;
}

$host = "localhost";
$username = "root";
$password = "";
$database = "project2";

// Creating database connect
$con = mysqli_connect($host, $username, $password, $database);

// Check database connect
if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}
