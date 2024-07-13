<?php
session_start();

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
                <form id="orderForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên *</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Họ tên của bạn" required maxlength="40">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Số điện thoại của bạn" required maxlength="13" pattern="[0-9]{10}">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Địa chỉ email *</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email của bạn" required pattern="[a-zA-Z0-9._%+-]+@gmail\.com$">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="city" class="form-label">Tỉnh/Thành phố *</label>
                            <select class="form-select" id="city" name="city" required>
                                <option selected>Hà Nội</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="district" class="form-label">Quận/Huyện *</label>
                            <select class="form-select" id="district" name="district" required>
                                <option selected>Chọn quận huyện</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ward" class="form-label">Xã/Phường *</label>
                            <select class="form-select" id="ward" name="ward" required>
                                <option selected>Chọn xã/phường</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Địa chỉ *</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Ví dụ: Số 20, ngõ 90" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú đơn hàng (tùy chọn)</label>
                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                    </div>
                </form>
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
                                <td>21 Savage - i am > i was (PA) (2 LP) (150g Vinyl/ Includes Download Insert) <b>× 1</b></td>
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
</body>

</html>