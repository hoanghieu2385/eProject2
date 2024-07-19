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
                $country = getByID("country", $id);

                if (mysqli_num_rows($country) > 0) {

                    $data = mysqli_fetch_array($country);

            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Country</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="country_id" value="<?= $data['id'] ?>">
                                        <label for="">Country Name</label>
                                        <input type="text" value="<?= $data['country_name'] ?>" name="country_name" placeholder="Enter Country Name" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_country_btn" style="margin-top: 15px;">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Country not found.";
                }
            } else {
                echo "ID missing from URL.";
            }

            ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>