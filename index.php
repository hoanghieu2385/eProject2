<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT p.id, p.album, p.description, p.product_image, p.current_price, a.full_name as artist_name 
        FROM product p
        JOIN artist a ON p.artist_id = a.id
        ORDER BY p.id DESC
        LIMIT 8";

$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoot Records</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="./css/index.css">
    <script defer src="./js/index.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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

    <?php if (isset($_GET['message']) && $_GET['message'] === 'success') : ?>
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
                        <?php foreach ($products as $product) : ?>
                            <div class="album-item">
                                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['album']); ?>">
                                <p><?php echo htmlspecialchars($product['album']); ?><br>by <em><?php echo htmlspecialchars($product['artist_name']); ?></em></p>
                                <p>$<?php echo number_format($product['current_price'], 2); ?></p>
                                <button onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
                            </div>
                        <?php endforeach; ?>
                        
                    </div>
                    <button class="next">&#10095;</button>
                </div>
            </section>
            <section class="bestsellers">
                <h2>Bestsellers</h2>
                <!-- <div class="carousel">
                    <button class="prev">&#10094;</button>
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < 8; $i++) : ?>
                            <div class="album-item">
                                <img src="https://i.insider.com/6621f3fc10c6b0cde5f0fb36" alt="Product Image">
                                <p>The Tortured Poets Department<br>The <em>Album Name</em></p>
                                <p>$85.000</p>
                                <button>Add to Cart</button>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <button class="next">&#10095;</button>
                </div> -->
            </section>
        </main>
    </div>

    <?php include './includes/footer.php' ?>

</body>

</html>