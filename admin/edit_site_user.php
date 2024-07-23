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
                $user = getByID("site_user", $id);

                if (mysqli_num_rows($user) > 0) {

                    $data = mysqli_fetch_array($user);

            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit User</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="site_user_id" value="<?= $data['id'] ?>">
                                        <label for="" style="font-weight: bold;">Email Address</label>
                                        <input type="email" value="<?= $data['email_address'] ?>" name="email_address" placeholder="Enter Email" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" style="font-weight: bold;">Phone Number</label>
                                        <input type="text" value="<?= $data['phone_number'] ?>" name="phone_number" placeholder="Enter Phone Number" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" style="font-weight: bold;">First Name</label>
                                        <input type="text" value="<?= $data['first_name'] ?>" name="first_name" placeholder="Enter First Name" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" style="font-weight: bold;">Last Name</label>
                                        <input type="text" value="<?= $data['last_name'] ?>" name="last_name" placeholder="Enter Last Name" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" style="font-weight: bold;">Role ID</label>
                                        <input type="number" value="<?= $data['role_id'] ?>" name="role_id" placeholder="Enter Role ID" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_user_btn" style="margin-top: 15px;">Update</button>
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