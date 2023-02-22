<?php

class cartDAO {
    public $DB;
       
    function __construct() {
      $this->DB = new DB();
    }

    public function createCart($account_id = null, $session_id = null) {
        $session_id = session_id();

        if ($account_id !== null) {
            $stmt = $this->DB::$connection->prepare("INSERT INTO cart (account_id) VALUES (:account_id)");
           
            $stmt->bindParam(':account_id', $account_id);
            $stmt->execute();
        } else {
            $stmt = $this->DB::$connection->prepare("INSERT INTO cart (session_id) VALUES (:session_id)");
           
            $stmt->bindParam(':session_id', $session_id);
            $stmt->execute();
        }
    
    }

    public function addToCart($ticket_id, $account_id = null, $session_id = null) {
        $cart = $this->getCart($account_id, $session_id);
        $sql = "INSERT INTO cart_item (ticket_id, cart_id) VALUES (:ticket_id, :cart_id)";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->bindParam(':cart_id', $cart->id);
        $stmt->execute();
    }
    public function removeFromCart($ticket_id, $account_id = null, $session_id = null) {
        $cart = $this->getCart($account_id, $session_id);
    
        $sql = "DELETE FROM cart_item WHERE ticket_id = :ticket_id AND cart_id = :cart_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->bindParam(':cart_id', $cart->cart_id);
        $stmt->execute();
    }

    public function clearCart($account_id = null, $session_id = null) {
        $cart = $this->getCart($account_id, $session_id);
        
        $sql = "DELETE FROM cart_item WHERE cart_id = :cart_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':cart_id', $cart->id);
        $stmt->execute();
        
        //update modified_at value
        $modified_at = date('Y-m-d H:i:s');
        $sql = "UPDATE cart SET modified_at = :modified_at WHERE id = :cart_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':modified_at', $modified_at);
        $stmt->bindParam(':cart_id', $cart->id);
        $stmt->execute();
    }
    

    public function getCartTickets($account_id = null, $session_id = null) {
        if ($account_id !== null) {
            $sql = "SELECT cart_item.ticket_id FROM cart JOIN cart_item ON cart.id = cart_item.cart_id WHERE cart.account_id = :account_id";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindParam(':account_id', $account_id);
            $stmt->execute();
            $tickets = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } else {
            $sql = "SELECT cart_item.ticket_id FROM cart JOIN cart_item ON cart.id = cart_item.cart_id WHERE cart.session_id = :session_id";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindParam(':session_id', $session_id);
            $stmt->execute();
            $tickets = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
    
        return $tickets;
    }
    
    
    
    public function getCart($account_id = null, $session_id = null) {
        if ($account_id !== null) {
            $sql = "SELECT * FROM cart WHERE account_id = :account_id";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindParam(':account_id', $account_id);
            $stmt->execute();
            $cart = $stmt->fetch(PDO::FETCH_CLASS, 'Cart');
        } else {
            $sql = "SELECT * FROM cart WHERE session_id = :session_id";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindParam(':session_id', $session_id);
            $stmt->execute();
            $cart = $stmt->fetch(PDO::FETCH_CLASS, 'Cart');
        }
        
        return $cart;
    }
    


    

}



