<?php

include('includes/header.php');
include('../middleware/adminMiddleware.php');

// include('../middleware/adminMiddleware.php');
// // the header.php include was previously on top of adminMiddleware include
// include('includes/header.php');

// Set the number of products per page
$products_per_page = 7;

// Get the current page number from the URL, default to 1 if not set
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = (int) $_GET['page'];
} else {
    $current_page = 1;
}

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $products_per_page;

// Initialize search keyword
$search_keyword = "";
if (isset($_GET['search'])) {
    $search_keyword = mysqli_real_escape_string($con, $_GET['search']);
}

// Get the total number of products
$total_products_query = "SELECT COUNT(*) AS total FROM product 
    JOIN product_category pc ON product.category_id = pc.id 
    JOIN artist a ON product.artist_id = a.id 
    WHERE pc.category_name LIKE '%$search_keyword%' 
    OR a.full_name LIKE '%$search_keyword%' 
    OR product.album LIKE '%$search_keyword%' 
    OR product.version LIKE '%$search_keyword%' 
    OR product.edition LIKE '%$search_keyword%'";
$total_products_result = mysqli_query($con, $total_products_query);
$total_products_row = mysqli_fetch_assoc($total_products_result);
$total_products = $total_products_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_products / $products_per_page);

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Product</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row gy-2">
                            <div class="col-md-6">
                                <label class="mb-0" style="font-weight: bold;">Select Category</label>
                                <select name="category_id" required class="form-select mb-2">
                                    <option selected>Select Product Category</option>

                                    <?php

                                    $product_category = getAll("product_category");

                                    if (mysqli_num_rows($product_category) > 0) {
                                        foreach ($product_category as $item) {

                                    ?>
                                            <option value="<?= $item['id']; ?>"><?= $item['category_name']; ?></option>
                                    <?php

                                        }
                                    } else {
                                        echo "No category available.";
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0" style="font-weight: bold;">Select Artist</label>
                                <select name="artist_id" required class="form-select mb-2">
                                    <option selected>Select Artist</option>

                                    <?php

                                    $artist = getAll("artist");

                                    if (mysqli_num_rows($artist) > 0) {
                                        foreach ($artist as $item) {

                                    ?>
                                            <option value="<?= $item['id']; ?>"><?= $item['full_name']; ?></option>
                                    <?php

                                        }
                                    } else {
                                        echo "No artists available.";
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Album Name</label>
                                <input type="text" required name="album" placeholder="Enter Album Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Version</label>
                                <input type="text" name="version" placeholder="Enter Version Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Edition</label>
                                <input type="text" name="edition" placeholder="Enter Edition Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0" style="font-weight: bold;">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0" style="font-weight: bold;">Upload Image</label>
                                <input type="file" required name="image" class="form-control mb-2">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0" style="font-weight: bold;">Current Price</label>
                                <input type="number" required name="current_price" placeholder="Enter current selling price" class="form-control mb-2" min="0" value="0" step=".01">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_product_btn">Add New Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>All Products</h4>
                    <form class="d-flex" action="product.php" method="GET">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search.." value="<?= $search_keyword ?>" aria-label="Search" style="max-height: 40px; max-width: 30%">
                        <button class="btn btn-outline-success text-center" type="submit">Search</button>
                    </form>
                </div>
                <div class="card-body" id="products_table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Artist</th>
                                    <th class="text-center">Album</th>
                                    <th class="text-center">Version</th>
                                    <th class="text-center">Edition</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Current Price</th>
                                    <th class="text-center">Update</th>
                                    <th class="text-center">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $query = "
                                SELECT p.id, pc.category_name, a.full_name as artist_name, p.album, p.version, p.edition, p.product_image, p.current_price 
                                FROM product p
                                JOIN product_category pc ON p.category_id = pc.id
                                JOIN artist a ON p.artist_id = a.id
                                WHERE pc.category_name LIKE '%$search_keyword%' 
                                OR a.full_name LIKE '%$search_keyword%' 
                                OR p.album LIKE '%$search_keyword%' 
                                OR p.version LIKE '%$search_keyword%' 
                                OR p.edition LIKE '%$search_keyword%'
                                ORDER BY p.id DESC
                                LIMIT $offset, $products_per_page
                                ";

                                $product = mysqli_query($con, $query);

                                if (mysqli_num_rows($product) > 0) {

                                    foreach ($product as $item) {

                                ?>
                                        <tr>
                                            <td class="text-center"> <?= $item['id']; ?></td>
                                            <td class="text-center"> <?= $item['category_name']; ?></td>
                                            <td class="text-center"> <?= $item['artist_name']; ?></td>
                                            <td class="text-center"> <?= $item['album']; ?></td>
                                            <td class="text-center"> <?= $item['version']; ?></td>
                                            <td class="text-center"> <?= $item['edition']; ?></td>
                                            <td class="text-center">
                                                <img src="../uploads/<?= $item['product_image']; ?>" width="70px" height="70px" alt="<?= $item['album']; ?>">
                                            </td>
                                            <td class="text-center">$ <?= $item['current_price']; ?></td>
                                            <td class="text-center">
                                                <a href="edit_product.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger delete_product_btn" value="<?= $item['id']; ?>">Delete</button>
                                            </td>
                                        </tr>
                                <?php

                                    }
                                } else {
                                    echo "<tr><td colspan='10' class='text-center'>No records found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination controls -->
                    <nav>
                        <ul class="pagination justify-content-center" style="margin-top:15px">
                            <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $i == $current_page ? 'active ' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>