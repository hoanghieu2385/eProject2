<!-- allproduct.php -->
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

$conditions = [];
$join_conditions = [];

$selected_categories = isset($_GET['category']) ? $_GET['category'] : [];
$selected_genres = isset($_GET['genre']) ? $_GET['genre'] : [];
$selected_artists = isset($_GET['artist']) ? $_GET['artist'] : [];

$active_filters = [];

// Fetch category names for selected categories
if (!empty($selected_categories)) {
    $category_ids = array_map('intval', $selected_categories);
    $category_list = implode(',', $category_ids);
    $conditions[] = "product.category_id IN ($category_list)";

    $category_names_sql = "SELECT id, category_name FROM product_category WHERE id IN ($category_list)";
    $category_names_result = $conn->query($category_names_sql);
    while ($category = $category_names_result->fetch_assoc()) {
        $active_filters['category'][$category['id']] = $category['category_name'];
    }
}

// Fetch genre names for selected genres
if (!empty($selected_genres)) {
    $genre_ids = array_map('intval', $selected_genres); // Make sure it's an array of integers
    $genre_list = implode(',', $genre_ids);
    $join_conditions[] = "INNER JOIN artist_genre ON artist.id = artist_genre.artist_id";
    $conditions[] = "artist_genre.genre_id IN ($genre_list)"; // Use genre_id for filtering

    // Fetch genre names for display using IDs
    $genre_names_sql = "SELECT id, genre_name FROM genre WHERE id IN ($genre_list)";
    $genre_names_result = $conn->query($genre_names_sql);
    while ($genre = $genre_names_result->fetch_assoc()) {
        $active_filters['genre'][$genre['id']] = $genre['genre_name']; // Store by ID
    }
}

// Fetch artist names for selected artists
if (!empty($selected_artists)) {
    $artist_ids = array_map('intval', $selected_artists);
    $artist_list = implode(',', $artist_ids);
    $conditions[] = "product.artist_id IN ($artist_list)";

    $artist_names_sql = "SELECT id, full_name FROM artist WHERE id IN ($artist_list)";
    $artist_names_result = $conn->query($artist_names_sql);
    while ($artist = $artist_names_result->fetch_assoc()) {
        $active_filters['artist'][$artist['id']] = $artist['full_name'];
    }
}

// remove_filter_from_url
function remove_filter_from_url($filter_type, $search_key)
{
    $params = $_GET;

    if (isset($params[$filter_type])) {
        if (is_array($params[$filter_type])) {
            // Handle arrays (like 'id[]' or 'values[]')
            $params[$filter_type] = array_filter(
                $params[$filter_type],
                function ($item) use ($search_key) {
                    return $item != $search_key;
                }
            );
        } else {
            // Handle single values (like 'id' or 'value')
            if ($params[$filter_type] == $search_key) {
                unset($params[$filter_type]);
            }
        }

        // Remove the parameter if it's now empty
        if (empty($params[$filter_type])) {
            unset($params[$filter_type]);
        }
    }

    return '?' . http_build_query($params);
}


$products_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $products_per_page;

$sql = "SELECT DISTINCT product.id, product.album, product.description, product.product_image, product.current_price 
        FROM product 
        INNER JOIN artist ON product.artist_id = artist.id
        INNER JOIN product_category ON product.category_id = product_category.id
        " . implode(" ", $join_conditions);

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'featured';

$total_sql = "SELECT COUNT(DISTINCT product.id) AS total 
              FROM product 
              INNER JOIN artist ON product.artist_id = artist.id
              INNER JOIN product_category ON product.category_id = product_category.id
              " . implode(" ", $join_conditions);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
        <p class="hoot-records__description">Order new and second hand Music Records from our online record store. We ship Viet Nam wide. We offer a large selection of curated, high quality records at great prices. Do some online crate digging for records!</p>

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
                                    <?php while ($category = $category_result->fetch_assoc()) : ?>
                                        <label>
                                            <input type="checkbox" class="filter-checkbox" name="category[]" value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo in_array($category['id'], $selected_categories) ? 'checked' : ''; ?>>
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </label>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="filter-item">
                                <button type="button" class="filter-btn">Genre <span class="arrow"></span></button>
                                <div class="filter-content">
                                    <?php while ($genre = $genre_result->fetch_assoc()) : ?>
                                        <label>
                                            <input type="checkbox" class="filter-checkbox" name="genre[]" value="<?php echo htmlspecialchars($genre['id']); ?>" <?php echo in_array($genre['id'], $selected_genres) ? 'checked' : ''; ?>>
                                            <?php echo htmlspecialchars($genre['genre_name']); ?>
                                        </label>
                                    <?php endwhile; ?>
                                </div>
                                <hr>
                            </div>
                            <div class="filter-item">
                                <div class="filter-item">
                                    <button type="button" class="filter-btn">Artist <span class="arrow"></span></button>
                                    <div class="filter-content">
                                        <?php while ($artist = $artist_result->fetch_assoc()) : ?>
                                            <label>
                                                <input type="checkbox" class="filter-checkbox" name="artist[]" value="<?php echo htmlspecialchars($artist['id']); ?>" <?php echo in_array($artist['id'], $selected_artists) ? 'checked' : ''; ?>>
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
                            <option value="featured" <?php echo $sort_order == 'featured' ? 'selected' : ''; ?>>Featured</option>
                            <option value="price-low-high" <?php echo $sort_order == 'price-low-high' ? 'selected' : ''; ?>>Price, low to high</option>
                            <option value="price-high-low" <?php echo $sort_order == 'price-high-low' ? 'selected' : ''; ?>>Price, high to low</option>
                            <option value="best-selling" <?php echo $sort_order == 'best-selling' ? 'selected' : ''; ?>>Best selling</option>

                        </select>
                    </div>
                    <div class="active-filters">
                        <?php foreach ($active_filters as $filter_type => $filters) : ?>
                            <?php foreach ($filters as $id => $name) : ?>
                                <a href="<?php echo remove_filter_from_url($filter_type, $id); ?>" class="filter-tag">
                                    <?php echo htmlspecialchars($name); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
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
                            echo '<a href="product-detail.php?id=' . $row["id"] . '">';
                            echo '<img src="./uploads/' . $row["product_image"] . '" alt="' . $row["album"] . '">';
                            echo '<h3>' . $row["album"] . '</h3>';

                            $description = strlen($row["description"]) > 90 ? substr($row["description"], 0, 87) . '...' : $row["description"];

                            echo '<p>' . $description . '</p>';
                            echo '<p class="hoot-records__price">$' . $row["current_price"] . '</p>';
                            echo '</a>';
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