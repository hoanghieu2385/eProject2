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
                $artist = getByID("artist", $id);

                if (mysqli_num_rows($artist) > 0) {

                    $data = mysqli_fetch_array($artist);

            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Artist</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="artist_id" value="<?= $data['id'] ?>">
                                        <label for="" style="font-weight: bold;">Artist Name</label>
                                        <input type="text" value="<?= $data['full_name'] ?>" name="artist_name" placeholder="Enter Artist Name" class="form-control">
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
                                        <button type="submit" class="btn btn-primary" name="update_artist_btn" style="margin-top: 15px;">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Artist not found.";
                }
            } else {
                echo "ID missing from URL.";
            }

            ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>