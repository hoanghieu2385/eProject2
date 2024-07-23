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
                    <h4>Add Supplier</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row gy-2">
                            <div class="col-md-12">
                                <label for="" style="font-weight: bold;">Supplier Name</label>
                                <input type="text" required name="supplier_name" placeholder="Enter Supplier Name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="" style="font-weight: bold;">Contact Information</label>
                                <input type="text" required name="contact_information" placeholder="Enter Contact Information or Point of Contact" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="" style="font-weight: bold;">Email</label>
                                <input type="email" name="email_address" placeholder="Enter Email if available.." class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0" style="font-weight: bold;">Select Country of Origin</label>
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
                                <button type="submit" class="btn btn-primary" name="add_supplier_btn">Add new Supplier</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Suppliers</h4>
                </div>
                <div class="card-body" id="suppliers_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Supplier</th>
                                <th class="text-center">Contact</th>
                                <th class="text-center">Country</th>
                                <th class="text-center">Orders</th>
                                <th class="text-center">Update</th>
                                <th class="text-center">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "
                            SELECT s.id, s.supplier_name, s.contact_information, c.country_name 
                            FROM supplier s
                            JOIN country c ON s.country_id = c.id
                            ";

                            $supplier = mysqli_query($con, $query);

                            if (mysqli_num_rows($supplier) > 0) {

                                foreach ($supplier as $item) {

                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['id']; ?></td>
                                        <td class="text-center"> <?= $item['supplier_name']; ?></td>
                                        <td class="text-center"> <?= $item['contact_information']; ?></td>
                                        <td class="text-center"> <?= $item['country_name']; ?></td>
                                        <td class="text-center">
                                            <a href="view_orders.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-info">View is Missing</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="edit_supplier.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger delete_supplier_btn" value="<?= $item['id']; ?>">Delete</button>
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