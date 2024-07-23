<?php


include('includes/header.php');
include('../middleware/adminMiddleware.php');

// include('../middleware/adminMiddleware.php');
// // the header.php include was previously on top of adminMiddleware include
// include('includes/header.php');


?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php

            if (isset($_GET['id'])) {

                $id = $_GET['id'];

                $order = getByID("shop_order", $id);

                if (mysqli_num_rows($order) > 0) {

                    $data = mysqli_fetch_array($order);

            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Order</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row gy-2">
                                    <input type="hidden" name="shop_order_id" value="<?= $data['id']; ?>">
                                    <div class="col-md-4">
                                        <label class="mb-0" style="font-weight: bold;">User Name</label>
                                        <input readonly type="text" required name="site_user_id" value="<?= $data['site_user_id']; ?>" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="mb-0" style="font-weight: bold;">Total Order Bill</label>
                                        <input readonly type="text" required name="order_total" value="<?= $data['order_total']; ?>"class="form-control mb-2">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="hidden" name="order_status_id" value="<?= $data['order_status_id'] ?>">
                                        <label class="mb-0" style="font-weight: bold;">Select Order Status</label>
                                        <select name="order_status_id" required class="form-select mb-2">
                                            <option selected>Select Status</option>

                                           <?php

                                            $status = getAll("order_status");

                                            if (mysqli_num_rows($status) > 0) {
                                                foreach ($status as $item) {

                                            ?>
                                                    <option value="<?= $item['id']; ?>" <?= $data['order_status_id'] == $item['id'] ? 'selected' : '' ?>><?= $item['status']; ?></option>
                                            <?php

                                                }
                                            } else {
                                                echo "No records available.";
                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="mb-0" style="font-weight: bold;">Tracking Number</label>
                                        <input type="text" required name="shipment_tracking_id" value="<?= $data['shipment_tracking_id']; ?>" placeholder="Please enter Tracking Number" class="form-control mb-2">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_order_btn">Update Product</button>
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