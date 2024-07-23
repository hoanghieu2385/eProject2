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
            <div class="card">
                <div class="card-header">
                    <h4>Payment and Shipment Options</h4>
                </div>
                <div class="card-body" id="payment_Shipment_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Payment Option</th>
                                <th class="text-center">Shipment Option</th>
                                <th class="text-center">Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "
                            SELECT u.id, u.email_address, u.phone_number, u.first_name, u.last_name, r.role_name as role
                            FROM site_user u
                            JOIN role r ON u.role_id = r.id
                            ORDER BY u.id ASC
                            ";

                            $ps_option = mysqli_query($con, $query);

                            if (mysqli_num_rows($ps_option) > 0) {

                                foreach ($ps_option as $item) {

                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['id']; ?></td>
                                        <td class="text-center"> <?= $item['payment_option']; ?></td>
                                        <td class="text-center"> <?= $item['shipment_option']; ?></td>
                                        <td class="text-center">
                                            <a href="edit_payment_shipment.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
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