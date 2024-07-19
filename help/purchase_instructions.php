<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoot Records</title>
    <link rel="icon" type="image/x-icon" href="../images/header/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">d
</head>
<style>
    .payment-content {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .payment-content h1 {
        color: #333;
        padding-bottom: 10px;
        margin-top: 20px;
    }

    .payment-content h2 {
        color: #333;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-top: 20px;
    }

    .payment-content h3 {
        color: #333;
        padding-bottom: 10px;
        margin-top: 20px;
    }

    .payment-content p {
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .payment-content .payment-info {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
    }

    .payment-content strong {
        font-weight: bold;
    }

    /* dark mode */

    body.dark-mode .payment-info {
        background-color: #383535;
    }

    body.dark-mode .payment-info h2,
    body.dark-mode .payment-info h3,
    body.dark-mode .payment-info h1 {
        color: white;
    }
</style>


<body>
    <?php include '../includes/header.php' ?>

    <main class="payment-content">
        <div class="payment-info">
            <h1>PURCHASE INSTRUCTIONS</h1>
            <h2>CUSTOMERS CAN ORDER ON THE WEBSITE THROUGH 4 STEPS:</h2>

            <h3>STEP 1</h3>
            <p>Select the product you are interested in to view product information, price, status, list of songs on vinyl,...</p>

            <h3>STEP 2</h3>
            <p>Select the desired products into the shopping cart by clicking the "Add to cart" button on the product page. After adding the desired products to the cart, click “View cart” in the right corner. Here, customers check the product design, order quantity and total amount. Click “Pay” to continue.</p>
            <p>*Note: 3 product order statuses:</p>
            <p><strong>"Add to cart": </strong>Products are in stock and ready to ship.</p>
            <p><strong>“Pre-Order”: </strong>The product is not available in stock but can still be ordered from the manufacturer.</p>
            <p><strong>"See details": </strong>The product is not in stock and cannot be ordered.</p>


            <h3>STEP 3</h3>
            <p>To place an order, customers can create a <strong>new account</strong>. If you already have an account, you can log in with your email and password to automatically fill in delivery information. In addition to logging in, customers can <strong>update the shipping status</strong> of their orders through the system.</p>

            <h3>STEP 4</h3>
            <p>Choose a payment method and review the products, amount and shipping fee. You complete your order by clicking "Proceed to payment" and following the instructions on the checkout page. As soon as the order is received, Hoot Records will send an email confirming the order and instructing the next procedures in the email.</p>
        </div>
    </main>

    <?php include '../includes/footer.php' ?>
</body>

</html>