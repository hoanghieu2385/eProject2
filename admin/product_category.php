<?php

include('includes/header.php');
include('../middleware/adminMiddleware.php');
// the header.php include was previously on top of adminMiddleware include

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Product Category</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row gy-2">
                            <div class="col-md-6">
                                <label for="" style="font-weight: bold;">Category Name</label>
                                <input type="text" required name="category_name" placeholder="Enter Category Name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="" style="font-weight: bold;">Parent Category ID</label>
                                <input type="text" name="parent_category_id" placeholder="If available.." class="form-control">
                            </div>

                            <!-- Potential option for Select Dropdown for "Parent Category ID". Taken from product.php. Continue -->
                            <!-- <div class="col-md-6">

                                <label for="">Select Parent Category</label>
                                <select class="form-select">
                                <option selected>Select Parent Category</option>

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
                            </div> -->
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_category_btn">Add new Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Product Categories</h4>
                </div>
                <div class="card-body" id="categories_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Category Name</th>
                                <!-- <th>Parent Category</th> -->
                                <th class="text-center">Update</th>
                                <th class="text-center">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $category = getAll("product_category");

                            if (mysqli_num_rows($category) > 0) {

                                foreach ($category as $item) {

                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['id']; ?></td>
                                        <td class="text-center"> <?= $item['category_name']; ?></td>

                                        <!-- Change the Parent Category ID from being a number to being the Category Name -->
                                        <!-- <td> ?= $item['parent_category_id']; ?></td> -->
                                        
                                        <td class="text-center">
                                            <a href="edit_product_category.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                        <td class="text-center">
                                            <!-- <form action="code.php" method="POST">
                                                <input type="hidden" name="category_id" value="<?= $item['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" name="delete_category_btn">Delete</button>
                                            </form> -->
                                            <button type="button" class="btn btn-sm btn-danger delete_category_btn" value="<?= $item['id']; ?>">Delete</button>
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