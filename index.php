<!-- index.php -->
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

$conn->close();
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
    <script href="./js/product-cart.js"></script>
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
                }, 2000);
                progressBar.style.width = '0';
            };
        </script>
        <?php
        // Xóa thông báo khỏi session sau khi đã hiển thị
        unset($_SESSION['login_success']);
        ?>
    <?php endif; ?>


    <div class="wrapper">
        <div class="hero-slider">
            <div class="carousel-cell" style="background-image: url(./images/product/BacksideTheTorturedVinyl.png);">
                <div class="overlay"></div>
                <div class="inner">
                    <h3 class="subtitle">Slide 1</h3>
                    <h2 class="title">Flickity parallax</h2>
                    <a href="#" class="btn">Tell me more</a>
                </div>
            </div>

            <div class="carousel-cell" style="background-image: url(./images/product/TheTorturedPoetsCDBonus.png);">
                <div class="overlay"></div>
                <div class="inner">
                    <h3 class="subtitle">Slide 2</h3>
                    <h2 class="title">Flickity parallax</h2>
                    <a href="#" class="btn">Tell me more</a>
                </div>
            </div>

            <div class="carousel-cell" style="background-image: url(./images/product/TheTorturedPoetsVinyl2.png);">
                <div class="overlay"></div>
                <div class="inner">
                    <h3 class="subtitle">Slide 3</h3>
                    <h2 class="title">Flickity parallax</h2>
                    <a href="#" class="btn">Tell me more</a>
                </div>
            </div>
        </div>

        <main class="container">
            <!-- Trong phần New Release -->
            <h2>NEW RELEASE</h2>
            <div class="carousel" data-flickity='{ "wrapAround": true, "autoPlay": true }'>
                <?php foreach ($products as $product) : ?>
                    <div class="carousel-cell">
                        <div class="album-item">
                            <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                                <img src="./uploads/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['album']); ?>" onerror="this.onerror=null;this.src='./images/placeholder.jpg';">
                            </a>
                            <div class="album-info">
                                <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                                    <div class="album-title"><?php echo htmlspecialchars($product['album']); ?></div>
                                    <div class="album-artist">by <?php echo htmlspecialchars($product['artist_name']); ?></div>
                                </a>
                                <div class="album-price">$<?php echo number_format($product['current_price'], 2); ?></div>
                            </div>
                            <button class="add-to-cart-btn" data-product-id="<?php echo $product['id']; ?>">Add to Cart</button>
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
                            </a>
                            <div class="album-info">
                                <a href="product-detail.php?id=<?php echo $bestseller['id']; ?>">
                                    <div class="album-title"><?php echo htmlspecialchars($bestseller['album']); ?></div>
                                    <div class="album-artist">by <?php echo htmlspecialchars($bestseller['artist_name']); ?></div>
                                </a>
                                <div class="album-price">$<?php echo number_format($bestseller['current_price'], 2); ?></div>
                            </div>
                            <button class="add-to-cart-btn" data-product-id="<?php echo $bestseller['id']; ?>">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </main>
    </div>
    <?php include './includes/cart.php' ?>
    <?php include './includes/footer.php' ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.1/flickity.pkgd.min.js"></script>
    <script type="text/javascript" src="./js/slide_banner.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 2000); // Hiển thị trong 2 giây
            }
        });
    </script>
</body>

</html>