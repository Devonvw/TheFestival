<?php

require __DIR__ . '/../../service/invoiceService.php';

class APIInvoiceController
{
    private $invoiceService;

    function __construct()
    {
        $this->invoiceService = new InvoiceService();
    }

    public function getInvoice($orderId)
    {
        try {
            echo json_encode($this->invoiceService->getInvoice($orderId));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}