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
    <link rel="stylesheet" href="./css/checkoutTEST.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include './includes/header.php' ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <h2>CHI TIẾT THANH TOÁN</h2>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên *</label>
                        <input type="text" class="form-control" id="name" placeholder="Họ tên của bạn">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại *</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại của bạn">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Địa chỉ email *</label>
                            <input type="email" class="form-control" id="email" placeholder="Email của bạn">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="city" class="form-label">Tỉnh/Thành phố *</label>
                            <select class="form-select" id="city">
                                <option selected>Hà Nội</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="district" class="form-label">Quận/Huyện *</label>
                            <select class="form-select" id="district">
                                <option selected>Chọn quận huyện</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ward" class="form-label">Xã/Phường *</label>
                            <select class="form-select" id="ward">
                                <option selected>Chọn xã/phường</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Địa chỉ *</label>
                            <input type="text" class="form-control" id="address" placeholder="Ví dụ: Số 20, ngõ 90">
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="otherAddress">
                        <label class="form-check-label" for="otherAddress">GIAO HÀNG TỚI ĐỊA CHỈ KHÁC?</label>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú đơn hàng (tùy chọn)</label>
                        <textarea class="form-control" id="note" rows="3" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                <h2>PHƯƠNG THỨC THANH TOÁN</h2>
                <div class="payment-info mb-4">
                    <p class="mb-1">Chuyển khoản qua ngân hàng</p>
                    <p class="mb-0">Thực hiện thanh toán của bạn vào tài khoản ngân hàng.</p>
                </div>
                <table class="table">
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
                    </tbody>
                </table>
                <div class="mb-3">
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
                            NHẬN TẠI ..... (Thanh toán trước & đến lấy)
                        </label>
                    </div>
                </div>
                <p class="total">TỔNG CỘNG: 1,080,000 ₫</p>
                <button type="submit" class="btn btn-dark btn-order w-100">ĐẶT HÀNG</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php include './includes/footer.php' ?>

</body>

</html>