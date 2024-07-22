<?php

// include('includes/header.php');
// include('../middleware/adminMiddleware.php');

include('../middleware/adminMiddleware.php');
// the header.php include was previously on top of adminMiddleware include
include('includes/header.php');

?>

<div class="py-5">
    <div class="container">
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tracking Number</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>View</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php 

                                $orders = getAllOrders(); 
                                // We have created this function in myfunctions.php. Check if there is a need to anything else. Moving back to payment_shipment because it's necessary for shop_order.
                            
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>