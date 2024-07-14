<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Records from our Online Store</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="./css/allproduct.css">
</head>

<body>
    <?php include './includes/header.php' ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.filter-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const arrow = this.querySelector('.arrow');

                    if (content.style.display === 'block') {
                        content.style.display = 'none';
                        arrow.classList.remove('up');
                    } else {
                        content.style.display = 'block';
                        arrow.classList.add('up');
                    }
                });
            });
        });
    </script>

    <main class="hoot-records">
        <h1 class="hoot-records__title">Buy Records from our Online Store</h1>
        <p class="hoot-records__description">Order new and second hand Music Records from our online record store. We ship Australia wide. We offer a large selection of curated, high quality records at great prices. Do some online crate digging for records!</p>

        <div class="hoot-records__content">
            <aside class="hoot-records__filters">
                <div class="hoot-records__filter-label">
                    <h3>Filters</h3>
                </div>
                <div class="hoot-records__filters-detail">
                    <div class="hoot-records__filter-group">
                        <div class="filter-item">
                            <button class="filter-btn">Genre <span class="arrow"></span></button>
                            <div class="filter-content">
                                <label><input type="checkbox"> Rock</label>
                                <label><input type="checkbox"> Rap</label>
                                <label><input type="checkbox"> Pop</label>
                            </div>
                        </div>
                        <hr>
                        <div class="filter-item">
                            <button class="filter-btn">Product Type <span class="arrow"></span></button>
                            <div class="filter-content">
                                <label><input type="checkbox"> CD</label>
                                <label><input type="checkbox"> Vinyl</label>
                                <label><input type="checkbox"> Cassette</label>
                                <label><input type="checkbox"> Merch</label>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </aside>
            <div class="hoot-records__main">
                <div class="hoot-records__sort">
                    <label for="sort">Sort by</label>
                    <select id="sort">
                        <option value="best-selling">Best selling</option>
                        <option value="featured">Featured</option>
                        <option value="price-low-high">Price, low to high</option>
                        <option value="price-high-low">Price, high to low</option>
                    </select>
                </div>
                <div class="hoot-records__records">
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Fleetwood Mac - Rumours">
                        <h3>Fleetwood Mac - Rumours</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$45.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Amy Winehouse - Back To Black">
                        <h3>Amy Winehouse - Back To Black</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$58.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Pink Floyd - The Dark Side Of The Moon">
                        <h3>Pink Floyd - The Dark Side Of The Moon (50th Anniversary European Edition + Stickers and Poster)</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$50.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Oasis - (What's The Story) Morning Glory?">
                        <h3>Oasis - (What's The Story) Morning Glory? (2xLP)</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$62.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Fleetwood Mac - Rumours">
                        <h3>Fleetwood Mac - Rumours</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$45.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Amy Winehouse - Back To Black">
                        <h3>Amy Winehouse - Back To Black</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$58.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Pink Floyd - The Dark Side Of The Moon">
                        <h3>Pink Floyd - The Dark Side Of The Moon (50th Anniversary European Edition + Stickers and Poster)</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$50.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Oasis - (What's The Story) Morning Glory?">
                        <h3>Oasis - (What's The Story) Morning Glory? (2xLP)</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$62.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Fleetwood Mac - Rumours">
                        <h3>Fleetwood Mac - Rumours</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$45.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Amy Winehouse - Back To Black">
                        <h3>Amy Winehouse - Back To Black</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$58.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Pink Floyd - The Dark Side Of The Moon">
                        <h3>Pink Floyd - The Dark Side Of The Moon (50th Anniversary European Edition + Stickers and Poster)</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$50.00</p>
                    </div>
                    <div class="hoot-records__record">
                        <img src="./images/product/taylor.jpg" alt="Oasis - (What's The Story) Morning Glory?">
                        <h3>Oasis - (What's The Story) Morning Glory? (2xLP)</h3>
                        <p>New</p>
                        <p class="hoot-records__price">$62.00</p>
                    </div>
                    
                </div>
                <div class="pagination">
                        <a href="#">&laquo;</a>
                        <a href="#" class="active">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <span>...</span>
                        <a href="#">10</a>
                        <a href="#">Next &raquo;</a>
                    </div>
            </div>
        </div>
    </main>

    <?php include './includes/footer.php' ?>
</body>

</html>