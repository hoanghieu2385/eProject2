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
    body.dark-mode .payment-info h3
    {
        color: white;
    }
</style>


<body>
    <?php include '../includes/header.php' ?>

    <main class="payment-content">
        <div class="payment-info">
            <h2>SHIPPING INFORMATION</h2>
            
            <h3>Shipping Company Name :</h3>
            <p>Giao Hàng Nhanh</p>
            <p>Giao hàng tiết kiệm</p>
            <p>J&T Express</p>
            <p>Vietnam Post</p>
            <p>Viettel Post</p>
            <p>Ninja Van</p>

            <h2>REGULATION FOR TRANSPORTING GOODS</h2>
            <p>1 for 1 exchange if there is any mistake during the packing process.</p>
            <p>Return goods within 7 days if there is any problem due to the company (guarantee the goods are intact, need video verification when receiving the goods).</p>
            <p>If there is any other problem, please contact 0123456789.</p>

            <h2>SHIPPING QUOTE FOR EACH ITEM</h2>
            <p>If Fast Delivery, it will range from about 30-50k depending on the city.</p>
            <p>If Economy Delivery is available, it will range from about 20-33k depending on the city.</p>
        </div>
    </main>

    <?php include '../includes/footer.php' ?>
</body>

</html>
