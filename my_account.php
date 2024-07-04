<?php include './includes/db_connect.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage account</title>
    <link rel="icon" type="image/x-icon" href="./images/header/logo.png">
    <link rel="stylesheet" href="./css/my_account.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php include './includes/header.php' ?>

    <div class="container">
        <div class="sidebar">
            <h2 class="sidebar-text">My account</h2>
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
                        <?php include './includes/my-account/order-history.php' ?>
                    </tbody>
                </table>
            </div>

            <div id="address-Book" class="content-section">
                <form id="addressForm">
                    <div class="address-container">
                        <div class="address-row">
                            <label for="province">Province/City</label>
                            <input type="text" id="province" name="province" placeholder="Province/City" disabled>
                        </div>
                        <div class="address-row">
                            <label for="district">District</label>
                            <input type="text" id="district" name="district" placeholder="District" disabled>
                        </div>
                        <div class="address-row">
                            <label for="ward">Ward</label>
                            <input type="text" id="ward" name="ward" placeholder="Ward" disabled>
                        </div>
                        <div class="address-row">
                            <label for="Detailed Address">House number, street, etc.</label>
                            <input type="text" id="detailedAddress" name="detailedAddress" placeholder="House number, street, etc." disabled>
                        </div>
                    </div>
                    <button id="editAddressButton" type="button">Edit</button>
                    <button id="updateAddressButton" type="submit" style="display: none;">Update</button>
                    <button id="cancelAddressButton" type="button" style="display: none;">Cancel</button>
                </form>
            </div>


            <div id="account-Detail" class="content-section">
                <h2>Account Details</h2>
                <form id="accountDetailsForm">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" disabled>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" disabled>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-with-icon">
                            <input type="email" id="email" name="email" disabled>
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" disabled>
                    </div>
                    <div class="form-actions">
                        <button type="button" id="editButton" onclick="toggleEdit()">Edit</button>
                        <button type="submit" id="updateButton" style="display: none;">Update</button>
                        <button type="button" id="cancelButton" onclick="cancelEdit()" style="display: none;">Cancel</button>
                    </div>
                </form>
            </div>

            <div id="change-Password" class="content-section">
                <form id="changePasswordForm" method="post" action="./includes/my-account/change_password.php">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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


        // Address Book
        $('#editAddressButton').click(function() {
            $('#province, #district, #ward, #detailedAddress').prop('disabled', false).each(function() {
                if ($(this).val() === 'Not set') {
                    $(this).val('');
                }
            });
            $(this).hide();
            $('#updateAddressButton, #cancelAddressButton').show();
        });

        $('#cancelAddressButton').click(function() {
            $.ajax({
                url: './includes/my-account/address_book.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#province').val(data.tỉnh_thành_phố);
                    $('#district').val(data.quận_huyện);
                    $('#ward').val(data.xã_phường);
                    $('#detailedAddress').val(data.địa_chỉ);
                    $('#province, #district, #ward, #detailedAddress').prop('disabled', true);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching address: " + error);
                }
            });
            $('#editAddressButton').show();
            $('#updateAddressButton, #cancelAddressButton').hide();
        });

        $(document).ready(function() {
            // Lấy thông tin địa chỉ khi trang được tải
            $.ajax({
                url: './includes/my-account/address_book.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#province').val(data.tỉnh_thành_phố);
                    $('#district').val(data.quận_huyện);
                    $('#ward').val(data.xã_phường);
                    $('#detailedAddress').val(data.địa_chỉ);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching address: " + error);
                }
            });

            // Xử lý khi form được submit
            $('#addressForm').on('submit', function(e) {
                e.preventDefault();

                // Check if all fields are empty or just whitespace
                var allFieldsEmpty = true;
                $('#province, #district, #ward, #detailedAddress').each(function() {
                    if ($.trim($(this).val()) !== '') {
                        allFieldsEmpty = false;
                        return false; // break the loop
                    }
                });

                if (allFieldsEmpty) {
                    alert("All fields cannot be empty");
                    return;
                }

                $.ajax({
                    url: './includes/my-account/address_book.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            // Disable các input sau khi cập nhật thành công
                            $('#province, #district, #ward, #detailedAddress').prop('disabled', true);
                            $('#editAddressButton').show();
                            $('#updateAddressButton, #cancelAddressButton').hide();
                        } else {
                            alert("Error updating address: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error updating address: " + error);
                    }
                });
            });
        });



        // Account Detail

        // Retrieving User Data
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './includes/my-account/account-detail.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var user = JSON.parse(xhr.responseText);
                document.getElementById('firstName').value = user.first_name || 'Not set';
                document.getElementById('lastName').value = user.last_name || 'Not set';
                document.getElementById('email').value = user.email_address || 'Not set';
                document.getElementById('phoneNumber').value = user.phone_number || 'Not set';
            }
        };
        xhr.send();

        function toggleEdit() {
            const inputs = document.querySelectorAll('#accountDetailsForm input:not([name="email"])');
            const editButton = document.getElementById('editButton');
            const updateButton = document.getElementById('updateButton');
            const cancelButton = document.getElementById('cancelButton');

            inputs.forEach(input => {
                input.disabled = !input.disabled;
                if (!input.disabled && input.value === 'Not set') {
                    input.value = '';
                }
            });
            editButton.style.display = 'none';
            updateButton.style.display = 'inline-block';
            cancelButton.style.display = 'inline-block';
        }

        function cancelEdit() {
            const form = document.getElementById('accountDetailsForm');
            const inputs = form.querySelectorAll('input');
            const editButton = document.getElementById('editButton');
            const updateButton = document.getElementById('updateButton');
            const cancelButton = document.getElementById('cancelButton');

            inputs.forEach(input => {
                input.disabled = true;
                if (input.value === '') {
                    input.value = 'Not set';
                }
            });

            editButton.style.display = 'inline-block';
            updateButton.style.display = 'none';
            cancelButton.style.display = 'none';
        }

        document.getElementById('accountDetailsForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Validate phone number
            const phoneNumber = document.getElementById('phoneNumber').value;
            const phoneRegex = /^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/;

            if (phoneNumber !== 'Not set' && !phoneRegex.test(phoneNumber)) {
                alert('Please enter a valid Vietnamese phone number.');
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', './includes/my-account/account-detail.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('Account details updated successfully!');
                        toggleEdit(); // Disable inputs and show edit button
                    } else {
                        alert('Error updating account details: ' + response.message);
                    }
                } else {
                    alert('An error occurred while updating account details.');
                }
            };
            xhr.send('firstName=' + encodeURIComponent(document.getElementById('firstName').value) +
                '&lastName=' + encodeURIComponent(document.getElementById('lastName').value) +
                '&phoneNumber=' + encodeURIComponent(document.getElementById('phoneNumber').value));
        });


        // Change password 
        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var xhr = new XMLHttpRequest();
            xhr.open('POST', './includes/my-account/change_password.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log("Response status:", this.status);
                console.log("Response text:", this.responseText);
                if (this.status == 200) {
                    try {
                        // Find the start of JSON in response
                        var jsonStartIndex = this.responseText.indexOf('{');
                        if (jsonStartIndex !== -1) {
                            var jsonResponse = this.responseText.substr(jsonStartIndex);
                            var response = JSON.parse(jsonResponse);
                            if (response.success) {
                                alert("Success: " + response.message);
                            } else {
                                alert("Error: " + response.message);
                            }
                        } else {
                            throw new Error("Invalid JSON response");
                        }
                    } catch (e) {
                        console.error("JSON parse error:", e);
                        alert("An error occurred while processing your request");
                    }
                } else {
                    alert("An error occurred while processing your request. Please try again later.");
                }
            };
            xhr.send('currentPassword=' + encodeURIComponent(document.getElementById('currentPassword').value) +
                '&newPassword=' + encodeURIComponent(document.getElementById('newPassword').value) +
                '&confirmPassword=' + encodeURIComponent(document.getElementById('confirmPassword').value));
        });


        // Logout button
        function handleLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "./login/logout.php";
            }
        }
    </script>
</body>

</html>