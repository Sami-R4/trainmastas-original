<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendors/email_vendor/autoload.php';

function sendEmail($recipientEmail, $content, $title)
{
    $mail = new PHPMailer(true);
    
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; // Hostinger SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'no-reply@trainmastas.com'; // Your Hostinger email
        $mail->Password = 'TrainMastas@2025'; // Secure way to store the password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL
        $mail->Port = 465; // 465 for SSL, 587 for TLS

        // Email Sender & Recipient
        $mail->setFrom('no-reply@trainmastas.com', 'TrainMastas');
        $mail->addAddress($recipientEmail); // User's email

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body    = $content;

        // Send Email
        $mail->send();
        return "Email sent!";
        
    } catch (Exception $e) {
        return "Error: " . $mail->ErrorInfo;
    }
}
