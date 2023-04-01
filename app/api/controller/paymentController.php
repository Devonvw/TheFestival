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

    public function createPayment($token)
    {
        session_start();
        
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $paymentAccountInfo = ["email" => isset($body["email"]) ? $body["email"] : null, "name" => isset($body["name"]) ? $body["name"] : null, "country" => isset($body["country"]) ? $body["country"] : null, "city" => isset($body["city"]) ? $body["city"] : null, "address" => isset($body["address"]) ? $body["address"] : null, "zipcode" => isset($body["zipcode"]) ? $body["zipcode"] : null];

            echo $this->paymentService->createPayment(isset($_SESSION['id']) ? $_SESSION['id'] : null, session_id(), isset($body["method"]) ? $body["method"] : null , isset($body["issuer"]) ? $body["issuer"] : null, $paymentAccountInfo, $token);
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

            $this->paymentService->paymentWebhook(isset($_POST["id"]) ? $_POST["id"] : null, isset($body['id']) ? $body['id'] : null, isset($body['status']) ? $body['status'] : null);
            echo json_encode(['msg' => "Succes"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function paymentLinkWebhook()
    {
        session_start();

        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->paymentService->paymentLinkWebhook($_POST["id"], isset($body['id']) ? $body['id'] : null, isset($body['status']) ? $body['status'] : null);
            echo json_encode(['msg' => "Succes"]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}