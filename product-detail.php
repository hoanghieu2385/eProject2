<!-- product-detail.php -->
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT p.*, a.full_name as artist_name 
            FROM product p
            JOIN artist a ON p.artist_id = a.id
            WHERE p.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found";
        exit();
    }
} else {
    echo "No product specified";
    exit();
}

// Fetch related products
$sql_related = "SELECT p.*, a.full_name as artist_name 
                FROM product p
                JOIN artist a ON p.artist_id = a.id
                WHERE p.id != ?
                ORDER BY RAND()
                LIMIT 4";
$stmt_related = $conn->prepare($sql_related);
$stmt_related->bind_param("i", $product['id']);
$stmt_related->execute();
$result_related = $stmt_related->get_result();
$related_products = $result_related->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['album']); ?> - Record Store</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="../css/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="./js/product-cart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Darker+Grotesque:wght@300..900&display=swap');
    </style>
</head>

<body>
    <?php include './includes/header.php' ?>
    <div class="productcontainer" data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
        <div class="image-container">
            <img src="./uploads/<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['album']); ?>" onerror="this.onerror=null;this.src='./images/placeholder.jpg';">
        </div>
        <div class="description-container">
            <h2 class="title"><?php echo htmlspecialchars($product['album']); ?></h2>
            <h2 class="title"><i>by </i>
                <a href="allproduct.php?artist[]=<?php echo urlencode($product['artist_id']); ?>">
                    <?php echo htmlspecialchars($product['artist_name']); ?>
                </a>
            </h2>

            <p class="price">$<?php echo number_format($product['current_price'], 2); ?></p>
            <div class="quantity-box">
                <button class="minus-btn">-</button>
                <span class="quantity">1</span>
                <button class="plus-btn">+</button>
            </div>
            <button class="add-to-cart-btn" onclick="addToCart(event)">ADD TO CART</button>
            <div class="description-text">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </div>
        </div>
    </div>

    <div class="related-products">
        <h2>Related Products</h2>
        <div class="product-grid">
            <?php foreach ($related_products as $related_product) : ?>
                <div class="product-item">
                    <a href="product-detail.php?id=<?php echo $related_product['id']; ?>">
                        <img src="./uploads/<?php echo htmlspecialchars($related_product['product_image']); ?>" alt="<?php echo htmlspecialchars($related_product['album']); ?>" onerror="this.onerror=null;this.src='./images/placeholder.jpg';">
                    </a>
                    <h3><?php echo htmlspecialchars($related_product['album']); ?></h3>
                    <p class="artist">
                        <a href="allproduct.php?artist[]=<?php echo urlencode($product['artist_id']); ?>">
                            <i>by </i><?php echo htmlspecialchars($product['artist_name']); ?>
                        </a>
                    </p>
                    <p class="price">$<?php echo number_format($related_product['current_price'], 2); ?></p>
                    <button class="view-product" onclick="location.href='product-detail.php?id=<?php echo $related_product['id']; ?>'">VIEW PRODUCT</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include './includes/cart.php' ?>
    <?php include './includes/footer.php' ?>
</body>

</html>