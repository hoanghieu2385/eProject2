<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoot Records</title>
    <link rel="icon" type="image/x-icon" href="../images/header/logo.png">
</head>
<style>
    .payment-content {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .payment-content h1 {
        text-align: center;
        color: #333;
    }

    .payment-content h2 {
        color: #333;
        border-bottom: 1px solid #ddd;
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

    body.dark-mode .payment-info h2 {
        color: white;
    }
</style>


<body>
    <?php include '../includes/header.php' ?>

    <main class="payment-content">
        <div class="payment-info">
            <h2>PAYMENT INFORMATION</h2>
            <p>Customers will receive an order confirmation email as soon as Hoot Records receives the order. The email will include payment information, invoice, and the amount due.</p>
            <p>Please note that this email does not mean Hoot Records has received the payment. You will receive a successful payment notification email after Hoot Records receives the funds.</p>

            <h2>BANK TRANSFER PAYMENT</h2>
            <p><strong>Bank:</strong> Techcombank</p>
            <p><strong>Account Holder:</strong> Tran Binh Minh</p>
            <p><strong>Account Number:</strong> MS00T01690295738639</p>
            <p><strong>Transfer Content:</strong> Order ID + PHONE NUMBER</p>
            <p>For pre-orders, customers are kindly requested to pay 100% of the order value. After receiving the payment, customers will receive an email confirming successful payment, invoice number, and shipping tracking information.</p>

            <h2>COD PAYMENT</h2>
            <p>COD (Cash on Delivery) payment is only available for in-stock products. Customers will pay an additional collection fee of 15k or 2% of the order value for orders over 3,000,000 VND.</p>
        </div>
    </main>

    <?php include '../includes/footer.php' ?>
</body>

</html>
