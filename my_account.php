<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage account</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="./css/my_account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php include './includes/header.php' ?>
    <div class="header-space" style="height: 140px;"></div>

    <h1 class="header-text">My account</h1>

    <div class="container">
        <div class="sidebar">
            <button onclick="showContent('orderHistory')"><i class="fa-solid fa-box-open" style="color: #424248;"></i>ORDERS</button>
            <button onclick="showContent('addressBook')"><i class="fa-solid fa-map-location-dot" style="color: #424248;"></i>ADDRESS BOOK</button>
            <button onclick="showContent('accountDetail')"><i class="fa-regular fa-user" style="color: #424248;"></i>ACCOUNT DETAIL</button>
            <button onclick="showContent('changePassword')"><i class="fa-solid fa-lock" style="color: #424248;"></i>CHANGE PASSWORD</button>
            <button id="logoutButton" onclick="handleLogout()">
                <i class="fa-solid fa-arrow-right-from-bracket" style="color: #424248;"></i>LOGOUT
            </button>

        </div>
        <div class="content">
            <div id="orderHistory">
                <h2>Orders</h2>
                <!-- Nội dung liên quan đến lịch sử đơn hàng -->
            </div>

            <div id="addressBook" style="display: none;">
                <h2>Address</h2>
                <!-- Nội dung liên quan đến địa chỉ -->
                <h1>Address</h1>
                <h1>Address</h1>
                <h1>Address</h1>
                <h1>Address</h1>
                <h1>Address</h1>
                <h1>Address</h1>
                <h1>Address</h1>
                <h1>Address</h1>

            </div>

            <div id="accountDetail" style="display: none;">
                <h2>Account detail</h2>
            </div>

            <div id="changePassword" style="display: none;">
                <h2>Change Password</h2>
                <form id="changePasswordForm">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <div class="password-input">
                            <input type="password" id="currentPassword" name="currentPassword" placeholder="Current Password">
                            <i class="fas fa-eye-slash password-toggle" onclick="togglePasswordVisibility('currentPassword')"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <div class="password-input">
                            <input type="password" id="newPassword" name="newPassword" placeholder="New Password">
                            <i class="fas fa-eye-slash password-toggle" onclick="togglePasswordVisibility('newPassword')"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <div class="password-input">
                            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                            <i class="fas fa-eye-slash password-toggle" onclick="togglePasswordVisibility('confirmPassword')"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn-change-password">Change Password</button>
                </form>
            </div>
        </div>
    </div>

    <div class="footer-wrapper">
        <?php include './includes/footer.php' ?>

    </div>

    <script>
        // script show content cac muc trong menu
        function showContent(contentId) {
            const contents = document.getElementsByClassName('content')[0].children;
            for (let i = 0; i < contents.length; i++) {
                contents[i].style.display = 'none';
            }
            document.getElementById(contentId).style.display = 'block';
        }

        // default is order history page 
        showContent('orderHistory');

        // show / hide password
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const passwordToggle = passwordInput.parentNode.querySelector('.password-toggle');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggle.classList.remove("fa-eye-slash");
                passwordToggle.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                passwordToggle.classList.remove("fa-eye");
                passwordToggle.classList.add("fa-eye-slash");
            }
        }
        // button logout
        // function handleLogout() {
        //     if (confirm("Are you sure you want to logout?")) {
        //         // Xóa trạng thái đăng nhập từ localStorage
        //         localStorage.removeItem('isLoggedIn');

        //         // Chuyển hướng người dùng đến trang đăng nhập hoặc trang chủ
        //         window.location.href = './login/login.php'; // Hoặc trang chủ của bạn
        //     }
        // }

        // // Kiểm tra trạng thái đăng nhập khi trang được tải
        // window.onload = function() {
        //     let isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
        //     if (!isLoggedIn) {
        //         // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
        //         window.location.href = './login/login.php';
        //     }
        // }
    </script>
</body>

</html>