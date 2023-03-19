<?php
require_once __DIR__ . '/../DAL/OrderDAO.php';
require_once __DIR__ . '/../service/pdfService.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class OrderService {
    public function createOrder($accountId){
        $dao = new OrderDAO();
        $pdf = new PDFService();

        $orderId = $dao->createOrder($accountId);

        $order = $dao->getOrder($orderId);
        $tickets = $dao->getOrderTickets($orderId);

        //Get account info
        $account = ["email" => 'devonvanw@gmail.com', "name" => "Devon van Wichen", "country" => "The Netherlands", "city" => "Schagen", "address" => "Eksterstraat 81", "zipcode" => "1742EN"];
        $invoice = $pdf->createInvoicePDF($order, $account);
        $tickets = $pdf->createTicketsPDF($tickets, $orderId, $account);
    
        // If the email has been updated, send a confirmation email
    // try {
    //     $mail = new PHPMailer(true);

    //     // Server settings
    //     $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
    //     $mail->isSMTP(); // Send using SMTP
    //     $mail->SMTPAuth = true;
    //     $mail->SMTPSecure = 'tls';
    //     $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
    //     $mail->SMTPAuth = true; // Enable SMTP authentication
    //     $mail->Username = 'festivalteamhaarlem@gmail.com'; // SMTP username
    //     $mail->Password = 'Festivalproject'; // SMTP password
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    //     $mail->Port = 465; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //     // Recipients
    //     $mail->setFrom('festivalteamhaarlem@gmail.com', 'Festival Team');
    //     $mail->addAddress($account["email"], $account["name"]); // Add a recipient

    //     // Content
    //     $mail->isHTML(false); // Set email format to plain text
    //     $mail->Subject = "Confirmation for order ". $orderId;
    //     $mail->Body = "Dear " . $account["name"] . ",\n\nYour order has been succesfully processed. Included in this email are the tickets and the invoice. \n\nBest regards,\nThe festival team";

    //     $mail->AddAttachment($invoice);
    //     $mail->AddAttachment($tickets);
    //     $mail->send();
    //     $mail->smtpClose();
    // }
    // catch (Exception $ex) {
    //     var_dump($ex);
    // }
        return $order;
    }

    public function getOrder($orderId){
        $dao = new OrderDAO();
        return $dao->getOrder($orderId);
    }
    public function getOrderTickets($orderId){
        $dao = new OrderDAO();
        return $dao->getOrderTickets($orderId);
    }
}