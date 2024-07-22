<!-- checkout.php -->
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
            <div class="col-md-5">
                <h2>SHIPPING INFO</h2>
                <div id="userInfo">
                    <p><strong>NAME:</strong> <span id="fullName" class="editable"><?php echo getValue($user_data['first_name'] . ' ' . $user_data['last_name']); ?></span></p>
                    <p><strong>PHONE NUMBER:</strong> <span id="phone" class="editable"><?php echo getValue($user_data['phone_number']); ?></span></p>
                    <p><strong>CITY:</strong> <span id="city" class="editable"><?php echo getValue($user_data['city']); ?></span></p>
                    <p><strong>DISTRICT:</strong> <span id="district" class="editable"><?php echo getValue($user_data['district']); ?></span></p>
                    <p><strong>WARD:</strong> <span id="ward" class="editable"><?php echo getValue($user_data['ward']); ?></span></p>
                    <p><strong>ADDRESS:</strong> <span id="address" class="editable"><?php echo getValue($user_data['address']); ?></span></p>
                </div>
                <div id="editForm" style="display: none;">
                    <input type="text" id="editFullName" placeholder="Full Name">
                    <input type="text" id="editPhone" placeholder="Phone Number">
                    <input type="text" id="editCity" placeholder="City">
                    <input type="text" id="editDistrict" placeholder="District">
                    <input type="text" id="editWard" placeholder="Ward">
                    <input type="text" id="editAddress" placeholder="Address">
                </div>
                <button id="editBtn">EDIT</button>
                <div id="warnings"></div>
            </div>
            <div class="col-md-7">
                <h2>YOUR ORDER</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th class="text-end">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['title']); ?> <b>× <?php echo $item['quantity']; ?></b></td>
                                    <td class="text-end"><?php echo number_format($item['total'], 2, ',', '.'); ?> ₫</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td>PROVISIONAL INVOICE</td>
                                <td class="text-end"><?php echo number_format($totalPrice, 2, ',', '.'); ?> ₫</td>
                            </tr>
                            <tr>
                                <td>SHIPPING</td>
                                <td>
                                    <?php foreach ($payment_options as $option) : ?>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="payment<?php echo $option['id']; ?>" value="<?php echo $option['id']; ?>" data-payment="<?php echo htmlspecialchars($option['payment_method']); ?>" data-shipment="<?php echo htmlspecialchars($option['shipment_method']); ?>" data-shipping-cost="<?php echo $option['shipment_method'] == 'Ship' ? 50000 : 0; ?>" <?php echo ($option === reset($payment_options)) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="payment<?php echo $option['id']; ?>">
                                                <?php echo htmlspecialchars($option['payment_method'] . ' - ' . $option['shipment_method']); ?>
                                                <?php if ($option['shipment_method'] == 'Ship') : ?>
                                                    (Shipping cost: 50,000 ₫)
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL</strong></td>
                                <td class="text-end"><strong id="totalPrice"><?php echo number_format($totalPrice + (($payment_options[0]['shipment_method'] == 'Ship') ? 50000 : 0), 2, ',', '.'); ?> ₫</strong></td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <button type="button" id="orderButton" class="btn btn-dark btn-order w-100 mt-3">PLACE ORDER</button>
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

            $('#editBtn').click(function() {
                if (!isEditing) {
                    // Switch to edit mode
                    isEditing = true;
                    $('#editBtn').text('CANCEL');
                    $('#userInfo').hide();
                    $('#editForm').show();

                    // Populate edit form with current values, removing 'Not set'
                    $('.editable').each(function() {
                        let value = $(this).text().trim();
                        let inputId = 'edit' + $(this).attr('id').charAt(0).toUpperCase() + $(this).attr('id').slice(1);
                        if (value === 'Not set') {
                            $('#' + inputId).val('');
                        } else {
                            $('#' + inputId).val(value);
                        }
                    });

                    // Add save button
                    $('#editForm').append('<button id="saveBtn" class="btn btn-primary mt-2">SAVE</button>');
                } else {
                    // Cancel edit mode
                    isEditing = false;
                    $('#editBtn').text('EDIT');
                    $('#userInfo').show();
                    $('#editForm').hide();
                    $('#saveBtn').remove();
                }
            });

            $(document).on('click', '#saveBtn', function() {
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
                            // Update displayed info
                            $('#fullName').text(fullName || 'Not set');
                            $('#phone').text(phone || 'Not set');
                            $('#address').text(address || 'Not set');
                            $('#ward').text(ward || 'Not set');
                            $('#district').text(district || 'Not set');
                            $('#city').text(city || 'Not set');

                            // Switch back to display mode
                            isEditing = false;
                            $('#editBtn').text('EDIT');
                            $('#userInfo').show();
                            $('#editForm').hide();
                            $('#saveBtn').remove();

                            alert('Shipping information updated successfully');
                        } else {
                            alert('Failed to update shipping information: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('An error occurred while updating the shipping information: ' + error);
                    }
                });
            });

            function updateTotal() {
                let selectedOption = $('input[name="paymentMethod"]:checked');
                let shippingCost = parseFloat(selectedOption.data('shipping-cost')) || 0; // Use parseFloat for decimals
                let subtotal = <?php echo $totalPrice; ?>;
                let total = subtotal + shippingCost;

                // Format to two decimal places
                $('#totalPrice').text(total.toFixed(2).replace('.', ',') + ' ₫'); // Replace '.' with ','
                return total;
            }

            $('input[name="paymentMethod"]').change(updateTotal);

            // Initial update
            updateTotal();

            $('#orderButton').click(function(e) {
                e.preventDefault();

                let selectedOption = $('input[name="paymentMethod"]:checked');
                let paymentShipmentId = selectedOption.val();
                let total = updateTotal();

                // Collect cart items
                let cartItems = [];
                $('.cart-item').each(function() {
                    let item = {
                        product_id: parseInt($(this).data('product-id')),
                        quantity: parseInt($(this).find('.item-quantity').text()),
                        price: $(this).find('.item-price').data('price')
                    };
                    cartItems.push(item);
                });

                // Collect order info data
                let orderData = {
                    payment_shipment_id: paymentShipmentId,
                    order_total: total,
                    cart_items: cartItems,
                    checkout_info: {
                        recipient_name: $('#recipientName').val(),
                        recipient_phone: $('#recipientPhone').val(),
                        address: $('#address').val(),
                        ward: $('#ward').val(),
                        district: $('#district').val(),
                        city: $('#city').val()
                    }
                };

                // Send AJAX request
                $.ajax({
                    url: './order/process_order.php',
                    type: 'POST',
                    data: JSON.stringify(orderData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Order placed successfully! Order ID: ' + response.order_id);
                            // Redirect to order confirmation page
                            window.location.href = './order/order-detail.php?id=' + response.order_id;
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while placing the order: ' + error);
                        console.error('AJAX Error:', status, error);
                    }
                });
            });
        });
    </script>
</body>

</html>