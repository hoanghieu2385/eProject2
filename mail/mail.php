<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class Mailer
{
    public function sendMail($title, $content, $addressMail)
    {
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
            $mail->addAddress($addressMail);

            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body = $content;
            $mail->AltBody = strip_tags($content);

            if ($mail->send()) {
                // echo "Email has been sent successfully.";
                return true;
            } else {
                echo "An error occurred while sending the email.";
                return false;
            }
        } catch (Exception $e) {
            echo "An error occurred while sending the email: {$mail->ErrorInfo}";
            return false;
        }
    }
}
