<?php
require __DIR__ . '/../model/Cart.php';
require __DIR__ . '/../model/CartItem.php';
require __DIR__ . '/../model/Ticket.php';
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

        $stmt = $this->DB::$connection->prepare("INSERT INTO order (account_id) VALUES (:account_id);");
        $stmt->bindParam(':account_id', $accountId);
        $stmt->execute();
        $orderId = $this->DB::$connection->lastInsertId();

        $cartDAO = new cartDAO();
        $cart = $cartDAO->getCart($accountId);

        $order_items = [];
        foreach ($cart->cart_items as $cart_item) {
            array_push($order_items, array('ticket_id' => $cart_item->ticket->id, 'order_id' => $orderId, 'price' => $cart_item->ticket->price));
        }

        $dataToInsert = array();

        array_push($dataToInsert, array_values($order_items));
        $colNames = array('ticket_id', 'order_id', 'price');

        $rowPlaces = '(' . implode(', ', array_fill(0, count($colNames), '?')) . ')';
        $allPlaces = implode(', ', array_fill(0, count($order_items), $rowPlaces));

        $sql = "INSERT INTO order_item (" . implode(', ', $colNames) . 
            ") VALUES " . $allPlaces;

        $stmt = $this->DB::$connection->prepare($sql);

        $stmt->execute($dataToInsert);

        $this->DB::$connection->commit();
    }
}