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
    public function removeFromCart($ticket_id, $account_id, $session_id){
        $dao = new cartDAO();
        $dao->removeFromCart($ticket_id, $account_id, $session_id);
    }
    public function clearCart($account_id, $session_id){
        $dao = new cartDAO();
        $dao->clearCart($account_id, $session_id);
    }
    public function getCartTickets($account_id, $session_id){
        $dao = new cartDAO();
        return $dao->getCartTickets($account_id, $session_id);
    }
    public function getCart($account_id, $session_id){
        $dao = new cartDAO();
        return $dao->getCart($account_id, $session_id);
    }

    

}