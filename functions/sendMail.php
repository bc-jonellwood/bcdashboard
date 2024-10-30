<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Composers Autoloader
require 'vendor/autoload.php';
function sendmail($to, $subject, $jsonData)
{

    $mail = new PHPMailer(true);

    // decode the json and make sure its good
    $data = json_decode($jsonData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON decode error: ' . json_last_error());
    }

    // somehow figure out how to send the data we want and not the data we dont want
    try {
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = "smtp.berkeleycountysc.gov";
        $mail->Host = "10.50.10.10";
        $mail->Port = 25;
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false;

        $mail->setFrom('noreply@berkeleycountysc.gov', 'myBerkeley');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = '';
        foreach ($data as $key => $value) {
            $mail->Body .= $value;
        }
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
