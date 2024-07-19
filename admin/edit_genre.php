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
                $genre = getByID("genre", $id);

                if (mysqli_num_rows($genre) > 0) {

                    $data = mysqli_fetch_array($genre);

            ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Genre</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="genre_id" value="<?= $data['id'] ?>">
                                        <label for="">Genre Name</label>
                                        <input type="text" value="<?= $data['genre_name'] ?>" name="genre_name" placeholder="Enter Genre Name" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" name="update_genre_btn" style="margin-top: 15px;">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                } else {
                    echo "Genre not found.";
                }
            } else {
                echo "ID missing from URL.";
            }

            ?>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>