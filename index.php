<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Tortured Poets Department</title>
    <link rel="stylesheet" href="./css/index.css">
    <script defer src="./js/index.js"></script>

    <style>
        .login-notification {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: blue;
            color: white;
            padding: 10px;
            border-radius: 5px;
            opacity: 0;
            font-size: 30px;
            transition: opacity 0.5s ease-in-out;
        }
        .login-notification.show {
            opacity: 1;
        }
    </style>

</head>

<body>

    <?php include './includes/header.php' ?>

    <?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
        <div id="loginNotification" class="login-notification">Login success!</div>
        <script>
            window.onload = function() {
                var notification = document.getElementById('loginNotification');
                notification.classList.add('show');
                setTimeout(function() {
                    notification.classList.remove('show');
                }, 5000);
            };
        </script>
    <?php endif; ?>

    <div class="wrapper">
        <main class="container">
            <!-- <nav>
            <ul>
                <li><a href="#">Vinyl <span class="arrow">&#9660;</span></a></li>
                <li><a href="#">CDs <span class="arrow">&#9660;</span></a></li>
                <li><a href="#">Cassettes <span class="arrow">&#9660;</span></a></li>
                <li><a href="#">Artists <span class="arrow">&#9660;</span></a></li>
                <li><a href="#">Genres <span class="arrow">&#9660;</span></a></li>
                <li><a href="#">Accessories <span class="arrow">&#9660;</span></a></li>
            </ul>
        </nav> -->
            <section class="banner">
                <div class="banner-content">
                    <div class="banner-text">
                        <h1>The Tortured Poets Department</h1>
                        <button>Shop now</button>
                    </div>
                    <div class="banner-slider">
                        <div class="slides">
                            <img src="https://extra-images.akamaized.net/image/74/3by2/2024/04/17/74b8f23098be41c98138b8b49bd2022c_md.jpeg" alt="Banner Image 1">
                            <img src="https://danviet.mediacdn.vn/296231569849192448/2024/4/19/b12ff01e8bedf6b52fe1295313dca28f1000x1000x1-1713545336951174446382.jpg" alt="Banner Image 2">
                            <img src="https://www.billboard.com/wp-content/uploads/2024/04/Taylor-Swift-cr-Beth-Garrabrant-2024-The-Black-Sog-billboard-1548.jpg?w=942&h=623&crop=1" alt="Banner Image 3">
                        </div>
                        <div class="indicators">
                            <span class="dot" data-slide="1"></span>
                            <span class="dot" data-slide="2"></span>
                            <span class="dot" data-slide="3"></span>
                        </div>
                    </div>
                </div>
            </section>
            <section class="new-release">
                <h2>New Release</h2>
                <div class="carousel">
                    <button class="prev">&#10094;</button>
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < 8; $i++): ?>
                            <div class="album-item">
                                <img src="https://i.insider.com/6621f3fc10c6b0cde5f0fb36" alt="Product Image">
                                <p>The Tortured Poets Department<br>The <em>Album Name</em></p>
                                <p>$85.000</p>
                                <button>Add to Cart</button>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <button class="next">&#10095;</button>
                </div>
            </section>
            <section class="bestsellers">
                <h2>Bestsellers</h2>
                <div class="carousel">
                    <button class="prev">&#10094;</button>
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < 8; $i++): ?>
                            <div class="album-item">
                                <img src="https://i.insider.com/6621f3fc10c6b0cde5f0fb36" alt="Product Image">
                                <p>The Tortured Poets Department<br>The <em>Album Name</em></p>
                                <p>$85.000</p>
                                <button>Add to Cart</button>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <button class="next">&#10095;</button>
                </div>
            </section>
        </main>
    </div>

    <?php include './includes/footer.php' ?>

</body>

</html>