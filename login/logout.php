<?php
session_start();

// Hủy tất cả các biến session
$_SESSION = array();

// Xóa cookie session nếu có
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hủy session
session_destroy();

// Xóa cookie đăng nhập nếu có
if (isset($_COOKIE['email'])) {
    setcookie('email', '', time() - 3600, '/');
}
if (isset($_COOKIE['password'])) {
    setcookie('password', '', time() - 3600, '/');
}

// Chuyển hướng về trang chủ hoặc trang đăng nhập
header("Location: ../index.php");
exit();
?>