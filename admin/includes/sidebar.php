<?php

$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);

?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="index.php">
            <span class="ms-1 font-weight-bold text-white">Hoot Records Base</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "index.php" ? 'active bg-gradient-primary' : ''; ?> " href="index.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "product.php" ? 'active bg-gradient-primary' : ''; ?> " href="product.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">library_music</i>
                    </div>
                    <span class="nav-link-text ms-1">Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "site_user.php" ? 'active bg-gradient-primary' : ''; ?> " href="site_user.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">people</i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "order.php" ? 'active bg-gradient-primary' : ''; ?> " href="order.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt</i>
                    </div>
                    <span class="nav-link-text ms-1">Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "payment_shipment.php" ? 'active bg-gradient-primary' : ''; ?> " href="payment_shipment.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">attach_money</i>
                    </div>
                    <span class="nav-link-text ms-1">Payment and Shipment</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "product_category.php" ? 'active bg-gradient-primary' : ''; ?> " href="product_category.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">label</i>
                    </div>
                    <span class="nav-link-text ms-1">Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "artist.php" ? 'active bg-gradient-primary' : ''; ?>" href="artist.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">face</i>
                    </div>
                    <span class="nav-link-text ms-1">Artists</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "genre.php" ? 'active bg-gradient-primary' : ''; ?>" href="genre.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">headset</i>
                    </div>
                    <span class="nav-link-text ms-1">Genres</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= $page == "country.php" ? 'active bg-gradient-primary' : ''; ?>" href="country.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">map</i>
                    </div>
                    <span class="nav-link-text ms-1">Countries</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn bg-gradient-primary mt-4 w-100" href="../../login/logout.php">Logout</a>
        </div>
    </div>
</aside>