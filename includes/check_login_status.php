<?php
session_start();
$isLoggedIn = isset($_SESSION['login']);
echo json_encode(['isLoggedIn' => $isLoggedIn]);
?>