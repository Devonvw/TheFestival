<?php
require_once __DIR__ . '/../DAL/OrderDAO.php';
require_once __DIR__ . '/../service/pdfService.php';


class OrderService {
    public function createOrder($accountId, $session_id){
        $dao = new OrderDAO();

        $orderId = $dao->createOrder($accountId, $session_id);

        $order = $dao->getOrder($orderId);

        return $order;
    }

    public function getOrder($orderId){
        $dao = new OrderDAO();
        return $dao->getOrder($orderId);
    }
    public function getOrderTickets($orderId){
        $dao = new OrderDAO();
        return $dao->getOrderTickets($orderId);
    }

    public function getAllOrders(){
        $dao = new OrderDAO();
        return $dao->getAllOrders();
    }

    public function getOrderStatus($orderId){
        $dao = new OrderDAO();
        return $dao->getOrderStatus($orderId);
    }
}