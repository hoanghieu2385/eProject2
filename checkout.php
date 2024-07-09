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
        body { font-family: Arial, sans-serif; }
        .form-control, .form-select { 
            font-size: 0.9rem; 
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
        }
        .form-label { font-size: 0.9rem; margin-bottom: 0.25rem; }
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
        .table th, .table td {
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
        h2 { font-size: 1.2rem; font-weight: bold; margin-bottom: 1.5rem; }
    </style>
</head>

<body>
    <?php include './includes/header.php' ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-5">
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
                                <td class="text-end">50,000 ₫</td>
                            </tr>
                            <tr>
                                <td><strong>TỔNG</strong></td>
                                <td class="text-end"><strong>1,080,000 ₫</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="payment-methods">
                    <h2>PHƯƠNG THỨC THANH TOÁN</h2>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="transfer" checked>
                        <label class="form-check-label" for="transfer">
                            THANH TOÁN CHUYỂN KHOẢN
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="cod">
                        <label class="form-check-label" for="cod">
                            THANH TOÁN KHI NHẬN HÀNG (COD)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="pickup">
                        <label class="form-check-label" for="pickup">
                            NHẬN TẠI 11/133 THÁI HÀ (Thanh toán trước & đến lấy)
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark btn-order w-100 mt-3">ĐẶT HÀNG</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php include './includes/footer.php' ?>
</body>

</html>