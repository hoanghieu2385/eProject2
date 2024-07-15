<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy danh sách các category
$category_sql = "SELECT * FROM product_category";
$category_result = $conn->query($category_sql);

// Lấy danh sách các genre
$genre_sql = "SELECT * FROM genre";
$genre_result = $conn->query($genre_sql);

// Lấy danh sách các artist
$artist_sql = "SELECT * FROM artist";
$artist_result = $conn->query($artist_sql);

// Lấy danh sách các country
$country_sql = "SELECT * FROM country";
$country_result = $conn->query($country_sql);

$conditions = [];

if (isset($_GET['category']) && is_array($_GET['category'])) {
    $category_ids = array_map('intval', $_GET['category']);
    $category_list = implode(',', $category_ids);
    $conditions[] = "product.category_id IN ($category_list)";
}

if (isset($_GET['genre']) && is_array($_GET['genre'])) {
    $genre_ids = array_map('intval', $_GET['genre']);
    $genre_list = implode(',', $genre_ids);
    $conditions[] = "artist_genre.genre_id IN ($genre_list)";
}

if (isset($_GET['artist']) && is_array($_GET['artist'])) {
    $artist_ids = array_map('intval', $_GET['artist']);
    $artist_list = implode(',', $artist_ids);
    $conditions[] = "product.artist_id IN ($artist_list)";
}

if (isset($_GET['country']) && is_array($_GET['country'])) {
    $country_ids = array_map('intval', $_GET['country']);
    $country_list = implode(',', $country_ids);
    $conditions[] = "artist.country_id IN ($country_list)";
}

$sql = "SELECT DISTINCT product.id, product.album, product.description, product.product_image, product.current_price 
        FROM product 
        INNER JOIN artist ON product.artist_id = artist.id
        INNER JOIN artist_genre ON artist.id = artist_genre.artist_id
        INNER JOIN genre ON artist_genre.genre_id = genre.id";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$genre_filter = isset($_GET['genre']) ? $_GET['genre'] : [];
$product_type_filter = isset($_GET['product_type']) ? $_GET['product_type'] : [];
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'best-selling';

$sql = "SELECT product.id, product.album, product.description, product.product_image, product.current_price 
        FROM product 
        INNER JOIN artist_genre ON product.artist_id = artist_genre.artist_id
        INNER JOIN genre ON artist_genre.genre_id = genre.id";

$conditions = [];

if (!empty($genre_filter)) {
    $genre_list = implode("','", array_map([$conn, 'real_escape_string'], $genre_filter));
    $conditions[] = "genre.genre_name IN ('$genre_list')";
}

if (!empty($product_type_filter)) {
    $product_type_list = implode("','", array_map([$conn, 'real_escape_string'], $product_type_filter));
    $conditions[] = "product.category_id IN (SELECT id FROM product_category WHERE category_name IN ('$product_type_list'))";
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

switch ($sort_order) {
    case 'price-low-high':
        $sql .= " ORDER BY product.current_price ASC";
        break;
    case 'price-high-low':
        $sql .= " ORDER BY product.current_price DESC";
        break;
    case 'featured':
        // Thêm sắp xếp cụ thể cho 'featured' nếu cần
        break;
    case 'best-selling':
    default:
        // Sắp xếp mặc định nếu cần
        break;
}

$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    $no_results = true;
}

$conn->close();
?>

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

                    content.classList.toggle('show');

                    arrow.classList.toggle('up');
                });
            });
        });
    </script>

    <main class="hoot-records">
        <h1 class="hoot-records__title">Buy Records from our Online Store</h1>
        <p class="hoot-records__description">Order new and second hand Music Records from our online record store. We ship Australia wide. We offer a large selection of curated, high quality records at great prices. Do some online crate digging for records!</p>

        <div class="hoot-records__content">
            <aside class="hoot-records__filters">
                <form action="allproduct.php" method="GET">
                    <div class="hoot-records__filter-label">
                        <h3>Filters</h3>
                    </div>
                    <div class="hoot-records__filters-detail">
                        <div class="hoot-records__filter-group">
                            <div class="filter-item">
                                <button type="button" class="filter-btn">Product Type <span class="arrow"></span></button>
                                <div class="filter-content">
                                    <?php while ($category = $category_result->fetch_assoc()): ?>
                                        <label>
                                            <input type="checkbox" class="filter-checkbox" name="category[]" value="<?php echo htmlspecialchars($category['id']); ?>">
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </label>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="filter-item">
                                <button type="button" class="filter-btn">Genre <span class="arrow"></span></button>
                                <div class="filter-content">
                                    <?php while ($genre = $genre_result->fetch_assoc()): ?>
                                        <label>
                                            <input type="checkbox" class="filter-checkbox" name="genre[]" value="<?php echo htmlspecialchars($genre['id']); ?>">
                                            <?php echo htmlspecialchars($genre['genre_name']); ?>
                                        </label>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="filter-item">
                                <button type="button" class="filter-btn">Artist <span class="arrow"></span></button>
                                <div class="filter-content">
                                    <?php while ($artist = $artist_result->fetch_assoc()): ?>
                                        <label>
                                            <input type="checkbox" class="filter-checkbox" name="artist[]" value="<?php echo htmlspecialchars($artist['id']); ?>">
                                            <?php echo htmlspecialchars($artist['full_name']); ?>
                                        </label>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <hr>
                            <!-- <div class="filter-item">
                                <button type="button" class="filter-btn">Availability <span class="arrow"></span></button>
                                <div class="filter-content">
                                    <label><input type="checkbox" class="filter-checkbox" name="availability[]" value="In Stock"> In Stock</label>
                                    <label><input type="checkbox" class="filter-checkbox" name="availability[]" value="Out of Stock"> Out of Stock</label>
                                </div>
                            </div>
                            <hr>
                            <div class="filter-item">
                                <button type="button" class="filter-btn">Size <span class="arrow"></span></button>
                                <div class="filter-content">
                                    <label><input type="checkbox" class="filter-checkbox" name="size[]" value="7 inch"> 7 inch</label>
                                    <label><input type="checkbox" class="filter-checkbox" name="size[]" value="10 inch"> 10 inch</label>
                                    <label><input type="checkbox" class="filter-checkbox" name="size[]" value="12 inch"> 12 inch</label>
                                    <label><input type="checkbox" class="filter-checkbox" name="size[]" value="Set"> Set</label>
                                </div>
                            </div>
                            <hr>
                            <div class="filter-item">
                                <button type="button" class="filter-btn">Production Time <span class="arrow"></span></button>
                                <div class="filter-content">
                                    <label><input type="checkbox" class="filter-checkbox" name="production_time[]" value="1920s"> 1920s</label>
                                    <label><input type="checkbox" class="filter-checkbox" name="production_time[]" value="1930s"> 1930s</label>
                                    <label><input type="checkbox" class="filter-checkbox" name="production_time[]" value="1980s"> 1980s</label>
                                </div>
                            </div>
                            <hr>
                            <div class="filter-item">
                                <button type="button" class="filter-btn">Label <span class="arrow"></span></button>
                                <div class="filter-content">
                                    <label><input type="checkbox" class="filter-checkbox" name="label[]" value="Label1"> Label1</label>
                                    <label><input type="checkbox" class="filter-checkbox" name="label[]" value="Label2"> Label2</label>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <button type="submit" class="apply-filters-btn">Apply Filters</button>
                </form>
            </aside>
            <div class="hoot-records__main">
                <form action="allproduct.php" method="GET" id="sortForm">
                    <div class="hoot-records__sort">
                        <label for="sort">Sort by</label>
                        <select id="sort" name="sort" onchange="document.getElementById('sortForm').submit();">
                            <option value="best-selling" <?php echo $sort_order == 'best-selling' ? 'selected' : ''; ?>>Best selling</option>
                            <option value="featured" <?php echo $sort_order == 'featured' ? 'selected' : ''; ?>>Featured</option>
                            <option value="price-low-high" <?php echo $sort_order == 'price-low-high' ? 'selected' : ''; ?>>Price, low to high</option>
                            <option value="price-high-low" <?php echo $sort_order == 'price-high-low' ? 'selected' : ''; ?>>Price, high to low</option>
                        </select>
                    </div>
                </form>
                <div class="hoot-records__records">
                    <?php
                    if (!empty($products)) {
                        foreach ($products as $row) {
                            echo '<div class="hoot-records__record">';
                            echo '<img src="' . $row["product_image"] . '" alt="' . $row["album"] . '">';
                            echo '<h3>' . $row["album"] . '</h3>';
                            echo '<p>' . $row["description"] . '</p>';
                            echo '<p class="hoot-records__price">$' . $row["current_price"] . '</p>';
                            echo '</div>';
                        }
                    } else if (isset($no_results)) {
                        echo "No results found";
                    }
                    ?>
                </div>
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
    </main>

    <?php include './includes/footer.php' ?>
</body>

</html>