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
                    <h4>Users</h4>
                </div>
                <div class="card-body" id="users_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Email Address</th>
                                <th class="text-center">Phone Number</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Role ID</th>
                                <th class="text-center">Update</th>
                                <th class="text-center">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "
                            SELECT u.id, u.email_address, u.phone_number, u.first_name, u.last_name, r.role_name as role
                            FROM site_user u
                            JOIN role r ON u.role_id = r.id
                            ";

                            $user = mysqli_query($con, $query);

                            if (mysqli_num_rows($user) > 0) {

                                foreach ($user as $item) {

                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['id']; ?></td>
                                        <td class="text-center"> <?= $item['email_address']; ?></td>
                                        <td class="text-center"> <?= $item['phone_number']; ?></td>
                                        <td class="text-center"> <?= $item['first_name']; ?></td>
                                        <td class="text-center"> <?= $item['last_name']; ?></td>
                                        <td class="text-center"> <?= $item['role']; ?></td>

                                        <td class="text-center">
                                            <a href="edit_site_user.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger delete_user_btn" value="<?= $item['id']; ?>">Delete</button>
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