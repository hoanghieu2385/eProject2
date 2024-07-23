<!-- send_order_confirmation.php -->
<?php
require_once '../mail/mail.php';

function sendOrderConfirmationEmail($orderDetails, $userEmail)
{
    $mailer = new Mailer();
    $subject = 'Order Confirmation - Thank You for Your Purchase!';

    // Build email body (using null coalescing operator for missing data)
    $body = '
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f8f8f8; }
        .header { text-align: center; margin-bottom: 20px; }
        .order-summary { border: 1px solid #ddd; padding: 15px; background-color: white; margin-bottom: 20px; }
        .order-summary p { margin: 5px 0; } /* Điều chỉnh khoảng cách giữa các dòng */
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://img.upanh.tv/2024/07/24/logo_co_chu.png" alt="logo">
            <h1>Thank You for Your Order!</h1>
        </div>
        <p>Dear ' . htmlspecialchars($orderDetails['recipient_name'] ?? 'Customer') . ',</p>
        <p>Your order has been successfully placed.</p>

        <div class="order-summary">
            <h2>Order Summary</h2>
            <p><strong>Order ID:</strong> ' . htmlspecialchars($orderDetails['order_id'] ?? '') . '</p>
            <p><strong>Order Date:</strong> ' . htmlspecialchars($orderDetails['order_date'] ?? '') . '</p>
            <p><strong>Total Amount:</strong> $' . number_format($orderDetails['order_total'] ?? 0, 2) . '</p>
            <h3 style="margin-top: 10px;">Shipping Address:</h3>
            <p>' . nl2br(htmlspecialchars($orderDetails['shipping_address'] ?? '')) . '</p>
        </div>

        <p>We\'ll notify you when your order ships. Contact us if you have any questions.</p>
        <p>Thank you for shopping with us!</p>
        <div class="footer">
            <p>&copy; 2024 Record Store. All rights reserved.</p>
        </div>
    </div>
</body>
</html>';

    // Send the email and return the result (true or false)
    $result = $mailer->sendMail($subject, $body, $userEmail);

    // Log email sending outcome
    if ($result) {
        error_log("Order confirmation email sent successfully to $userEmail");
    } else {
        error_log("Failed to send order confirmation email to $userEmail: ");
    }

    return $result;
}

ob_end_clean();
