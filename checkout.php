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

if (isset($_POST['dark_mode'])) {
    $_SESSION['dark_mode'] = $_POST['dark_mode'];
}

$dark_mode = isset($_SESSION['dark_mode']) ? $_SESSION['dark_mode'] : false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store - Thanh Toán</title>
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
                <h2>CHI TIẾT THANH TOÁN</h2>
                <div id="userInfo">
                    <p><strong>Họ và tên:</strong> <span id="fullName"><?php echo $user_data['first_name'] . ' ' . $user_data['last_name']; ?></span></p>
                    <p><strong>Số điện thoại:</strong> <span id="phone"><?php echo $user_data['phone_number']; ?></span></p>
                    <p><strong>Địa chỉ email:</strong> <span id="email"><?php echo $user_data['email_address']; ?></span></p>
                    <p><strong>Địa chỉ:</strong> <span id="address"><?php echo $address_data['address']; ?></span></p>
                    <p><strong>Xã/Phường:</strong> <span id="ward"><?php echo $address_data['ward']; ?></span></p>
                    <p><strong>Quận/Huyện:</strong> <span id="district"><?php echo $address_data['district']; ?></span></p>
                    <p><strong>Tỉnh/Thành phố:</strong> <span id="city"><?php echo $address_data['city']; ?></span></p>
                </div>
                <div id="editForm" style="display: none;">
                    <input type="text" id="editAddress" placeholder="Địa chỉ">
                    <input type="text" id="editWard" placeholder="Xã/Phường">
                    <input type="text" id="editDistrict" placeholder="Quận/Huyện">
                    <input type="text" id="editCity" placeholder="Tỉnh/Thành phố">
                    <button id="saveBtn">Lưu</button>
                    <button id="cancelBtn">Hủy</button>
                </div>
                <button id="editBtn">Chỉnh sửa địa chỉ</button>
            </div>
            <div class="col-md-7">
                <h2>ĐƠN HÀNG CỦA BẠN</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SẢN PHẨM</th>
                                <th class="text-end">TẠM TÍNH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>21 Savage - i am > i was (PA) (2 LP) (150g Vinyl/ Includes Download Insert) × 1</td>
                                <td class="text-end">1,030,000 ₫</td>
                            </tr>
                            <tr>
                                <td>TẠM TÍNH</td>
                                <td class="text-end">1,030,000 ₫</td>
                            </tr>
                            <tr>
                                <td>GIAO HÀNG</td>
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
                                            THANH TOÁN KHI NHẬN HÀNG (COD): 65,000 ₫
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="pickup" value="pickup">
                                        <label class="form-check-label" for="pickup">
                                            NHẬN TẠI ....(Thanh toán trước & đến lấy)
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TỔNG</strong></td>
                                <td class="text-end"><strong id="totalPrice">1,080,000 ₫</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" id="orderButton" class="btn btn-dark btn-order w-100 mt-3">ĐẶT HÀNG</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php include './includes/footer.php' ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');

            const orderButton = document.getElementById('orderButton');
            const orderForm = document.getElementById('orderForm');
            const totalPriceElement = document.getElementById('totalPrice');

            if (orderButton && orderForm) {
                console.log('Order button and form found');
                orderButton.addEventListener('click', handleOrderSubmission);
            } else {
                console.error('Order button or form not found');
            }

            function handleOrderSubmission(event) {
                event.preventDefault();
                console.log('Order submission handled');

                const formData = new FormData(orderForm);
                const orderInfo = Object.fromEntries(formData);

                const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
                orderInfo.paymentMethod = paymentMethod ? paymentMethod.value : '';

                console.log('Order info:', orderInfo);
                alert('Đơn hàng của bạn đã được ghi nhận!');
            }

            const paymentMethods = document.querySelectorAll('input[name="paymentMethod"]');
            paymentMethods.forEach(method => {
                method.addEventListener('change', updateTotalPrice);
            });

            function updateTotalPrice() {
                if (!totalPriceElement) {
                    console.error('Total price element not found');
                    return;
                }

                const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked');
                const basePrice = 1030000; // Gia goc
                let shippingFee = 0;

                if (selectedMethod) {
                    if (selectedMethod.value === 'transfer') {
                        shippingFee = 50000;
                    } else if (selectedMethod.value === 'cod') {
                        shippingFee = 65000;
                    }
                }

                const totalPrice = basePrice + shippingFee;
                totalPriceElement.textContent = totalPrice.toLocaleString('vi-VN') + ' ₫';
            }

            updateTotalPrice();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            let originalAddress = $('#address').text();
            let originalWard = $('#ward').text();
            let originalDistrict = $('#district').text();
            let originalCity = $('#city').text();


            $('#editBtn').click(function() {
                $('#userInfo').hide();
                $('#editForm').show();
                $('#editAddress').val($('#address').text());
                $('#editWard').val($('#ward').text());
                $('#editDistrict').val($('#district').text());
                $('#editCity').val($('#city').text());
            });


            $('#cancelBtn').click(function() {
                $('#editForm').hide();
                $('#userInfo').show();
                $('#address').text(originalAddress);
                $('#ward').text(originalWard);
                $('#district').text(originalDistrict);
                $('#city').text(originalCity);
            });

            $('#saveBtn').click(function() {
                let newAddress = $('#editAddress').val();
                let newWard = $('#editWard').val();
                let newDistrict = $('#editDistrict').val();
                let newCity = $('#editCity').val();

                console.log('Sending AJAX request...');
                $.ajax({
                    url: 'update_address.php',
                    method: 'POST',
                    data: {
                        address: newAddress,
                        ward: newWard,
                        district: newDistrict,
                        city: newCity
                    },
                    success: function(response) {
                        console.log('AJAX response:', response);
                        if(response === 'success') {
                            $('#address').text(newAddress);
                            $('#ward').text(newWard);
                            $('#district').text(newDistrict);
                            $('#city').text(newCity);

                            originalAddress = newAddress;
                            originalWard = newWard;
                            originalDistrict = newDistrict;
                            originalCity = newCity;
                            
                            $('#editForm').hide();
                            $('#userInfo').show();
                            alert('Cập nhật địa chỉ thành công!');
                        } else {
                            alert('Có lỗi xảy ra khi cập nhật địa chỉ.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown);
                        alert('Có lỗi xảy ra khi kết nối với server.');
                    }
                });
            });
        });
    </script>
</body>

</html>
