<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Vinyl Records from our Online Store</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include './includes/header.php' ?>

    <main class="vinyl-store">
        <h1 class="vinyl-store__title">Buy Vinyl Records from our Online Store</h1>
        <p class="vinyl-store__description">Order new and second hand Music Vinyl Records (LPs) from our online vinyl record store. We ship Australia wide. We offer a large selection of curate, high quality records at great prices. Do some online crate digging for vinyl LP records!</p>
        
        <div class="vinyl-store__filters">
            <div class="vinyl-store__filter-label">
                <h3>Filters</h3>
            </div>
            <div class="vinyl-store__sort">
                <label for="sort">Sort by</label>
                <select id="sort">
                    <option>Best selling</option>
                </select>
            </div>
        </div>

        <div class="vinyl-store__filters-detail">
            <div class="vinyl-store__filter-group">
                <h4>Type</h4>
                <label><input type="checkbox"> New</label><br>
                <label><input type="checkbox"> Second Hand</label>
            </div>
            <div class="vinyl-store__filter-group">
                <h4>Section</h4>
                <!-- Add more filter options here -->
            </div>
            <div class="vinyl-store__filter-group">
                <h4>Media Condition</h4>
                <!-- Add more filter options here -->
            </div>
            <div class="vinyl-store__filter-group">
                <h4>Format</h4>
                <!-- Add more filter options here -->
            </div>
        </div>

        <div class="vinyl-store__records">
            <div class="vinyl-store__record">
                <img src="./images/albums/fleetwood_mac.jpg" alt="Fleetwood Mac - Rumours">
                <h3>Fleetwood Mac - Rumours</h3>
                <p>New</p>
                <p class="vinyl-store__price">$45.00</p>
            </div>
            <div class="vinyl-store__record">
                <img src="./images/albums/amy_winehouse.jpg" alt="Amy Winehouse - Back To Black">
                <h3>Amy Winehouse - Back To Black</h3>
                <p>New</p>
                <p class="vinyl-store__price">$58.00</p>
            </div>
            <div class="vinyl-store__record">
                <img src="./images/albums/pink_floyd.jpg" alt="Pink Floyd - The Dark Side Of The Moon">
                <h3>Pink Floyd - The Dark Side Of The Moon (50th Anniversary European Edition + Stickers and Poster)</h3>
                <p>New</p>
                <p class="vinyl-store__price">$50.00</p>
            </div>
            <div class="vinyl-store__record">
                <img src="./images/albums/oasis.jpg" alt="Oasis - (What's The Story) Morning Glory?">
                <h3>Oasis - (What's The Story) Morning Glory? (2xLP)</h3>
                <p>New</p>
                <p class="vinyl-store__price">$62.00</p>
            </div>
        </div>
    </main>

    <?php include './includes/footer.php' ?>
</body>
</html>