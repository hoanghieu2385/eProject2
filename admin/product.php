<?php

include('includes/header.php');
include('../middleware/adminMiddleware.php');


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
                                <label class="mb-0">Select Category</label>
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
                                <label class="mb-0">Select Artist</label>
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
                            <div class="col-md-12">
                                <label class="mb-0">Album Name</label>
                                <input type="text" required name="album" placeholder="Enter Album Name" class="form-control mb-2">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description" class="form-control mb-2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" required name="image" class="form-control mb-2">
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Current Price</label>
                                <input type="number" readonly name="current_price" placeholder="Enter current selling price" class="form-control mb-2" min="0" value="0" step=".01">
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
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Artist</th>
                                <th>Album</th>
                                <th>Product Image</th>
                                <th>Current Price</th>
                                <th>Update</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $product = getAll("product");

                            if (mysqli_num_rows($product) > 0) {

                                foreach ($product as $item) {

                            ?>
                                    <tr>
                                        <td> <?= $item['id']; ?></td>
                                        <td> <?= $item['category_id']; ?></td>
                                        <td> <?= $item['artist_id']; ?></td>
                                        <td> <?= $item['album']; ?></td>
                                        <td>
                                            <img src="../uploads/<?= $item['product_image']; ?>" width="70px" height="70px" alt="<?= $item['album']; ?>">
                                        </td>
                                        <td> <?= $item['current_price']; ?></td>


                                        <td>
                                            <a href="edit_product.php?id=<?= $item['id']; ?>" class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <form action="code.php" method="POST">
                                                <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                                                <button type="submit" class="btn btn-danger" name="delete_category_btn">Delete</button>
                                            </form>
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
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>