<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendOrderConfirmationEmail($to, $subject, $orderDetails) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->CharSet = 'utf-8';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'accredfingervippro2@gmail.com';
        $mail->Password = 'cwqjysfgzuepyzzc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

    
        $mail->setFrom('accredfingervippro2@gmail.com', 'Hoot Records');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;

        $body = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; }
                .header { background-color: #f8f9fa; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <img src="./images/header/logo_co_chu_png" alt="Store Logo" style="max-width: 200px;">
                    <h1>Order Confirmation</h1>
                </div>
                <div class="content">
                    <p>Thank you for your order!</p>
                    <h2>Order Details:</h2>
                    ' . $orderDetails . '
                </div>
            </div>
        </body>
        </html>';

        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}