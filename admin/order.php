<?php

include('includes/header.php');
include('../middleware/adminMiddleware.php');

// include('../middleware/adminMiddleware.php');
// // the header.php include was previously on top of adminMiddleware include
// include('includes/header.php');

// Set the number of orders per page
$orders_per_page = 7;

// Get the current page number from the URL, default to 1 if not set
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = (int) $_GET['page'];
} else {
    $current_page = 1;
}

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $orders_per_page;

// Get the total number of orders
$total_orders_query = "SELECT COUNT(*) AS total FROM shop_order";
$total_orders_result = mysqli_query($con, $total_orders_query);
$total_orders_row = mysqli_fetch_assoc($total_orders_result);
$total_orders = $total_orders_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_orders / $orders_per_page);

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Orders</h4>
                </div>
                <div class="card-body" id="orders_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Order ID</th>
                                <th class="text-center">User Name</th>
                                <th class="text-center">Total Bill</th>
                                <th class="text-center">Order Status</th>
                                <th class="text-center">Tracking Number</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "
                            SELECT 
                                so.id AS shop_order_id,
                                CONCAT(su.first_name, ' ', su.last_name) AS user_name,
                                so.order_total AS order_total,
                                os.status AS order_status,
                                so.shipment_tracking_id AS shipment_tracking_id
                            FROM 
                                shop_order so
                            JOIN 
                                site_user su ON so.site_user_id = su.id
                            JOIN 
                                order_status os ON so.order_status_id = os.id
                            ";

                            $orders = mysqli_query($con, $query);

                            if (mysqli_num_rows($orders) > 0) {

                                foreach ($orders as $item) {

                            ?>
                                    <tr>
                                        <td class="text-center"> <?= $item['shop_order_id']; ?></td>
                                        <td class="text-center"> <?= $item['user_name']; ?></td>
                                        <td class="text-center">$<?= $item['order_total']; ?></td>
                                        <td class="text-center"> <?= $item['order_status']; ?></td>
                                        <td class="text-center"> <?= $item['shipment_tracking_id']; ?></td>
                                        <td class="text-center">
                                            <a href="view_order_items.php?id=<?= $item['shop_order_id']; ?>" class="btn btn-sm btn-info">View</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="edit_shop_order.php?id=<?= $item['shop_order_id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                    </tr>
                            <?php

                                }
                            } else {
                                echo "No orders found.";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination controls -->
                <nav>
                    <ul class="pagination justify-content-center" style="margin-top:15px">
                        <?php if ($current_page > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?= $i == $current_page ? 'active ' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>