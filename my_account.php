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
    <div class="header-space"></div>

    <h1 class="header-text">My account</h1>

    <div class="container">
        <div class="sidebar">
            <button onclick="showContent('orderHistory')">Order History</button>
            <button onclick="showContent('changePassword')">Security</button>
            <button onclick="showContent('address')">Address</button>
        </div>
        <div class="content">
            <div id="orderHistory">
                <h2>Order History</h2>
                <!-- Nội dung liên quan đến lịch sử đơn hàng -->
            </div>
            <div id="changePassword" style="display: none;">
                <h2>Change Password</h2>
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Current password</label>
                    <div class="password-input">
                        <input type="password" class="form-control" id="currentPassword">
                        <i class="fas fa-eye-slash password-toggle" onclick="togglePasswordVisibility('currentPassword')"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New password</label>
                    <div class="password-input">
                        <input type="password" class="form-control" id="newPassword">
                        <i class="fas fa-eye-slash password-toggle" onclick="togglePasswordVisibility('newPassword')"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm new password</label>
                    <div class="password-input">
                        <input type="password" class="form-control" id="confirmPassword">
                        <i class="fas fa-eye-slash password-toggle" onclick="togglePasswordVisibility('confirmPassword')"></i>
                    </div>
                </div>
                <button class="btn btn-primary">Change</button>
            </div>
            <div id="address" style="display: none;">
                <h2>Address</h2>
                <!-- Nội dung liên quan đến địa chỉ -->
            </div>
        </div>
    </div>

    <?php include './includes/footer.php' ?>


    <script>
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
    </script>
</body>

</html>