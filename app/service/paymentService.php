<?php
require_once __DIR__ . '/../DAL/PaymentDAO.php';
require_once __DIR__ . '/../DAL/OrderDAO.php';
require_once __DIR__ . '/../service/orderService.php';
require_once __DIR__ . "/../packages/mollie-api-php/vendor/autoload.php";
require_once __DIR__ . '/../env/index.php';

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
            "redirectUrl" => "https://104f-2a02-a458-2851-1-a5d9-9e52-dc1c-8896.eu.ngrok.io/order?id=".$order->id,
            "webhookUrl" => "https://104f-2a02-a458-2851-1-a5d9-9e52-dc1c-8896.eu.ngrok.io/api/payment/status",
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
                "value" => $order->total, // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "method" => \Mollie\Api\Types\PaymentMethod::PAYPAL,
            "description" => "Order #$order->id",
            "redirectUrl" => "https://104f-2a02-a458-2851-1-a5d9-9e52-dc1c-8896.eu.ngrok.io/order?id=".$order->id,
            "webhookUrl" => "https://104f-2a02-a458-2851-1-a5d9-9e52-dc1c-8896.eu.ngrok.io/api/payment/status",
            "metadata" => [
                "order_id" => $order->id,
            ],
        ]);

        return $payment;
    }
    
    public function createPayment($account_id, $session_id, $method, $issuer, $paymentAccountInfo) {
        if ($method == "ideal" && !$issuer) throw new Exception("Dont forget to choose a bank.", 1);

        $service = new OrderService();
        $order = $service->createOrder($account_id);
        
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

    public function payLater() {

    }

    public function paymentWebhook($id) {
        $dao = new PaymentDAO();
        $orderDAO = new OrderDAO();

        $mollie = $this->getMollie();
        $payment = $mollie->payments->get($id);

        $dao->updatePaymentStatus($payment->metadata->order_id, $payment->status);

        switch ($payment->status) {
            case 'paid':
                //TODO: Send email with invoice and tickets
                break;
            case 'expired':
            case 'failed':
            case 'canceled':
                //TODO: Cancel order, return stock
                $orderDAO->cancelOrder($payment->metadata->order_id);
                break;
        }
    }
}
?>