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
$order_sql = "SELECT so.*, ci.*, u.first_name, u.last_name
              FROM shop_order so
              JOIN checkout_info ci ON so.site_user_id = ci.user_id
              JOIN site_user u ON so.site_user_id = u.id
              WHERE so.id = $order_id";

$order_result = $conn->query($order_sql);

if ($order_result && $order_result->num_rows > 0) {
    $order = $order_result->fetch_assoc();
} else {
    echo "Order not found.";
    exit();
}

// Truy vấn các mục trong đơn hàng
$items_sql = "SELECT oi.*, p.album FROM order_items oi 
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
                    <h3>Mã đơn hàng</h3>
                    <p><?php echo htmlspecialchars($order['shipment_tracking_id']); ?></p>
                </div>
                <div class="shipping-address">
                    <h3>Địa chỉ nhận hàng</h3>
                    <p><?php echo htmlspecialchars($order['recipient_name']); ?></p>
                    <p><?php echo htmlspecialchars($order['recipient_phone']); ?></p>
                    <p><?php echo htmlspecialchars($order['address']); ?></p>
                    <p><?php echo htmlspecialchars($order['ward'] . ', ' . $order['district'] . ', ' . $order['city']); ?></p>
                </div>

            </div>

            <div class="order-container payment-info">
                <h3>Thông tin thanh toán</h3>
                <div class="product-item">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="col-1">STT</th>
                                <th scope="col" class="col-7">Product</th>
                                <th scope="col" class="col-1">Price</th>
                                <th scope="col" class="col-1">Quantity</th>
                                <th scope="col" class="col-1">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 1;
                            while ($item = $items_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $stt++ . "</th>";
                                echo "<td>" . $item['album'] . "</td>";
                                echo "<td>$" . number_format($item['price_at_order'], 2) . "</td>";
                                echo "<td>" . $item['qty'] . "</td>";
                                echo "<td>$" . number_format($item['price_at_order'] * $item['qty'], 2) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            <!-- <tr>
                            <td colspan="3">Doanh thu đơn hàng</td>
                        </tr> -->
                        </tbody>
                    </table>
                </div>

                <div class="product-item total">
                    <span>Doanh Thu Đơn Hàng</span>
                    <span><?php echo number_format($order['order_total'], 0) . 'đ'; ?></span>
                </div>
            </div>
        </div>
    <?php else : ?>
        <p>Không tìm thấy thông tin đơn hàng.</p>
    <?php endif; ?>

    <?php include '../includes/footer.php' ?>
    <?php include '../includes/cart.php' ?>
</body>

</html>