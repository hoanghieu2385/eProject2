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
                                <label for="">Select Category</label>
                                <select class="form-select">
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
                                <label for="">Select Artist</label>
                                <select class="form-select">
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
                                <label for="">Album Name</label>
                                <input type="text" required name="category_name" placeholder="Enter Category Name" class="form-control">
                            </div> 
                            <div class="col-md-12">
                                <label for="">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="">Upload Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">Current Price</label>
                                <input type="number" name="parent_category_id" placeholder="If available.." class="form-control">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_category_btn">Add new Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>