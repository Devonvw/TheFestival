<?php
require __DIR__ . '/../model/Order.php';
require __DIR__ . '/../model/OrderItem.php';
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

        return $orderId;
    }

    public function cancelOrder($orderId) {
        $this->DB::$connection->beginTransaction();

        $sql = "SELECT * FROM order where id = :orderId";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetchObject();

        $cartDAO = new cartDAO();
        $cart = $cartDAO->getCart($order->account_id, $order->session_id);

        //Handle stock
        $sql = "UPDATE event_item_slot SET stock = stock + :persons WHERE id = :event_item_slot_id";

        foreach ($cart->cart_items as $cart_item) {
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindValue(':persons', $cart_item->ticket->persons * $cart_item->quantity, PDO::PARAM_INT);
            $stmt->bindValue(':event_item_slot_id', $cart_item->ticket->event_item_slot_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        $this->DB::$connection->commit();
    }

    public function getOrder($orderId) {
        $sql = "SELECT * FROM `order` WHERE id = :order_id LIMIT 1";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Order");
        $order = $stmt->fetch();

        if (!$order) throw new Exception("This order doesn't exist.", 1);

        //$items_stmt = $this->DB::$connection->prepare("SELECT oi.*, eis.start, eis.end, eist.price as ticket_price, eist.persons, eist.event_item_slot_id, ei.name as event_item_name, e.name as event_name FROM `order` INNER JOIN order_item as oi on oi.order_id = order.id left join event_item_slot_ticket as eist on oi.ticket_id = eist.id left join event_item_slot as eis on eis.id = eist.event_item_slot_id left join event_item as ei on eis.event_item_id = ei.id left join event as e on ei.event_id = e.id WHERE `order`.id = :order_id;");
        $items_stmt = $this->DB::$connection->prepare("SELECT COUNT(oi.id) as quantity, COUNT(oi.id) * oi.price as price, oi.order_id, oi.ticket_id, eis.start, eis.end, eist.price as ticket_price, eist.persons, eist.event_item_slot_id, ei.location, ei.name as event_item_name, e.name as event_name FROM `order` INNER JOIN order_item as oi on oi.order_id = order.id left join event_item_slot_ticket as eist on oi.ticket_id = eist.id left join event_item_slot as eis on eis.id = eist.event_item_slot_id left join event_item as ei on eis.event_item_id = ei.id left join event as e on ei.event_id = e.id WHERE `order`.id = :order_id GROUP BY oi.order_id, oi.ticket_id, oi.price, eis.start, eis.end, eist.price, eist.persons, eist.event_item_slot_id, ei.location, ei.name, e.name;");
        $items_stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $items_stmt->execute();
        $items = $items_stmt->fetchAll();

        $order_items = [];

        $total = $subtotal = $vat = 0;

        foreach ($items as $row) {
            $total += $row['price'];
            $subtotal += $row['price'] / 1.21;
            $vat +=  $row['price'] - ($row['price'] / 1.21);
            array_push($order_items, new OrderItem($row['order_id'], new Ticket($row['ticket_id'], $row['event_item_slot_id'], $row['start'], $row['end'], $row["location"], $row['event_item_name'], $row['event_name'], $row['persons'], $row['ticket_price']), $row['price'],  $row['quantity']));
        }

        $order->total = $total;
        $order->subtotal = $subtotal;
        $order->vat = $vat;
        $order->order_items = $order_items;

        return $order;
    }

    public function getOrderTickets($orderId) {
        $stmt = $this->DB::$connection->prepare("SELECT oi.order_id, oi.ticket_id, eis.start, eis.end, oi.price, eist.price as ticket_price, eist.persons, eist.event_item_slot_id, ei.location, ei.name as event_item_name, e.name as event_name FROM `order` INNER JOIN order_item as oi on oi.order_id = order.id left join event_item_slot_ticket as eist on oi.ticket_id = eist.id left join event_item_slot as eis on eis.id = eist.event_item_slot_id left join event_item as ei on eis.event_item_id = ei.id left join event as e on ei.event_id = e.id WHERE `order`.id = :order_id;");
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();

        $tickets = [];
        foreach ($items as $row) {
            array_push($tickets, new Ticket($row['ticket_id'], $row['event_item_slot_id'], $row['start'], $row['end'], $row['location'], $row['event_item_name'], $row['event_name'], $row['persons'], $row['ticket_price']));
        }

        return $tickets;
    }

    public function getAllOrders() {
        // $sql = "SELECT * FROM `order` WHERE id = :order_id LIMIT 1";
        // $stmt = $this->DB::$connection->prepare($sql);
        // $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        // $stmt->execute();
        // $stmt->setFetchMode(PDO::FETCH_CLASS, "Order");
        // $order = $stmt->fetch();
    }
}