<?php
require_once __DIR__ . '/../DAL/PaymentDAO.php';
require_once __DIR__ . '/../DAL/OrderDAO.php';
require_once __DIR__ . "/../packages/mollie-api-php/vendor/autoload.php";
require_once __DIR__ . '/../env/index.php';

class PaymentService {
    private function getMollie() {
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey(MOLLIE_TOKEN);
        return $mollie;
    }

    private function createIdealPayment($issuer) {
        $mollie = $this->getMollie();

        //Retrieve shopping cart and calculate total price;
        //TODO: create getorder function
        $order = ["totalPrice" => "27,79", "id" => 8];

        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $order["totalPrice"], // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "method" => \Mollie\Api\Types\PaymentMethod::IDEAL,
            "description" => "Order #{$order['totalPrice']}",
            "redirectUrl" => "",
            "webhookUrl" => "",
            "metadata" => [
                "order_id" => $order["id"],
            ],
            "issuer" => $issuer,
        ]);

        return $payment;
    }

    private function createPaypalPayment() {
        $mollie = $this->getMollie();

        //Retrieve shopping cart and calculate total price;
        //TODO: create getorder function
        $order = ["totalPrice" => "27,79", "id" => 8];

        $payment = $mollie->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $order["totalPrice"], // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "method" => \Mollie\Api\Types\PaymentMethod::PAYPAL,
            "description" => "Order #{$order['totalPrice']}",
            "redirectUrl" => "",
            "webhookUrl" => "",
            "metadata" => [
                "order_id" => $order["id"],
            ],
        ]);

        return $payment;
    }
    
    public function createPayment($account_id, $method, $issuer) {
        if ($method == "ideal" && !$issuer) throw new Exception("Dont forget to choose a bank.", 1);

        $payment = null;
        if ($method == "ideal" && $issuer) $payment = $this->createIdealPayment($issuer);
        else if ($method == "paypal") $payment = $this->createPaypalPayment();



        return $payment->getCheckoutUrl();
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