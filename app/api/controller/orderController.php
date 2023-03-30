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

    public function getOrder($orderId)
    {
        session_start();

        try {
            echo json_encode($this->orderService->getOrder($orderId));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getAllOrders()
    {

        try {
            echo json_encode($this->orderService->getAllOrders());
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getOrderStatus($orderId)
    {
        session_start();

        try {
            echo json_encode($this->orderService->getOrderStatus($orderId));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}