<?php
require_once __DIR__ . '/../DAL/PaymentDAO.php';
require_once __DIR__ . '/../DAL/OrderDAO.php';
require_once __DIR__ . '/../DAL/InvoiceDAO.php';
require_once __DIR__ . '/../service/pdfService.php';
require_once __DIR__ . '/../service/orderService.php';
require_once __DIR__ . "/../packages/mollie-api-php/vendor/autoload.php";
require_once __DIR__ . '/../env/index.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class PaymentService {
    private function getMollie() {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(MOLLIE_TOKEN);
        return $mollie;
    }

    private function createIdealPayment($order, $issuer) {
        $mollie = $this->getMollie();

        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => sprintf('%.2F',$order->total), // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "method" => \Mollie\Api\Types\PaymentMethod::IDEAL,
            "description" => "Order #$order->id",
            "redirectUrl" => API_URL ."/order?id=".$order->id,
            "webhookUrl" => API_URL ."/api/payment/status",
            "metadata" => [
                "order_id" => $order->id,
            ],
            "issuer" => $issuer,
        ]);

        return $payment;
    }

    private function createPaypalPayment($order) {
        $mollie = $this->getMollie();

        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => sprintf('%.2F', $order->total), // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "method" => \Mollie\Api\Types\PaymentMethod::PAYPAL,
            "description" => "Order #$order->id",
            "redirectUrl" => API_URL ."/order?id=".$order->id,
            "webhookUrl" => API_URL ."/api/payment/status",
            "metadata" => [
                "order_id" => $order->id,
            ],
        ]);

        return $payment;
    }
    
    public function createPayment($account_id, $session_id, $method, $issuer, $paymentAccountInfo, $token) {
        if (!$method) throw new Exception("Dont forget to choose a payment method.", 1);
        if ($method == "ideal" && !$issuer) throw new Exception("Dont forget to choose a bank.", 1);
        if (!$paymentAccountInfo["name"]) throw new Exception("Don't forget to fill in your name.", 1);
        if (!$paymentAccountInfo["email"]) throw new Exception("Don't forget to fill in your email.", 1);
        if (!$paymentAccountInfo["country"]) throw new Exception("Don't forget to fill in your country.", 1);
        if (!$paymentAccountInfo["city"]) throw new Exception("Don't forget to fill in your city.", 1);
        if (!$paymentAccountInfo["zipcode"]) throw new Exception("Don't forget to fill in your zipcode.", 1);
        if (!$paymentAccountInfo["address"]) throw new Exception("Don't forget to fill in your address.", 1);

        $service = new OrderService();
        $order = $service->createOrder($account_id, $session_id, $token);

        $payment = null;
        if ($method == "Ideal" && $issuer) $payment = $this->createIdealPayment($order, $issuer);
        else if ($method == "Paypal") $payment = $this->createPaypalPayment($order);

        $dao = new PaymentDAO();
        $dao->createPayment($order->id, $payment->id, $paymentAccountInfo);

        return json_encode(["link" => $payment->getCheckoutUrl()]);
    }

    public function getIdealIssuers() {
        try {
            $mollie = $this->getMollie();
            $method = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);
            return $method->issuers();
        }  catch (Exception $ex) {
            var_dump($ex);
        }
    }

    public function createPayLater($orderId) {
        $dao = new PaymentDAO();
        $service = new OrderService();

        $mollie = $this->getMollie();

        $order = $service->getOrder($orderId);

        $paymentLink = $mollie->paymentLinks->create([
            "amount" => [
                "currency" => "EUR",
                "value" => sprintf('%.2F', $order->total), 
            ],
            "description" => "Order #$order->id",
            "redirectUrl" => API_URL ."/order?id=".$orderId,
            "webhookUrl" => API_URL ."/api/payment/link", // optional
            "expiresAt" => (new DateTime("now +24 hours"))->format(DateTime::ATOM)
        ]);

        $dao->addPayLater($orderId, $paymentLink->id);
        $account = $dao->getPaymentAccountInfo($orderId);

        try {
            $mail = new PHPMailer(true);

            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
            $mail->isSMTP(); // Send using SMTP
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'festival.haarleminfo@gmail.com'; // SMTP username
            $mail->Password = SMPT_PASSWORD; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            // Recipients
            $mail->setFrom('festival.haarleminfo@gmail.com', 'Festival Team');
            $mail->addAddress($account->email, $account->name); // Add a recipient

            // Content
            $mail->isHTML(false); // Set email format to plain text
            $mail->Subject = "Payment failed for order ". $orderId;
            $mail->Body = "Dear " . $account->name . ",\n\nYour payment for order $orderId failed. You can still pay with this link.". $paymentLink->getCheckoutUrl() . " This link expires within 24 hours.\n\nBest regards,\nThe festival team";

            //$mail->AddAttachment($invoicePDF);
            $mail->send();
            $mail->smtpClose();
        }
        catch (Exception $ex) {
            var_dump($ex);
        }
    }

    public function paymentWebhook($id, $orderId = null, $newStatus = null) {
        $dao = new PaymentDAO();
        $orderDAO = new OrderDAO();

        if ($id) {
            $mollie = $this->getMollie();
            $payment = $mollie->payments->get($id);
            $newStatus = $payment->status;
            $orderId = $payment->metadata->order_id;
        }

        $dao->updatePaymentStatus($orderId, $newStatus);

        switch ($newStatus) {
            case 'paid':
                $this->handleOrderPaid($orderId);
                break;
            case 'expired':
            case 'failed':
                $this->createPayLater($orderId);
                break;
            case 'canceled':
                //Cancel order, return stock
                $orderDAO->cancelOrder($orderId);
                break;
        }
    }

    public function paymentLinkWebhook($id, $orderId = null, $newStatus = null) {
        $dao = new PaymentDAO();
        $orderDAO = new OrderDAO();

        if ($id) {
            $mollie = $this->getMollie();
            $paymentLink = $mollie->paymentLinks->get($id);
            $orderId = ($dao->getOrderIdByPaymentLink($id))->id;
        }

        if (new DateTime($paymentLink->expiresAt) < new DateTime()) {
             $dao->handlePayLater($id, 'expired');
             $orderDAO->cancelOrder($orderId);
        }
        else if ($paymentLink->paidAt) {
            $dao->handlePayLater($id, 'paid');
            $this->handleOrderPaid($orderId);
        }
    }

    // ASSESSMENT Handle ticket reserved stock, creating invoice and tickets, mail to customer. Save invoice as string
    private function handleOrderPaid($orderId) {
        $pdf = new PDFService();
        $orderDao = new OrderDAO();
        $dao = new PaymentDAO();
        $invoiceDao = new InvoiceDAO();

        $order = $orderDao->getOrder($orderId);
        $tickets = $orderDao->getOrderTickets($orderId);

        $account = $dao->getPaymentAccountInfo($orderId);

        $invoiceId = $invoiceDao->createInvoiceOrder($orderId);
        $invoicePDF = $pdf->createInvoicePDF($invoiceId, $order, $account);
        $invoiceDao->addInvoiceToOrder($invoiceId, $invoicePDF);

        $ticketsPDF = $pdf->createTicketsPDF($tickets, $orderId, $account);

        try {
            $mail = new PHPMailer(true);

            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
            $mail->isSMTP(); // Send using SMTP
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'festival.haarleminfo@gmail.com'; // SMTP username
            $mail->Password = SMPT_PASSWORD; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            // Recipients
            $mail->setFrom('festival.haarleminfo@gmail.com', 'Festival Team');
            $mail->addAddress($account->email, $account->name); // Add a recipient

            // Content
            $mail->isHTML(false); // Set email format to plain text
            $mail->Subject = "Confirmation for order ". $orderId;
            $mail->Body = "Dear " . $account->name . ",\n\nYour order has been successfully processed. Included in this email are the tickets and the invoice. \n\nBest regards,\nThe festival team";

            //$mail->AddAttachment($invoicePDF);
            $mail->AddStringAttachment($invoicePDF, "invoice-".$invoiceId."pdf", PHPMailer::ENCODING_BASE64, "application/pdf");  
            $mail->AddAttachment($ticketsPDF);
            $mail->send();
            $mail->smtpClose();
        }
        catch (Exception $ex) {
        }

        unlink(__DIR__ .'/../pdf/tickets-'. $orderId .'.pdf');
    }
}
?>