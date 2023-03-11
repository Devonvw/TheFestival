<?php
require_once __DIR__ . '/../DAL/PasswordResetDAO.php';
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
                "order_id" => $order["totalPrice"],
            ],
            "issuer" => $issuer,
        ]);
    }

    private function createPaypalPayment() {
        $mollie = $this->getMollie();
    }

    public function createPayment($account_id, $method, $issuer) {
        if ($method == "ideal" && !$issuer) throw new Exception("Dont forget to choose a bank.", 1);

        if ($method == "ideal" && $issuer) $this->createIdealPayment($issuer);
        else if ($method == "paypal") $this->createPaypalPayment();
    }

    public function getIdealIssuers() {
        $mollie = $this->getMollie();
        $method = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);

        return $method->issuers();
    }

    public function payLater() {

    }

    public function paymentWebhook($id) {
        $mollie = $this->getMollie();
        $payment = $mollie->payments->get($id);
    }
}
?>