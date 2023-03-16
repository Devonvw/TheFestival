<?php

use Mollie\Api\Types\OrderStatus;

require __DIR__ . '/../../service/orderService.php';

class APIOrderController
{
    private $orderService;

    function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function createOrder()
    {
        session_start();

        try {
            $this->orderService->createOrder(isset($_SESSION['id']) ? $_SESSION['id'] : null);
            
            echo json_encode([ 'msg' => "Order succesfully created." ]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}