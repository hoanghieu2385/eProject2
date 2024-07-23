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
                $payment_shipment = getByID("payment_shipment", $id);

                if (mysqli_num_rows($payment_shipment) > 0) {

                    $data = mysqli_fetch_array($payment_shipment);

            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Payment and Shipment Options</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="payment_shipment_id" value="<?= $data['id'] ?>">
                                        <label class="mb-0" style="font-weight: bold;">Payment Method</label>
                                        <select name="payment_option_id" required class="form-select mb-2">
                                            <option selected>Select Payment Method</option>

                                            <?php

                                            $payment_option = getAll("payment_option");

                                            if (mysqli_num_rows($payment_option) > 0) {
                                                foreach ($payment_option as $item) {

                                            ?>
                                                    <option value="<?= $item['id']; ?>" <?= $data['payment_option_id'] == $item['id'] ? 'selected' : '' ?>><?= $item['payment_method']; ?></option>
                                            <?php

                                                }
                                            } else {
                                                echo "No payment option available.";
                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="shipment_option_id" value="<?= $data['shipment_option_id'] ?>">
                                        <label class="mb-0" style="font-weight: bold;">Shipment Method</label>
                                        <select name="shipment_option_id" required class="form-select mb-2">
                                            <option selected>Select Shipment Method</option>

                                            <?php

                                            $shipment_option = getAll("shipment_option");

                                            if (mysqli_num_rows($shipment_option) > 0) {
                                                foreach ($shipment_option as $item) {

                                            ?>
                                                    <option value="<?= $item['id']; ?>" <?= $data['shipment_option_id'] == $item['id'] ? 'selected' : '' ?>><?= $item['shipment_method']; ?></option>
                                            <?php

                                                }
                                            } else {
                                                echo "No shipment method available.";
                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="mb-0" style="font-weight: bold;">Applicable Fees ($)</label>
                                        <input type="number" name="fees" value="<?= $data['fees']; ?>" placeholder="Enter Applicable Fees" class="form-control mb-2" step=".01">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_ps_btn">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                } else {
                    echo "User not found.";
                }
            } else {
                echo "ID missing from URL.";
            }

            ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>