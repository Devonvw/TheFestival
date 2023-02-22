<?php
require_once __DIR__ . '/../DAL/CartDAO.php';

class CartService {

    public function createCart($account_id, $session_id){
        $dao = new cartDAO();
        $dao->createCart($account_id, $session_id);
    }
    public function addToCart($ticket_id, $account_id, $session_id){
        $dao = new cartDAO();
        $dao->addToCart($ticket_id, $account_id, $session_id);
    }

}