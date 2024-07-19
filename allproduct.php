<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category_sql = "SELECT * FROM product_category";
$category_result = $conn->query($category_sql);

$genre_sql = "SELECT * FROM genre";
$genre_result = $conn->query($genre_sql);

$artist_sql = "SELECT * FROM artist";
$artist_result = $conn->query($artist_sql);

$country_sql = "SELECT * FROM country";
$country_result = $conn->query($country_sql);

$conditions = [];

$selected_categories = isset($_GET['category']) ? $_GET['category'] : [];
$selected_genres = isset($_GET['genre']) ? $_GET['genre'] : [];
$selected_artists = isset($_GET['artist']) ? $_GET['artist'] : [];
$selected_countries = isset($_GET['country']) ? $_GET['country'] : [];

if (!empty($selected_categories)) {
    $category_ids = array_map('intval', $selected_categories);
    $category_list = implode(',', $category_ids);
    $conditions[] = "product.category_id IN ($category_list)";
}

if (!empty($selected_genres)) {
    $genre_ids = array_map('intval', $selected_genres);
    $genre_list = implode(',', $genre_ids);
    $conditions[] = "artist_genre.genre_id IN ($genre_list)";
}

if (!empty($selected_artists)) {
    $artist_ids = array_map('intval', $selected_artists);
    $artist_list = implode(',', $artist_ids);
    $conditions[] = "product.artist_id IN ($artist_list)";
}

if (!empty($selected_countries)) {
    $country_ids = array_map('intval', $selected_countries);
    $country_list = implode(',', $country_ids);
    $conditions[] = "artist.country_id IN ($country_list)";
}

$products_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $products_per_page;

$sql = "SELECT DISTINCT product.id, product.album, product.description, product.product_image, product.current_price 
        FROM product 
        INNER JOIN artist ON product.artist_id = artist.id
        INNER JOIN artist_genre ON artist.id = artist_genre.artist_id
        INNER JOIN genre ON artist_genre.genre_id = genre.id";

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'best-selling';

$total_sql = "SELECT COUNT(DISTINCT product.id) AS total 
              FROM product 
              INNER JOIN artist ON product.artist_id = artist.id
              INNER JOIN artist_genre ON artist.id = artist_genre.artist_id
              INNER JOIN genre ON artist_genre.genre_id = genre.id";

if (!empty($conditions)) {
    $total_sql .= " WHERE " . implode(" AND ", $conditions);
}

$total_result = $conn->query($total_sql);
$total_products = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $products_per_page);

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
        $sql .= " ORDER BY product.id DESC";
        break;
}

$sql .= " LIMIT $products_per_page OFFSET $offset";

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
                                            <input type="checkbox" class="filter-checkbox" name="category[]" 
                                                   value="<?php echo htmlspecialchars($category['id']); ?>"
                                                   <?php echo in_array($category['id'], $selected_categories) ? 'checked' : ''; ?>>
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
                                            <input type="checkbox" class="filter-checkbox" name="genre[]" 
                                                   value="<?php echo htmlspecialchars($genre['id']); ?>"
                                                   <?php echo in_array($genre['id'], $selected_genres) ? 'checked' : ''; ?>>
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
                                            <input type="checkbox" class="filter-checkbox" name="artist[]" 
                                                   value="<?php echo htmlspecialchars($artist['id']); ?>"
                                                   <?php echo in_array($artist['id'], $selected_artists) ? 'checked' : ''; ?>>
                                            <?php echo htmlspecialchars($artist['full_name']); ?>
                                        </label>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort_order); ?>">
                    <input type="hidden" name="page" value="1">
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
                    <?php
                    foreach ($_GET as $key => $value) {
                        if ($key != 'sort' && $key != 'page') {
                            if (is_array($value)) {
                                foreach ($value as $v) {
                                    echo '<input type="hidden" name="' . htmlspecialchars($key) . '[]" value="' . htmlspecialchars($v) . '">';
                                }
                            } else {
                                echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                            }
                        }
                    }
                    ?>
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
            <?php
            $params = $_GET;
            unset($params['page']);
            $query_string = http_build_query($params);

            if ($page > 1) {
                echo '<a href="?page=' . ($page - 1) . '&' . $query_string . '">&laquo; Previous</a>';
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<span class="current">' . $i . '</span>';
                } else {
                    echo '<a href="?page=' . $i . '&' . $query_string . '">' . $i . '</a>';
                }
            }

            if ($page < $total_pages) {
                echo '<a href="?page=' . ($page + 1) . '&' . $query_string . '">Next &raquo;</a>';
            }
            ?>
        </div>
    </main>

    <?php include './includes/footer.php' ?>
    <?php include './includes/cart.php' ?>
</body>

</html>