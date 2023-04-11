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

    public function createOrder($accountId = null, $sessionId = null, $token = null) {
        $this->DB::$connection->beginTransaction();

        $cartDAO = new cartDAO();
        $cart = $cartDAO->getCart($accountId, $sessionId, $token);

        $stmt = $this->DB::$connection->prepare("INSERT INTO `order` (account_id, session_id) VALUES (:account_id, :session_id);");
        $stmt->bindParam(':account_id', $cart->account_id);
        $stmt->bindValue(':session_id', $cart->account_id ? null : $cart->session_id);
        $stmt->execute();
        $orderId = $this->DB::$connection->lastInsertId();

        if (count($cart->cart_items) == 0) {
            $this->DB::$connection->rollBack();
            throw new Exception("Your cart doesn't contain tickets.", 1);
        } 

        // ASSESSMENT If a ticket price changes the order price doesn't

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
        $sql = "UPDATE event_item_slot SET stock = stock - :persons WHERE id = :event_item_slot_id;";

        foreach ($cart->cart_items as $cart_item) {
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindValue(':persons', $cart_item->ticket->persons * $cart_item->quantity, PDO::PARAM_INT);
            $stmt->bindValue(':event_item_slot_id', $cart_item->ticket->event_item_slot_id, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $this->DB::$connection->prepare("SELECT stock FROM event_item_slot WHERE id = :event_item_slot_id LIMIT 1;");
            $stmt->bindValue(':event_item_slot_id', $cart_item->ticket->event_item_slot_id, PDO::PARAM_INT);
            $stmt->execute();
            $stock = $stmt->fetchObject();

            if ($stock->stock < 0) {
                // ASSESSMENT Rollback when there are not enough tickets left
                $this->DB::$connection->rollBack();
                throw new Exception('You tried to order tickets for ' .$cart_item->ticket->persons * $cart_item->quantity. " person(s) for the following event: " . $cart_item->ticket->event_item_name . ". But there are only tickets for ". $stock->stock + $cart_item->ticket->persons * $cart_item->quantity. " person(s) left. Reduce the amount of tickets and try again.", 1);
            }
        }

        $this->DB::$connection->commit();

        return $orderId;
    }

    public function cancelOrder($orderId) {
        $this->DB::$connection->beginTransaction();

        $dao = new OrderDAO();
        $order = $dao->getOrder($orderId);

        //Handle stock
        $sql = "UPDATE event_item_slot SET stock = stock + :persons WHERE id = :event_item_slot_id";

        foreach ($order->order_items as $order_item) {
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindValue(':persons', $order_item->ticket->persons * $order_item->quantity, PDO::PARAM_INT);
            $stmt->bindValue(':event_item_slot_id', $order_item->ticket->event_item_slot_id, PDO::PARAM_INT);
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
        $sql = "SELECT `order`.id, `order`.account_id, order_payment.status, CONCAT(account.first_name, ' ', account.last_name) as name, SUM(oi.price) as total, `order`.created_at  FROM `order` LEFT JOIN order_item as oi ON oi.order_id = order.id LEFT JOIN account ON account.id = `order`.account_id LEFT JOIN order_payment ON order_payment.order_id = order.id GROUP BY order.id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderStatus($orderId) {
        $sql = "SELECT o.id, op.status FROM `order` as o LEFT JOIN order_payment as op ON op.order_id = o.id WHERE o.id = :order_id;";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
}