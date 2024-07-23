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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$user_query = "SELECT u.first_name, u.last_name, u.phone_number, 
                      a.address, a.ward, a.district, a.city
               FROM site_user u
               LEFT JOIN user_address ua ON u.id = ua.user_id
               LEFT JOIN address a ON ua.address_id = a.id
               WHERE u.id = ?";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$result = $user_stmt->get_result();
$user_data = $result->fetch_assoc();

// Function to check if a value is set and not empty
function getValue($value)
{
    return (isset($value) && !empty($value)) ? htmlspecialchars($value) : 'Not set';
}

// Fetch address data
$address_query = "SELECT a.* FROM address a 
                  JOIN user_address ua ON a.id = ua.address_id 
                  WHERE ua.user_id = ?";
$address_stmt = $conn->prepare($address_query);
$address_stmt->bind_param("i", $user_id);
$address_stmt->execute();
$address_result = $address_stmt->get_result();

if ($address_result->num_rows > 0) {
    $address_data = $address_result->fetch_assoc();
} else {
    $address_data = array(
        'address' => '',
        'ward' => '',
        'district' => '',
        'city' => ''
    );
}


// Fetch payment options
$payment_options_query = "SELECT po.*, so.shipment_method 
                          FROM payment_option po
                          JOIN payment_shipment ps ON po.id = ps.payment_option_id
                          JOIN shipment_option so ON ps.shipment_option_id = so.id";
$payment_options_result = $conn->query($payment_options_query);
$payment_options = [];

if ($payment_options_result->num_rows > 0) {
    while ($row = $payment_options_result->fetch_assoc()) {
        $payment_options[] = $row;
    }
}

// Process cart data from POST
$cartItems = [];
$totalPrice = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartData'])) {
    $cartData = json_decode($_POST['cartData'], true);

    if (is_array($cartData)) {
        foreach ($cartData as $item) {
            $price = floatval(str_replace(['$', ','], '', $item['price']));
            $quantity = intval($item['quantity']);
            $itemTotal = $price * $quantity;
            $totalPrice += $itemTotal;

            $cartItems[] = [
                'title' => $item['title'],
                'price' => $price,
                'quantity' => $quantity,
                'total' => $itemTotal
            ];
        }
    }
}

// Process order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placeOrder'])) {
    $payment_shipment_id = $_POST['paymentMethod'];
    $order_total = $_POST['orderTotal'];
    $order_status_id = 1;

    // Insert into shop_order table
    $order_query = "INSERT INTO shop_order (site_user_id, order_date, payment_shipment_id, order_total, order_status_id) 
                    VALUES (?, CURDATE(), ?, ?, ?)";
    $order_stmt = $conn->prepare($order_query);
    $order_stmt->bind_param("iddi", $user_id, $payment_shipment_id, $order_total, $order_status_id);

    if ($order_stmt->execute()) {
        $order_id = $conn->insert_id;

        // Insert order items
        $item_query = "INSERT INTO order_items (shop_order_id, product_id, qty, price_at_order) VALUES (?, ?, ?, ?)";
        $item_stmt = $conn->prepare($item_query);

        foreach ($cartItems as $item) {
            if (!isset($item['product_id'])) {
                // Handle the missing product_id case
                error_log("Missing product_id in cart item: " . print_r($item, true));
                continue;
            }
            $item_stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
            $item_stmt->execute();
        }

        $address_query = "INSERT INTO checkout_address (shop_order_id, city, district, ward, address) 
                          VALUES (?, ?, ?, ?, ?)";
        $address_stmt = $conn->prepare($address_query);
        $address_stmt->bind_param("issss", $order_id, $address_data['city'], $address_data['district'], $address_data['ward'], $address_data['address']);
        $address_stmt->execute();

        header("Location: ./order/order_confirmation.php?order_id=" . $order_id);
        exit();
    } else {
        $error_message = "An error occurred while placing your order. Please try again.";
    }
}

$hasAddress = !empty($user_data['address']) &&
    !empty($user_data['ward']) &&
    !empty($user_data['district']) &&
    !empty($user_data['city']);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Store - Checkout</title>
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
            <div class="col-md-3">
                <h2>SHIPPING INFO</h2>
                <div id="userInfo">
                    <p><strong>Name:</strong> <span id="fullName" class="editable"><?php echo getValue($user_data['first_name'] . ' ' . $user_data['last_name']); ?></span></p>
                    <p><strong>Phone number:</strong> <span id="phone" class="editable"><?php echo getValue($user_data['phone_number']); ?></span></p>
                    <p><strong>City:</strong> <span id="city" class="editable"><?php echo getValue($user_data['city']); ?></span></p>
                    <p><strong>District:</strong> <span id="district" class="editable"><?php echo getValue($user_data['district']); ?></span></p>
                    <p><strong>Ward:</strong> <span id="ward" class="editable"><?php echo getValue($user_data['ward']); ?></span></p>
                    <p><strong>Address:</strong> <span id="address" class="editable"><?php echo getValue($user_data['address']); ?></span></p>
                </div>
                <button id="editBtn" class="btn btn-dark btn-order w-100 mt-3">EDIT</button>
                <div id="editForm" style="display: none;">
                    <input type="text" id="editFullName" placeholder="Full Name">
                    <input type="text" id="editPhone" placeholder="Phone Number">
                    <input type="text" id="editCity" placeholder="City">
                    <input type="text" id="editDistrict" placeholder="District">
                    <input type="text" id="editWard" placeholder="Ward">
                    <input type="text" id="editAddress" placeholder="Address">
                    <div class="button-container">
                        <button id="cancelBtn" class="btn btn-danger">CANCEL</button>
                        <button id="saveBtn" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
                <div id="warnings"></div>
            </div>
            <div class="col-md-9">
                <h2>YOUR ORDER</h2>
                <div class="table-responsive">
                    <table class="table table-bordered product-table">
                    <thead>
                        <tr>
                            <th class="product-name">PRODUCT</th>
                            <th class="product-total text-end">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item) : ?>
                            <tr>
                                <td class="product-name"><?php echo htmlspecialchars($item['title']); ?> <b>× <?php echo $item['quantity']; ?></b></td>
                                <td class="product-total text-end">$<?php echo number_format($item['total'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>PROVISIONAL INVOICE</td>
                            <td class="text-end">$<?php echo number_format($totalPrice, 2, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td>SHIPPING</td>
                            <td>
                                <?php foreach ($payment_options as $option) : ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="payment<?php echo $option['id']; ?>" value="<?php echo $option['id']; ?>" data-payment="<?php echo htmlspecialchars($option['payment_method']); ?>" data-shipment="<?php echo htmlspecialchars($option['shipment_method']); ?>" data-shipping-cost="<?php echo $option['shipment_method'] == 'Shipping' ? 2 : 0; ?>" <?php echo ($option === reset($payment_options)) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="payment<?php echo $option['id']; ?>">
                                            <?php echo htmlspecialchars($option['payment_method'] . ' - ' . $option['shipment_method']); ?>
                                            <?php if ($option['shipment_method'] == 'Shipping') : ?>
                                                (Fees: 2$)
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>TOTAL</strong></td>
                            <td class="text-end">$<strong id="totalPrice"><?php echo number_format($totalPrice + (($payment_options[0]['shipment_method'] == 'Shipping') ? 2 : 0), 2, ',', '.'); ?></strong></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <button type="button" id="orderButton" class="btn btn-dark btn-order w-100 mt-3" <?php echo $hasAddress ? '' : 'disabled'; ?>>PLACE ORDER</button>
                <p id="addressWarning" class="text-danger mt-2" style="display: none;">You need to type in your address to place your order!</p>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include './includes/footer.php' ?>
    <?php include './includes/cart.php' ?>

    <script>
        $(document).ready(function() {
            let isEditing = false;
            let hasAddress = <?php echo $hasAddress ? 'true' : 'false'; ?>;

            function updateOrderButtonState() {
                if (hasAddress) {
                    $('#orderButton').prop('disabled', false);
                    $('#addressWarning').hide();
                } else {
                    $('#orderButton').prop('disabled', true);
                    $('#addressWarning').show();
                }
            }

            updateOrderButtonState();

            $('#editBtn').click(function() {
                isEditing = true;
                $('#editBtn').hide();
                $('#userInfo').hide();
                $('#editForm').show();

                $('.editable').each(function() {
                    let value = $(this).text().trim();
                    let inputId = 'edit' + $(this).attr('id').charAt(0).toUpperCase() + $(this).attr('id').slice(1);
                    if (value === 'Not set') {
                        $('#' + inputId).val('');
                    } else {
                        $('#' + inputId).val(value);
                    }
                });
            });

            $('#cancelBtn').click(function() {
                isEditing = false;
                $('#editBtn').show();
                $('#userInfo').show();
                $('#editForm').hide();
            });

            $('#saveBtn').click(function() {
                let fullName = $('#editFullName').val();
                let phone = $('#editPhone').val();
                let address = $('#editAddress').val();
                let ward = $('#editWard').val();
                let district = $('#editDistrict').val();
                let city = $('#editCity').val();

                $.ajax({
                    url: './order/update_shipping_info.php',
                    type: 'POST',
                    data: {
                        full_name: fullName,
                        phone: phone,
                        address: address,
                        ward: ward,
                        district: district,
                        city: city
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#fullName').text(fullName || 'Not set');
                            $('#phone').text(phone || 'Not set');
                            $('#address').text(address || 'Not set');
                            $('#ward').text(ward || 'Not set');
                            $('#district').text(district || 'Not set');
                            $('#city').text(city || 'Not set');

                            isEditing = false;
                            $('#editBtn').show();
                            $('#userInfo').show();
                            $('#editForm').hide();

                            hasAddress = address && ward && district && city && fullName && phone;
                            updateOrderButtonState();

                            $('#addressWarning').removeClass('text-danger').addClass('text-success').text('Address updated successfully').show().delay(3000).fadeOut();
                        } else {
                            $('#addressWarning').removeClass('text-success').addClass('text-danger').text('Failed to update address: ' + response.message).show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        $('#addressWarning').removeClass('text-success').addClass('text-danger').text('An error occurred while updating the address').show();
                    }
                });
            });

            function updateTotal() {
                let selectedOption = $('input[name="paymentMethod"]:checked');
                let shippingCost = parseInt(selectedOption.data('shipping-cost')) || 0;
                let subtotal = <?php echo $totalPrice; ?>;
                let total = subtotal + shippingCost;

                $('#totalPrice').text(total.toFixed(2).replace('.', ','));
                return total;
            }

            $('input[name="paymentMethod"]').change(updateTotal);

            updateTotal();

            $('#orderButton').click(function(e) {
                e.preventDefault();

                if (!hasAddress) {
                    $('#editBtn').click();
                    $('#addressWarning').removeClass('text-success').addClass('text-danger').text('Please provide your address before placing an order').show();
                    return;
                }

                let selectedOption = $('input[name="paymentMethod"]:checked');
                let paymentShipmentId = selectedOption.val();
                let total = updateTotal();

                let cartData = localStorage.getItem('cart');
                let cartItems = JSON.parse(cartData);

                let orderData = {
                    payment_shipment_id: paymentShipmentId,
                    order_total: total,
                    cart_items: cartItems,
                    checkout_info: {
                        recipient_name: $('#fullName').text().trim(),
                        recipient_phone: $('#phone').text().trim(),
                        address: $('#address').text().trim(),
                        ward: $('#ward').text().trim(),
                        district: $('#district').text().trim(),
                        city: $('#city').text().trim()
                    }
                };

                $.ajax({
                    url: './order/process_order.php',
                    type: 'POST',
                    data: JSON.stringify(orderData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            localStorage.removeItem('cart');
                            window.location.href = './order/order-detail.php?id=' + response.order_id;
                        } else {
                            $('#addressWarning').removeClass('text-success').addClass('text-danger').text('Error: ' + response.message).show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        console.log('Response Text:', xhr.responseText);
                        $('#addressWarning').removeClass('text-success').addClass('text-danger').text('An error occurred while placing the order. Please try again.').show();
                    }
                });
            });
        });
    </script>
</body>

</html>