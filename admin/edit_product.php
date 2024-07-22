<?php


// include('includes/header.php');
// include('../middleware/adminMiddleware.php');

include('../middleware/adminMiddleware.php');
// the header.php include was previously on top of adminMiddleware include
include('includes/header.php');


?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php

            if (isset($_GET['id'])) {

                $id = $_GET['id'];

                $product = getByID("product", $id);

                if (mysqli_num_rows($product) > 0) {

                    $data = mysqli_fetch_array($product);

            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row gy-2">
                                    <div class="col-md-6">
                                        <label class="mb-0" style="font-weight: bold;">Select Category</label>
                                        <select name="category_id" class="form-select mb-2">
                                            <option selected>Select Product Category</option>

                                            <?php

                                            $product_category = getAll("product_category");

                                            if (mysqli_num_rows($product_category) > 0) {
                                                foreach ($product_category as $item) {

                                            ?>
                                                    <option value="<?= $item['id']; ?>" <?= $data['category_id'] == $item['id'] ? 'selected' : '' ?>><?= $item['category_name']; ?></option>
                                            <?php

                                                }
                                            } else {
                                                echo "No category available.";
                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                                    <div class="col-md-6">
                                        <label class="mb-0" style="font-weight: bold;">Select Artist</label>
                                        <select name="artist_id" class="form-select mb-2">
                                            <option selected>Select Artist</option>

                                            <?php

                                            $artist = getAll("artist");

                                            if (mysqli_num_rows($artist) > 0) {
                                                foreach ($artist as $item) {

                                            ?>
                                                    <option value="<?= $item['id']; ?>" <?= $data['artist_id'] == $item['id'] ? 'selected' : '' ?>><?= $item['full_name']; ?></option>
                                            <?php

                                                }
                                            } else {
                                                echo "No artists available.";
                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="mb-0" style="font-weight: bold;">Album Name</label>
                                        <input type="text" required name="album" value="<?= $data['album']; ?>" placeholder="Enter Album Name" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="mb-0" style="font-weight: bold;">Description</label>
                                        <textarea rows="3" name="description" placeholder="Enter Description" class="form-control mb-2"><?= $data['description']; ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-0" style="font-weight: bold;">Upload Image</label>
                                        <input type="hidden" name="old_image" value="<?= $data['product_image']; ?>">
                                        <input type="file" name="image" class="form-control mb-2">
                                        <label class="mb-0" style="font-weight: bold;">Current Image</label>
                                        <img src="../uploads/<?= $data['product_image']; ?>" alt="Product Image" height="70px" width="70px">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="mb-0" style="font-weight: bold;">Current Price</label>
                                        <input type="number" name="current_price" value="<?= $data['current_price']; ?>" placeholder="Enter current selling price" class="form-control mb-2" step=".01">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_product_btn">Update Product</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

            <?php
                } else {
                    echo "Product not found for given ID.";
                }
            } else {
                echo "ID missing from URL.";
            }

            ?>


        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>