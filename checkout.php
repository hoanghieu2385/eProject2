<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connect failed. " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$user_query = "SELECT * FROM site_user WHERE id = $user_id";
$user_result = $conn->query($user_query);
$user_data = $user_result->fetch_assoc();

$address_query = "SELECT * FROM address WHERE id = $user_id";
$address_result = $conn->query($address_query);
$address_data = $address_result->fetch_assoc();

$conn->close();

// Xử lý dữ liệu giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartData'])) {
    $cartItems = json_decode($_POST['cartData'], true);
} else {
    // Nếu không có dữ liệu giỏ hàng, chuyển hướng người dùng về trang chủ
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store - Checkout</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="./css/checkout.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="./js/edit_address.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form-control,
        .form-select {
            font-size: 0.9rem;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .payment-info {
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            font-size: 0.9rem;
            padding: 1rem;
        }

        .table {
            font-size: 0.9rem;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 0.75rem;
            vertical-align: top;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .form-check {
            margin-bottom: 0.5rem;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .btn-order {
            background-color: #212529;
            border: none;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            text-transform: uppercase;
        }

        h2 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <?php include './includes/header.php' ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-5">
                <h2>SHIPPING INFO</h2>
                <div id="userInfo">
                    <p><strong>NAME:</strong> <span id="fullName"><?php echo $user_data['first_name'] . ' ' . $user_data['last_name']; ?></span></p>
                    <p><strong>PHONE NUMBER:</strong> <span id="phone"><?php echo $user_data['phone_number']; ?></span></p>
                    <p><strong>EMAIL:</strong> <span id="email"><?php echo $user_data['email_address']; ?></span></p>
                    <p><strong>ADDRESS:</strong> <span id="address"><?php echo $address_data['address']; ?></span></p>
                    <p><strong>WARD:</strong> <span id="ward"><?php echo $address_data['ward']; ?></span></p>
                    <p><strong>DISTRICT:</strong> <span id="district"><?php echo $address_data['district']; ?></span></p>
                    <p><strong>CITY:</strong> <span id="city"><?php echo $address_data['city']; ?></span></p>
                </div>
                <div id="editForm" style="display: none;">
                    <input type="text" id="editAddress" placeholder="Address">
                    <input type="text" id="editWard" placeholder="Ward">
                    <input type="text" id="editDistrict" placeholder="District">
                    <input type="text" id="editCity" placeholder="City">
                    <button id="saveBtn">Save</button>
                    <button id="cancelBtn">Cancel</button>
                </div>
                <button id="editBtn">EDIT</button>
            </div>
            <div class="col-md-7">
                <h2>YOUR ORDER</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th class="text-end">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalPrice = 0;
                            foreach ($cartItems as $item) {
                                // Chuyển đổi giá và số lượng thành số
                                $price = floatval(str_replace(['$', ','], '', $item['price']));
                                $quantity = intval($item['quantity']);

                                $itemTotal = $price * $quantity;
                                $totalPrice += $itemTotal;
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['title']); ?> <b>× <?php echo $quantity; ?></b></td>
                                    <td class="text-end"><?php echo number_format($itemTotal, 0, ',', '.'); ?> ₫</td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>PROVISIONAL INVOICE</td>
                                <td class="text-end"><?php echo number_format($totalPrice, 0, ',', '.'); ?> ₫</td>
                            </tr>
                            <tr>
                                <td>SHIPPING</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="transfer" value="transfer" checked>
                                        <label class="form-check-label" for="transfer">
                                            THANH TOÁN CHUYỂN KHOẢN: 50,000 ₫
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod">
                                        <label class="form-check-label" for="cod">
                                            THANH TOÁN KHI NHẬN HÀNG (COD): 50,000 ₫
                                        </label>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL</strong></td>
                                <td class="text-end"><strong id="totalPrice"><?php echo number_format($totalPrice, 0, ',', '.'); ?> ₫</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" id="orderButton" class="btn btn-dark btn-order w-100 mt-3">PLACE ORDER</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include './includes/footer.php' ?>

    <script>
        $(document).ready(function() {
            $('input[name="paymentMethod"]').change(function() {
                let shippingCost = 0;
                if (this.value === 'transfer') {
                    shippingCost = 50000;
                } else if (this.value === 'cod') {
                    shippingCost = 50000;
                }

                let subtotal = <?php echo $totalPrice; ?>;
                let total = subtotal + shippingCost;

                $('#totalPrice').text(total.toLocaleString('vi-VN') + ' ₫');
            });

            $('#orderButton').click(function() {
                // Xử lý đặt hàng ở đây
                alert('Đơn hàng của bạn đã được đặt thành công!');
            });
        });
    </script>
</body>

</html>