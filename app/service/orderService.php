<?php
require_once __DIR__ . '/../DAL/OrderDAO.php';

class OrderService {
    public function createOrder($account_id){
        $dao = new OrderDAO();
        $dao->createOrder($account_id);
    }
}