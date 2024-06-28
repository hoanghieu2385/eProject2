<?php

?>
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
    <?php include './includes/db_connect.php' ?>
    <?php include './includes/header.php' ?>
    <div class="header-space" style="height: 140px;"></div>

    <h1 class="header-text">My account</h1>

    <div class="container">
        <div class="sidebar">
            <button onclick="showContent('order-History')"><i class="fa-solid fa-box-open" style="color: #424248;"></i>ORDERS</button>
            <button onclick="showContent('address-Book')"><i class="fa-solid fa-map-location-dot" style="color: #424248;"></i>ADDRESS BOOK</button>
            <button onclick="showContent('account-Detail')"><i class="fa-regular fa-user" style="color: #424248;"></i>ACCOUNT DETAIL</button>
            <button onclick="showContent('change-Password')"><i class="fa-solid fa-lock" style="color: #424248;"></i>CHANGE PASSWORD</button>
            <button id="logoutButton" onclick="handleLogout()">
                <i class="fa-solid fa-arrow-right-from-bracket" style="color: #424248;"></i>LOGOUT
            </button>
        </div>
        <div class="content">
            <div id="order-History" class="content-section">
                <h2>Orders</h2>

                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Shipment tracking id</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include './includes/order-history.php' ?>
                    </tbody>
                </table>
            </div>

            <div id="address-Book" class="content-section">
                <h2>Address</h2>
            </div>

            <div id="account-Detail" class="content-section">
                <h2>Account detail</h2>
            </div>

            <div id="change-Password" class="content-section">
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
        // Show content
        function showContent(sectionId) {
            // Get all sidebar buttons
            const buttons = document.querySelectorAll('.sidebar button');

            // Loop through all buttons and remove the 'active' class
            buttons.forEach(button => {
                button.classList.remove('active');
            });

            // Add the 'active' class to the selected button
            const selectedButton = document.querySelector(`.sidebar button[onclick="showContent('${sectionId}')"]`);
            selectedButton.classList.add('active');

            // Get all content sections
            const sections = document.querySelectorAll('.content-section');

            // Loop through all sections and hide them
            sections.forEach(section => {
                section.style.display = 'none';
                section.classList.remove('active');
            });

            // Display the selected section
            document.getElementById(sectionId).style.display = 'block';

        }

        // Show / hide password
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

        // Show content based on URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        const section = urlParams.get('section');

        if (section) {
            showContent(section);
        } else {
            showContent('order-History');
        }

        // logout 
        function handleLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "./login/logout.php";
            }
        }
    </script>
</body>

</html>