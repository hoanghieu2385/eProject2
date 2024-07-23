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

// Get the total number of products
$total_products_query = "SELECT COUNT(*) AS total FROM product_inventory";
$total_products_result = mysqli_query($con, $total_products_query);
$total_products_row = mysqli_fetch_assoc($total_products_result);
$total_products = $total_products_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_products / $products_per_page);

// Search query
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $search_query = " AND (pc.category_name LIKE '%$search%' OR a.full_name LIKE '%$search%' OR CONCAT(p.album, ' ', p.version, ' ', p.edition) LIKE '%$search%')";
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Product Supply</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row gy-2">
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Category</label>
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
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Artist</label>
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
                                <select name="album" required class="form-select mb-2">
                                    <option selected>Select Album</option>

                                    <?php

                                    $album_query = "SELECT album FROM product"; // ----------------------- we're here, find a way to attach the selected artist_id above to the query

                                    $album = mysqli_query($con, $album_query);

                                    if (mysqli_num_rows($album) > 0) {
                                        foreach ($album as $item) {

                                    ?>
                                            <option><?= $item['album']; ?></option>
                                    <?php

                                        }
                                    } else {
                                        echo "No albums available.";
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Version Name</label>
                                <select name="version" required class="form-select mb-2">
                                    <option selected>Select Version</option>

                                    <?php

                                    $version_query = "SELECT DISTINCT version FROM product WHERE NOT version='' ";

                                    $version = mysqli_query($con, $version_query);

                                    if (mysqli_num_rows($version) > 0) {
                                        foreach ($version as $item) {

                                    ?>
                                            <option><?= $item['version']; ?></option>
                                    <?php

                                        }
                                    } else {
                                        echo "No versions available.";
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Edition Name</label>
                                <select name="edition" required class="form-select mb-2">
                                    <option selected>Select Edition</option>

                                    <?php

                                    $edition_query = "SELECT DISTINCT edition FROM product WHERE edition IS NOT NULL";

                                    $edition = mysqli_query($con, $edition_query);

                                    if (mysqli_num_rows($edition) > 0) {
                                        foreach ($edition as $item) {

                                    ?>
                                            <option><?= $item['edition']; ?></option>
                                    <?php

                                        }
                                    } else {
                                        echo "No editions available.";
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Supplier</label>
                                <select name="supplier_id" required class="form-select mb-2">
                                    <option selected>Select Supplier</option>

                                    <?php

                                    $supplier = getAll("supplier");

                                    if (mysqli_num_rows($supplier) > 0) {
                                        foreach ($supplier as $item) {

                                    ?>
                                            <option value="<?= $item['id']; ?>"><?= $item['supplier_name']; ?></option>
                                    <?php

                                        }
                                    } else {
                                        echo "No supplier available.";
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Supply Price</label>
                                <input type="number" required name="supply_price" placeholder="Enter supply price" class="form-control mb-2" min="0" value="0" step=".01">
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0" style="font-weight: bold;">Product Quantity</label>
                                <input type="number" required name="quantity" placeholder="Enter Quantity" class="form-control mb-2" min="0" value="0">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="supply_product_btn">Add Product Supply</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Inventory</h4>
                    <form method="GET" class="d-flex" action="inventory.php">
                        <input type="text" class="form-control me-2" name="search" placeholder="Search.." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" style="max-height: 40px; max-width: 30%">
                        <button class="btn btn-outline-success text-center" type="submit">Search</button>
                    </form>
                </div>
                <div class="card-body" id="inventory_table">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Artist Name</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $query = "
                                SELECT p.id, pc.category_name, a.full_name as artist_name, CONCAT(p.album, ' ', p.version) as product_name, p.product_image, SUM(pi.qty) as quantity 
                                FROM product p
                                JOIN product_category pc ON p.category_id = pc.id
                                JOIN artist a ON p.artist_id = a.id
                                JOIN product_inventory pi ON p.id = pi.product_id
                                WHERE 1 $search_query
                                GROUP BY p.id, pc.category_name, a.full_name, p.album, p.version, p.edition, p.product_image
                                ORDER BY p.id DESC
                                LIMIT $offset, $products_per_page
                                ";

                                $inventory = mysqli_query($con, $query);

                                if (mysqli_num_rows($inventory) > 0) {

                                    foreach ($inventory as $item) {

                                ?>
                                        <tr>
                                            <td class="text-center"> <?= $item['id']; ?></td>
                                            <td class="text-center"> <?= $item['category_name']; ?></td>
                                            <td class="text-center"> <?= $item['artist_name']; ?></td>
                                            <td class="text-center"> <?= $item['product_name']; ?></td>
                                            <td class="text-center">
                                                <img src="../uploads/<?= $item['product_image']; ?>" width="70px" height="70px" alt="">
                                            </td>
                                            <td class="text-center"><?= $item['quantity']; ?></td>
                                            <td class="text-center">
                                                <a href="edit_product.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                            </td>
                                        </tr>
                                <?php

                                    }
                                } else {
                                    echo "No records found.";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination controls -->
                    <nav>
                        <ul class="pagination justify-content-center" style="margin-top:15px">
                            <?php if ($current_page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <li class="page-item <?= $i == $current_page ? 'active ' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages) : ?>
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