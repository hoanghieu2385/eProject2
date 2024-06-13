<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/dark-mode.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <nav class="container-header">
            <a href="../index.php" class="logo">
                <img src="/images/header/logo.png" alt="Record Store" width="50" height="60">
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
                            <li><a href="#" id="manage-account">Manage account</a></li>
                            <li><a href="../login/login.php" id="login-logout-btn">Login</a></li>
                        </ul>
                    </div>
                    <a href="cart.php"><i class="fa-solid fa-bag-shopping fa-xl"></i></a>
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
                    <a href="#">All Vinyls<span><i class="fa-solid fa-caret-down"></i></span></a>
                    <ul class="sub-menu">
                        <li><a href="./residential.html">Residential</a></li>
                        <li><a href="./commercial.html">Commercial</a></li>
                        <li><a href="./fact_and_methods.html">Facts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">All CDs<span><i class="fa-solid fa-caret-down"></i></span></a>
                    <ul class="sub-menu">
                        <li><a href="./residential.html">Residential</a></li>
                        <li><a href="./commercial.html">Commercial</a></li>
                        <li><a href="./fact_and_methods.html">Facts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">All Cassettes <span><i class="fa-solid fa-caret-down"></i></span></a>
                    <ul class="sub-menu">
                        <li><a href="./residential.html">Residential</a></li>
                        <li><a href="./commercial.html">Commercial</a></li>
                        <li><a href="./fact_and_methods.html">Facts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Artist<span><i class="fa-solid fa-caret-down"></i></span></a>
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
                <li><a href="#">Vinyl Cares</a></li>
                <li><a href="../contact_us.php">Contact Us</a></li>

            </ul>
        </nav>
    </header>
    <div class="header-space"></div>

    <script src="../js/search.js"></script>
    <script src="../js/dark-mode.js"></script>
    <script src="../js/check_login-logout.js"></script>
    <script src="../js/show-hide_user-icon.js"></script>


    <!-- Scroll header -->
    <script>
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            const scrollPosition = window.pageYOffset;

            if (scrollPosition > 0) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        });
    </script>

</body>

</html>