<?php
require_once __DIR__ . '/../DAL/OrderDAO.php';

class OrderService {
    public function createOrder($accountId){
        $dao = new OrderDAO();
        $dao->createOrder($accountId);
    }
    public function getOrder($orderId){
        $dao = new OrderDAO();
        return $dao->getOrder($orderId);
    }
    public function getOrderTickets($orderId){
        $dao = new OrderDAO();
        return $dao->getOrderTickets($orderId);
    }
}