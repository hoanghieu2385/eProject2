<?php

include('../middleware/adminMiddleware.php');
// the header.php include was previously on top of adminMiddleware include
include('includes/header.php');

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Genre</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row gy-2">
                            <div class="col-md-6">
                                <label for="" style="font-weight: bold;">Genre Name</label>
                                <input type="text" required name="genre_name" placeholder="Enter Genre Name" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="add_genre_btn">Add new Genre</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Genres</h4>
                </div>
                <div class="card-body" id="genres_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Genre</th>
                                <th class="text-center">Update</th>
                                <th class="text-center">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $genre = getAll("genre");

                            if (mysqli_num_rows($genre) > 0) {

                                foreach ($genre as $item) {

                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['id']; ?></td>
                                        <td class="text-center"> <?= $item['genre_name']; ?></td>
                                        <td class="text-center">
                                            <a href="edit_genre.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger delete_genre_btn" value="<?= $item['id']; ?>">Delete</button>
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