<?php
include('../functions/myfunctions.php');

if (isset($_SESSION['auth'])) {
    if (isset($_SESSION['auth_user']['role_as']) && $_SESSION['auth_user']['role_as'] != 1) {
        redirect("../index.php", "You are not authorized to access this page.");
    }
} else {
    redirect("../login/login.php", "Please login to continue.");
}
?>