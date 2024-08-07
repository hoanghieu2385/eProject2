<!-- order-detail.php -->
<?php
include '../includes/db_connect.php';

// Kiểm tra đăng nhập và lấy thông tin đơn hàng
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../login/login.php");
    exit();
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Truy vấn thông tin đơn hàng và địa chỉ
$order_sql = "SELECT so.*, ci.recipient_name, ci.recipient_phone, ci.address, ci.ward, ci.district, ci.city
              FROM shop_order so
              JOIN checkout_info ci ON so.checkout_info_id = ci.id
              WHERE so.id = ? AND so.site_user_id = ?";

$stmt = $conn->prepare($order_sql);
$stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    echo "Order not found.";
    exit();
}


$items_sql = "SELECT oi.*, p.album, p.product_image FROM order_items oi 
              JOIN product p ON oi.product_id = p.id 
              WHERE oi.shop_order_id = $order_id";
$items_result = $conn->query($items_sql);

if (!$items_result) {
    echo "Error fetching order items: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail #<?php echo htmlspecialchars($order_id); ?></title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- css notification -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/order-detail.css">
</head>

<body>
    <?php include '../includes/header.php' ?>
    <?php if (isset($order) && $order) : ?>
        <div class="order-status">
            <div class="card">
                <div class="row d-flex justify-content-between px-3 top">
                    <div class="d-flex">
                        <h5>ORDER <span class="text-primary font-weight-bold">#<?php echo $order['shipment_tracking_id']; ?></span></h5>
                    </div>
                    <!-- <div class="d-flex flex-column text-sm-right">
                        <p class="mb-0">Expected Arrival <span>01/12/19</span></p>
                        <p>USPS <span class="font-weight-bold">234094567242423422898</span></p>
                    </div> -->
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-12">
                        <ul id="progressbar" class="text-center">
                            <?php
                            $status = $order['order_status_id'];
                            for ($i = 1; $i <= 4; $i++) {
                                echo '<li class="' . ($i <= $status ? 'active' : '') . ' step0"></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-between top">
                    <div class="row d-flex icon-content">
                        <i class="icon fa-regular fa-calendar-check"></i>
                        <div class="d-flex flex-column">
                            <p class="font-weight-bold">Pending</p>
                        </div>
                    </div>
                    <div class="row d-flex icon-content">
                        <i class="icon fa-solid fa-box"></i>
                        <div class="d-flex flex-column">
                            <p class="font-weight-bold">In process</p>
                        </div>
                    </div>
                    <div class="row d-flex icon-content">
                        <i class="icon fa-solid fa-truck-fast"></i>
                        <div class="d-flex flex-column">
                            <p class="font-weight-bold">Order<br>En Route</p>
                        </div>
                    </div>
                    <div class="row d-flex icon-content">
                        <i class="icon fa-solid fa-house"></i>
                        <div class="d-flex flex-column">
                            <p class="font-weight-bold">Order<br>Arrived</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="order-container">
                <div class="order-id">
                    <h3>Order ID</h3>
                    <p><?php echo htmlspecialchars($order['shipment_tracking_id']); ?></p>
                </div>
                <div class="shipping-address">
                    <h3>Your Information</h3>
                    <p><b>Name: </b><?php echo htmlspecialchars($order['recipient_name']); ?></p>
                    <p><b>Phone: </b><?php echo htmlspecialchars($order['recipient_phone']); ?></p>
                    <p><b>Address: </b><?php echo htmlspecialchars($order['address'] . ', ' . $order['ward'] . ', ' . $order['district'] . ', ' . $order['city']); ?></p>
                </div>

            </div>

            <div class="order-container payment-info">
                <h3>Payment Info</h3>
                <div class="product-item">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="col-1 text-center">STT</th>
                                <th scope="col" class="col-7">Product</th>
                                <th scope="col" class="col-1 text-center">Price</th>
                                <th scope="col" class="col-1 text-center">Quantity</th>
                                <th scope="col" class="col-1 text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 1;
                            while ($item = $items_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row' class='text-center'>" . $stt++ . "</th>";
                                echo "<td>
                                    <div class='d-flex align-items-center'>
                                        <img src='../uploads/" . htmlspecialchars($item['product_image']) . "' alt='" . htmlspecialchars($item['album']) . "' class='product-image mr-3' style='object-fit: cover;'>
                                        <span>" . htmlspecialchars($item['album']) . "</span>
                                    </div>
                                </td>";
                                echo "<td class='text-center'>$" . number_format($item['price_at_order'], 2) . "</td>";
                                echo "<td class='text-center'>" . $item['qty'] . "</td>";
                                echo "<td class='text-center'>$" . number_format($item['price_at_order'] * $item['qty'], 2) . "</td>";
                                echo "</tr>";
                            }

                            ?>

                        </tbody>

                    </table>
                </div>

                <div class="product-item total">
                    <span>TOTAL</span>
                    <span>
                        <?php echo '$', number_format ($order['order_total'], 2); ?>
                        <button class="total-breakdown-btn" data-bs-toggle="modal" data-bs-target="#totalBreakdownModal">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </span>
                </div>
                <?php if ($order['order_status_id'] == 1) : ?>
                    <button id="cancelOrderBtn" class="btn btn-danger">Cancel Order</button>
                <?php endif; ?>
            </div>
        </div>
        <!-- Total Breakdown Modal -->
        <div class="modal fade" id="totalBreakdownModal" tabindex="-1" aria-labelledby="totalBreakdownModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="totalBreakdownModalLabel">Total Breakdown</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $subtotal = 0;
                        $items_result->data_seek(0); // Reset the result pointer
                        while ($item = $items_result->fetch_assoc()) {
                            $subtotal += $item['price_at_order'] * $item['qty'];
                        }
                        $shipping_cost = $order['order_total'] - $subtotal;
                        ?>
                        <p><strong>Subtotal:</strong> <?php echo '$', number_format($subtotal, 2); ?></p>
                        <p><strong>Shipping:</strong> <?php echo '$', number_format($shipping_cost, 2); ?></p>
                        <hr>
                        <p><strong>Total:</strong> <?php echo '$', number_format($order['order_total'], 2); ?></p>
                    </div>
                </div>
            </div>
        </div>

    <?php else : ?>
        <p>Cannot find order detail.</p>
    <?php endif; ?>

    <?php include '../includes/footer.php' ?>
    <?php include '../includes/cart.php' ?>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const cancelOrderBtn = document.getElementById('cancelOrderBtn');
    if (cancelOrderBtn) {
        cancelOrderBtn.addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure you want to cancel this order?',
                text: "You will not be able to undo this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel the order!',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    const orderId = <?php echo $order_id; ?>;
                    fetch('./cancel_order.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'order_id=' + orderId
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);
                        return response.text();
                    })
                    .then(text => {
                        console.log('Raw response:', text);
                        // Check if the response starts with a valid JSON character
                        if (text.trim().startsWith('{')) {
                            return JSON.parse(text);
                        } else {
                            console.error('Invalid JSON response:', text);
                            throw new Error('Invalid JSON response');
                        }
                    })
                    .then(data => {
                        console.log('Parsed data:', data);
                        if (data.success) {
                            Swal.fire(
                                'Cancelled!',
                                'Your order has been successfully canceled.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message || 'An error occurred while canceling the order.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        Swal.fire(
                            'Error!',
                            'An error occurred. Please try again later.',
                            'error'
                        );
                    });
                }
            });
        });
    }
});
</script>
</body>

</html>