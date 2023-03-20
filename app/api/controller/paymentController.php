<?php

require __DIR__ . '/../../service/paymentService.php';

class APIPaymentController
{
    private $paymentService;

    function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    public function getIdealIssuers()
    {
        session_start();

        try {
            echo json_encode($this->paymentService->getIdealIssuers());
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function createPayment()
    {
        session_start();
        
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $paymentAccountInfo = ["email" => $body["email"], "name" => $body["name"], "country" => $body["country"], "city" => $body["city"], "address" => $body["address"], "zipcode" => $body["zipcode"]];

            echo $this->paymentService->createPayment(isset($_SESSION['id']) ? $_SESSION['id'] : null, session_id(), $body["method"], isset($body["issuer"]) ? $body["issuer"] : null, $paymentAccountInfo);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function paymentWebhook()
    {
        session_start();

        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->paymentService->paymentWebhook($_POST["id"], isset($body['id']) ? $body['id'] : null, isset($body['status']) ? $body['status'] : null);
            echo json_encode(['msg' => "Succes"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}