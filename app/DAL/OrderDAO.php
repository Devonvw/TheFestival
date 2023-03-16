<?php
require __DIR__ . '/../model/Cart.php';
require __DIR__ . '/../model/CartItem.php';
require __DIR__ . '/CartDAO.php';

class OrderDAO
{
    public $DB;

    function __construct()
    {
        $this->DB = new DB();
    }

    public function createOrder($accountId) {
        $this->DB::$connection->beginTransaction();

        //TODO: Handle if not logged in
        $stmt = $this->DB::$connection->prepare("INSERT INTO `order` (account_id) VALUES (:account_id);");
        $stmt->bindParam(':account_id', $accountId);
        $stmt->execute();
        $orderId = $this->DB::$connection->lastInsertId();

        $cartDAO = new cartDAO();
        $cart = $cartDAO->getCart($accountId);

        //Add to price to keep price consistent, if a ticket price changes the order price doesn't
        $sql = "INSERT INTO order_item (ticket_id, order_id, price) VALUES (:ticket_id, :order_id, :price);";

        foreach ($cart->cart_items as $cart_item) {
            for ($i = 0; $i < $cart_item->quantity; $i++) {
                $stmt = $this->DB::$connection->prepare($sql);
                $stmt->bindValue(':ticket_id', $cart_item->ticket->id, PDO::PARAM_INT);
                $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
                $stmt->bindValue(':price', $cart_item->ticket->price, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        //Handle delete cart items
        $sql = "DELETE FROM cart_item WHERE cart_id = :cart_id;";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':cart_id', $cart->id, PDO::PARAM_INT);
        $stmt->execute();

        //Handle stock
        $sql = "UPDATE event_item_slot SET stock = stock - :persons WHERE id = :event_item_slot_id";

        foreach ($cart->cart_items as $cart_item) {
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindValue(':persons', $cart_item->ticket->persons * $cart_item->quantity, PDO::PARAM_INT);
            $stmt->bindValue(':event_item_slot_id', $cart_item->ticket->event_item_slot_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        $this->DB::$connection->commit();
    }
}