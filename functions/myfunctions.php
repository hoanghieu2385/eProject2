<?php

// session_start() was previously in includes/header.php
// session_start();
include('../config/dbcon.php');

function getAll($table) {

    global $con;
    $query = "SELECT * FROM $table";
    return $query_run = mysqli_query($con, $query);
}

function getByID($table, $id) {

    global $con;
    $query = "SELECT * FROM $table WHERE id = '$id'";
    return $query_run = mysqli_query($con, $query);
}
function redirect($url, $message)
{
    $_SESSION['message'] = $message;
    header('Location: ' . $url);
    exit();
}

function getAllOrders() {

    global $con;
    $query = "SELECT * FROM shop_order WHERE order_status_id = '1' AND order_status_id = '2' AND order_status_id = '3'";
    return $query_run = mysqli_query($con, $query);
}
