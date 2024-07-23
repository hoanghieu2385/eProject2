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
$total_orders_query = "SELECT COUNT(*) AS total FROM order";
$total_orders_result = mysqli_query($con, $total_orders_query);
$total_orders_row = mysqli_fetch_assoc($total_orders_result);
$total_orders = $total_orders_row['total'];

// Calculate the total number of pages
$total_pages = ceil($total_orders / $orders_per_page);

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
                            
                                $query = "
                                SELECT p.id, pc.category_name, a.full_name as artist_name, p.album, p.version, p.edition, p.product_image, p.current_price 
                                FROM product p
                                JOIN product_category pc ON p.category_id = pc.id
                                JOIN artist a ON p.artist_id = a.id
                                ORDER BY p.id DESC
                                LIMIT $offset, $orders_per_page
                                ";
                                // keep line 63 (LIMIT) - it's used for pagination, change the other lines of query to fit use

                            ?>

                        </tbody>
                    </table>
                </div>
                <!-- Pagination controls -->
                <nav>
                        <ul class="pagination justify-content-center" style="margin-top:15px">
                            <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $i == $current_page ? 'active ' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>
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