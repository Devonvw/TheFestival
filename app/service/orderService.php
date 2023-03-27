<?php
require_once __DIR__ . '/../DAL/OrderDAO.php';
require_once __DIR__ . '/../DAL/InvoiceDAO.php';
require_once __DIR__ . '/../service/pdfService.php';
require_once __DIR__ . '/../service/orderService.php';

class OrderService {
    public function createOrder($accountId, $session_id){
        $dao = new OrderDAO();

        $orderId = $dao->createOrder($accountId, $session_id);

        $order = $dao->getOrder($orderId);

        return $order;
    }

    public function getOrder($orderId){
        if (!$orderId) throw new Exception("Please specify an id.", 1);

        $dao = new OrderDAO();
        return $dao->getOrder($orderId);
    }
    public function getOrderTickets($orderId){
        if (!$orderId) throw new Exception("Please specify an id.", 1);

        $dao = new OrderDAO();
        return $dao->getOrderTickets($orderId);
    }

    public function getAllOrders(){
        $dao = new OrderDAO();
        return $dao->getAllOrders();
    }

    public function getOrderStatus($orderId){
        if (!$orderId) throw new Exception("Please specify an id.", 1);

        $dao = new OrderDAO();
        return $dao->getOrderStatus($orderId);
    }
}