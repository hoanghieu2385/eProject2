<?php

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
