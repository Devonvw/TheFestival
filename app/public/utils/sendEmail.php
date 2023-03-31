<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once __DIR__ . '/../../packages/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../../packages/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../../packages/PHPMailer-master/src/PHPMailer.php';

function sendEmail($email, $firstName, $messageSubject, $messageBody) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
        $mail->isSMTP(); // Send using SMTP
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'festival.haarleminfo@gmail.com'; // SMTP username
        $mail->Password = 'cchfozteyygkuiwf'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        // Recipients
        $mail->setFrom('festival.haarleminfo@gmail.com', 'Festival Team');
        $mail->addAddress($email, $firstName); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to plain text
        $mail->Subject = $messageSubject;
        $mail->Body = $messageBody;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}