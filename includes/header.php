<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/dark-mode.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="../js/product-cart.js"></script>
</head>

<body>
    <header>
        <nav class="container-header">
            <a href="../index.php" class="logo">
                <img src="/images/header/logo_co_chu.png" alt="Record Store" height="60px">
            </a>
            <div class="header-right">
                <div class="search-container">
                    <input id="search" type="text" placeholder="Search...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="icons">
                    <div class="user-icon">
                        <i class="fa-regular fa-circle-user fa-xl" id="user-icon-btn"></i>
                        <ul class="sub-menu" id="user-menu">
                            <li><a href="../my_account.php?section=order-History" id="orderHistory">Orders</a></li>
                            <li><a href="../my_account.php?section=account-Detail" id="accountDetail">Account Detail</a></li>
                            <li><a href="javascript:void(0);" onclick="logout(); return false;" id="logout-btn">Logout</a></li>
                            <li><a href="../login/login.php" id="login-btn">Login</a></li>
                            <li><a href="../login/sign_up.php" id="signUp-btn">Sign Up</a></li>
                        </ul>
                    </div>
                    <a id="cart-icon">
                        <i class="fa-solid fa-bag-shopping fa-xl"></i>
                        <span id="cart-count" class="cart-count">0</span>
                    </a>
                    <div class="dark-mode-toggle">
                        <input type="checkbox" id="dark-mode-checkbox">
                        <label for="dark-mode-checkbox">
                            <i class="fa-regular fa-sun"></i>
                            <i class="fa-regular fa-moon"></i>
                            <div class="ball"></div>
                        </label>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="category-menu">
            <ul id="main-menu">
                <li>
                    <a href="#">Vinyl<span><i class="fa-solid fa-caret-down"></i></span></a>
                    <ul class="sub-menu">
                        <li><a href="./residential.html">Residential</a></li>
                        <li><a href="./commercial.html">Commercial</a></li>
                        <li><a href="./fact_and_methods.html">Facts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">CDs<span><i class="fa-solid fa-caret-down"></i></span></a>
                    <ul class="sub-menu">
                        <li><a href="./residential.html">Residential</a></li>
                        <li><a href="./commercial.html">Commercial</a></li>
                        <li><a href="./fact_and_methods.html">Facts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Cassettes <span><i class="fa-solid fa-caret-down"></i></span></a>
                    <ul class="sub-menu">
                        <li><a href="./residential.html">Residential</a></li>
                        <li><a href="./commercial.html">Commercial</a></li>
                        <li><a href="./fact_and_methods.html">Facts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Artists<span><i class="fa-solid fa-caret-down"></i></span></a>
                    <ul class="sub-menu">
                        <li><a href="./residential.html">Residential</a></li>
                        <li><a href="./commercial.html">Commercial</a></li>
                        <li><a href="./fact_and_methods.html">Facts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Genres<span><i class="fa-solid fa-caret-down"></i></span></a>
                    <ul class="sub-menu">
                        <li><a href="./residential.html">Residential</a></li>
                        <li><a href="./commercial.html">Commercial</a></li>
                        <li><a href="./fact_and_methods.html">Facts</a></li>
                    </ul>
                </li>
                </li>

            </ul>
        </nav>

    </header>
</body>
<div class="header-space0" style="height: 119px;"></div>

<script src="../js/search.js"></script>
<script src="../js/dark-mode.js"></script>
<script src="../js/check_login-logout.js"></script>
<script>
    function logout() {
        // Lưu URL hiện tại
        var currentURL = window.location.href;

        fetch('../login/logout.php', { // Đảm bảo đường dẫn này chính xác
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Xóa thông tin đăng nhập từ localStorage nếu có
                    localStorage.removeItem('userLoggedIn');
                    localStorage.removeItem('userEmail');
                    // Thêm bất kỳ item nào khác cần xóa

                    // Chuyển hướng đến URL hiện tại
                    window.location.href = currentURL;
                } else {
                    console.error('Logout failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>

</body>

</html>