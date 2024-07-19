<?php
session_start();

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

$sql_bestsellers = "SELECT p.id, p.album, p.description, p.product_image, p.current_price, a.full_name as artist_name
                    FROM product p
                    JOIN artist a ON p.artist_id = a.id
                    ORDER BY p.current_price DESC
                    LIMIT 8";

$result_bestsellers = $conn->query($sql_bestsellers);

$bestsellers = [];

if ($result_bestsellers->num_rows > 0) {
    while ($row = $result_bestsellers->fetch_assoc()) {
        $bestsellers[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoot Records</title>
    <link rel="icon" type="image/x-icon" href="../images/header/logo.png">
    <link rel="stylesheet" href="./css/index.css">
    <script defer src="./js/index.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
</head>

<body>
    <?php include './includes/header.php' ?>

    <?php if (isset($_SESSION['login_success'])) : ?>
        <div id="loginNotification" class="login-notification">
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            Login success!
        </div>
        <script>
            window.onload = function() {
                var notification = document.getElementById('loginNotification');
                var progressBar = notification.querySelector('.progress');
                notification.classList.add('show');
                setTimeout(function() {
                    notification.classList.remove('show');
                }, 5000);
                progressBar.style.width = '0';
            };
        </script>
        <?php
        // Xóa thông báo khỏi session sau khi đã hiển thị
        unset($_SESSION['login_success']);
        ?>
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
            <!-- Trong phần New Release -->
            <h2>NEW RELEASE</h2>
            <div class="carousel" data-flickity='{ "wrapAround": true, "autoPlay": true }'>
                <?php foreach ($products as $product) : ?>
                    <div class="carousel-cell">
                        <div class="album-item">
                            <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                                <img src="./uploads/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['album']); ?>" onerror="this.onerror=null;this.src='./images/placeholder.jpg';">
                                <p><?php echo htmlspecialchars($product['album']); ?><br>by <em><?php echo htmlspecialchars($product['artist_name']); ?></em></p>
                            </a>
                            <p>$<?php echo number_format($product['current_price'], 2); ?></p>
                            <button onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Trong phần Bestsellers -->
            <h2>BESTSELLERS</h2>
            <div class="carousel" data-flickity='{ "wrapAround": true, "autoPlay": true}'>
                <?php foreach ($bestsellers as $bestseller) : ?>
                    <div class="carousel-cell">
                        <div class="album-item">
                            <a href="product-detail.php?id=<?php echo $bestseller['id']; ?>">
                                <img src="./uploads/<?php echo htmlspecialchars($bestseller['product_image']); ?>" alt="<?php echo htmlspecialchars($bestseller['album']); ?>" onerror="this.onerror=null;this.src='./images/placeholder.jpg';">
                                <p><?php echo htmlspecialchars($bestseller['album']); ?><br>by <em><?php echo htmlspecialchars($bestseller['artist_name']); ?></em></p>
                            </a>
                            <p>$<?php echo number_format($bestseller['current_price'], 2); ?></p>
                            <button onclick="addToCart(<?php echo $bestseller['id']; ?>)">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </main>
    </div>
    <?php include './includes/cart.php' ?>
    <?php include './includes/footer.php' ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 5000); // Hiển thị trong 5 giây
            }
        });
    </script>
</body>

</html>