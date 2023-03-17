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
}