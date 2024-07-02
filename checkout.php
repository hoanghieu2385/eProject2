<?php
session_start();

if (isset($_POST['dark_mode'])) {  // Check if dark mode preference is submitted
    $_SESSION['dark_mode'] = $_POST['dark_mode'];  // Update session variable
}

$dark_mode = isset($_SESSION['dark_mode']) ? $_SESSION['dark_mode'] : false;  // Get dark mode preference
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="./css/checkout.css">

</head>

<body>
    <?php include './includes/header.php' ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>CHI TIẾT THANH TOÁN</h2>
                <form>
                    <div class="form-group">
                        <label for="name">Họ và tên *</label>
                        <input type="text" class="form-control" id="name" placeholder="Họ tên của bạn">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="phone">Số điện thoại *</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại của bạn">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Địa chỉ email *</label>
                            <input type="email" class="form-control" id="email" placeholder="Email của bạn">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="city">Tỉnh/Thành phố *</label>
                            <select class="form-control" id="city">
                                <option>Hà Nội</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="district">Quận/Huyện *</label>
                            <select class="form-control" id="district">
                                <option>Chọn quận huyện</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="ward">Xã/Phường *</label>
                            <select class="form-control" id="ward">
                                <option>Chọn xã/phường</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Địa chỉ *</label>
                            <input type="text" class="form-control" id="address" placeholder="Ví dụ: Số 20, ngõ 90">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="otherAddress">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="note">Ghi chú đơn hàng (tùy chọn)</label>
                        <textarea class="form-control" id="note" rows="3" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h2>PHƯƠNG THỨC THANH TOÁN</h2>
                <div class="payment-method">
                    <p>Chuyển khoản qua ngân hàng</p>
                    <p>Thực hiện thanh toán của bạn vào tài khoản ngân hàng.</p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>SẢN PHẨM</th>
                            <th>TẠM TÍNH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>21 Savage - i am > i was (PA) (2 LP) (150g Vinyl/ Includes Download Insert) × 1</td>
                            <td>1,030,000 ₫</td>
                        </tr>
                        <tr>
                            <td>TẠM TÍNH</td>
                            <td>1,030,000 ₫</td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="transfer" checked>
                    <label class="form-check-label" for="transfer">
                        THANH TOÁN CHUYỂN KHOẢN: 50,000 ₫
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="cod">
                    <label class="form-check-label" for="cod">
                        THANH TOÁN KHI NHẬN HÀNG (COD): 65,000 ₫
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="pickup">
                    <label class="form-check-label" for="pickup">
                        NHẬN TẠI 11/133 THÁI HÀ (Thanh toán trước & đến lấy)
                    </label>
                    <div class="total">
                        <h3>TỔNG CỘNG: 1,080,000 ₫</h3>
                    </div>
                    <button type="submit" class="btn btn-primary">ĐẶT HÀNG</button>
                </div>
            </div>
        </div>
    </div>
        <?php include './includes/footer.php' ?>

</body>

</html>