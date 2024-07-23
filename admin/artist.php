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
                if (isset($_SESSION['status'])) {
                    echo "<div class='alert alert-warning'>" . $_SESSION['status'] . "</div>";
                    unset($_SESSION['status']);
                }
            ?>
            <div class="card">
                <div class="card-header">
                    <h4>Add Artist</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row gy-2">
                            <div class="col-md-12">
                                <label for="" style="font-weight: bold;">Artist Name</label>
                                <input type="text" required name="artist_name" placeholder="Enter Artist Name" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0" style="font-weight: bold;">Select Country</label>
                                <select name="country_id" required class="form-select mb-2">
                                    <option selected>Select Country</option>

                                    <?php

                                    $country = getAll("country");

                                    if (mysqli_num_rows($country) > 0) {
                                        foreach ($country as $item) {

                                    ?>
                                            <option value="<?= $item['id']; ?>"><?= $item['country_name']; ?></option>
                                    <?php

                                        }
                                    } else {
                                        echo "No countries available.";
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_artist_btn">Add new Artist</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Artists</h4>
                </div>
                <div class="card-body" id="artists_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Artist</th>
                                <th class="text-center">Country</th>
                                <th class="text-center">Update</th>
                                <th class="text-center">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "
                            SELECT a.id, a.full_name, c.country_name 
                            FROM artist a
                            JOIN country c ON a.country_id = c.id
                            ";

                            $artist = mysqli_query($con, $query);

                            if (mysqli_num_rows($artist) > 0) {

                                foreach ($artist as $item) {

                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['id']; ?></td>
                                        <td class="text-center"> <?= $item['full_name']; ?></td>
                                        <td class="text-center"> <?= $item['country_name']; ?></td>
                                        <td class="text-center">
                                            <a href="edit_artist.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger delete_artist_btn" value="<?= $item['id']; ?>">Delete</button>
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