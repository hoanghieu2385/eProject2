<?php

include('includes/header.php');
include('../middleware/adminMiddleware.php');
// the header.php include was previously on top of adminMiddleware include




?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $category = getByID("product_category", $id);

                if (mysqli_num_rows($category) > 0) {

                    $data = mysqli_fetch_array($category);

            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="product_category_id" value="<?= $data['id'] ?>">
                                        <label for="">Category Name</label>
                                        <input type="text" value="<?= $data['category_name'] ?>" name="category_name" placeholder="Enter Category Name" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Parent Category ID</label>
                                        <input type="number" value="<?= $data['parent_category_id'] ?>" name="parent_category_id" placeholder="If available.." class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_category_btn">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Category not found.";
                }
            } else {
                echo "ID missing from URL.";
            }

            ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>