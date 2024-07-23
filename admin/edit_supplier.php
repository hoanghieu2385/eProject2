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
                $supplier = getByID("supplier", $id);

                if (mysqli_num_rows($supplier) > 0) {

                    $data = mysqli_fetch_array($supplier);

            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Supplier</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="supplier_id" value="<?= $data['id'] ?>">
                                        <label for="" style="font-weight: bold;">Supplier Name</label>
                                        <input type="text" value="<?= $data['supplier_name'] ?>" name="supplier_name" placeholder="Enter Supplier Name" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" style="font-weight: bold;">Contact Information</label>
                                        <input type="text" value="<?= $data['contact_information'] ?>" name="contact_information" placeholder="If available.." class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" style="font-weight: bold;">Email</label>
                                        <input type="email" value="<?= $data['email_address'] ?>" name="email_address" placeholder="If available.." class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" name="country_id" value="<?= $data['country_id'] ?>">
                                        <label class="mb-0" style="font-weight: bold;">Select Country</label>
                                        <select name="country_id" required class="form-select mb-2">
                                            <option selected>Select Country</option>

                                            <?php

                                            $country = getAll("country");

                                            if (mysqli_num_rows($country) > 0) {
                                                foreach ($country as $item) {

                                            ?>
                                                    <option value="<?= $item['id']; ?>" <?= $data['country_id'] == $item['id'] ? 'selected' : '' ?>><?= $item['country_name']; ?></option>
                                            <?php

                                                }
                                            } else {
                                                echo "No country available.";
                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_supplier_btn" style="margin-top: 15px;">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Supplier not found.";
                }
            } else {
                echo "ID missing from URL.";
            }

            ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>