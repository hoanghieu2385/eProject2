<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="../css/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="./js/quantitybox.js"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Darker+Grotesque:wght@300..900&display=swap');
    </style>

</head>

<body>
    <?php include '../includes/header.php' ?>
    <div class="productcontainer">
        <div class="image-container">
            <img src="../images/product/TheTorturedPoetsVinyl.png" alt="Description of the image">
            <img src="../images/product/BacksideTheTorturedVinyl.png" alt="Additional Product Image" class="additional-product-image">
            <img src="../images/product/TheTorturedPoetsVinyl2.png" alt="Additional Product Image" class="additional-product-image">
        </div>
        <div class="description-container">
            <h2 class="title">Speak Now (Taylor's Version)</h2>
            <h2 class="title">3LP Orchid Marbled Vinyl</h2>
            <p class="price">$38.99</p>
            <div class="quantity-box">
                <button class="minus-btn">-</button>
                <span class="quantity">1</span>
                <button class="plus-btn">+</button>
            </div>
            <button class="add-to-cart-btn">ADD TO CART</button>
            <img src="./images/product/SpeakNow.png" alt="Additional Image" class="additional-image">
            <div class="description-text">
                <p>SHIPS ON OR BEFORE JUNE 7, 2024</p>
                <p>Each Vinyl Album Includes</p>
                <p>22 Songs</p>
                <p>Including 6 previously unreleased Songs From</p>
                <p>The Vault</p>
                <p>Collectible album jacket with unique front and</p>
                <p>back cover art</p>
                <p>3 unique Orchid marbled color vinyl discs</p>
                <p>Collectible album sleeves including lyrics and</p>
                <p>never-before-seen photos</p>
                <p>Full size gatefold photograph and prologue</p>
                <p>Limit 4 per customer. U.S Customers Only.</p>
                <br>
                <p>Depiction of this product is a digital rendering</p>
                <p>and for illustrative purposes only. Actual product</p>
                <p>detailing may vary. Please note due to the custom</p>
                <p>marbling process, each vinyl unit will be slightly</p>
                <p>different in coloration.</p>
                <br>
                <p>© 2023 Taylor Swift</p>
                <p>Taylor Swift®</p>
            </div>
        </div>
    </div>
    <div class="related-products">
    <h2>Related Products</h2>
    <div class="product-grid">
        <div class="product-item">
            <img src="./images/product/TheTorturedPoets.png" alt="Product 1">
            <h3>The Tortured Poets Department Standard Digital Album</h3>
            <p class="price">$65.00</p>
            <button class="view-product">VIEW PRODUCT</button>
        </div>
        <div class="product-item">
            <img src="./images/product/TheTorturedPoetsCDBonus.png" alt="Product 2">
            <h3>The Tortured Poets Department CD + Bonus Track "The Manuscript"</h3>
            <p class="price">$75.00</p>
            <button class="view-product">VIEW PRODUCT</button>
        </div>
        <div class="product-item">
            <img src="./images/product/TheTorturedPoetsVinyl.png" alt="Product 3">
            <h3>The Tortured Poets Department Vinyl + Bonus Track "The Manuscript"</h3>
            <p class="price">$55.00</p>
            <button class="view-product">VIEW PRODUCT</button>
        </div>
        <div class="product-item">
            <img src="./images/product/TheTorturedPoetsDigitalAlbum.png" alt="Product 4">
            <h3>The Tortured Poets Department: The Anthology Digital Album</h3>
            <p class="price">$75.00</p>
            <button class="view-product">VIEW PRODUCT</button>
        </div>
    </div>
</div>
    <?php include '../includes/footer.php' ?>
</body>

</html>