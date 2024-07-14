<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/order-detail.css">
</head>

<body>
    <?php include './includes/header.php' ?>

    <div class="order-status">
        <div class="card">
            <div class="row d-flex justify-content-between px-3 top">
                <div class="d-flex">
                    <h5>ORDER <span class="text-primary font-weight-bold">#Y34XDHR</span></h5>
                </div>
                <!-- <div class="d-flex flex-column text-sm-right">
                    <p class="mb-0">Expected Arrival <span>01/12/19</span></p>
                    <p>USPS <span class="font-weight-bold">234094567242423422898</span></p>
                </div> -->
            </div>
            <!-- Add class 'active' to progress -->
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <ul id="progressbar" class="text-center">
                        <li class="active step0"></li>
                        <li class="active step0"></li>
                        <li class="active step0"></li>
                        <li class="step0"></li>
                    </ul>
                </div>
            </div>
            <div class="row justify-content-between top">
                <div class="row d-flex icon-content">
                    <i class="icon fa-regular fa-calendar-check"></i>
                    <div class="d-flex flex-column">
                        <p class="font-weight-bold">Order<br>Processed</p>
                    </div>
                </div>
                <div class="row d-flex icon-content">
                    <i class="icon fa-solid fa-box"></i>
                    <div class="d-flex flex-column">
                        <p class="font-weight-bold">Order<br>Shipped</p>
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
                <p>2406068W5AJGNJ</p>
            </div>
            <div class="shipping-address">
                <h3>Địa chỉ nhận hàng</h3>
                <p>T*****h, *****72</p>
                <p>31 Quán Thánh, Phường Quán Thánh, Quận Ba Đình, Hà Nội</p>
            </div>
        </div>

        <div class="order-container payment-info">
            <h3>Thông tin thanh toán</h3>
            <div class="product-item">
                <table class="table table-striped table-hover">
                    <thead>
                        <th scope="col" class="col-1">STT</th>
                        <th scope="col" class="col-7">Product</th>
                        <th scope="col" class="col-1">Price</th>
                        <th scope="col" class="col-1">Quantity</th>
                        <th scope="col" class="col-1" >Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Product name is 1</td>
                            <td>$20</td>
                            <td>1</td>
                            <td>$20</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="product-item total">
                <span>Doanh Thu Đơn Hàng</span>
                <span>165.540đ</span>
            </div>
        </div>
    </div>

    <?php include './includes/footer.php' ?>
</body>

</html>