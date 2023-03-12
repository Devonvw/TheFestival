<?php
require __DIR__ . '/../model/Cart.php';
require __DIR__ . '/../model/CartItem.php';
require __DIR__ . '/../model/Ticket.php';

class cartDAO
{
    public $DB;

    function __construct()
    {
        $this->DB = new DB();
    }

    public function createCart($account_id = null, $session_id = null)
    {

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

    public function addToCart($ticket_id, $account_id = null, $session_id = null)
    {
        $cart = $this->getCart($account_id, $session_id);
        $sql = "INSERT INTO cart_item (ticket_id, cart_id) VALUES (:ticket_id, :cart_id)";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->bindParam(':cart_id', $cart->id);
        $stmt->execute();
    }
    public function removeFromCart($ticket_id, $account_id = null, $session_id = null)
    {
        $cart = $this->getCart($account_id, $session_id);

        $sql = "DELETE FROM cart_item WHERE ticket_id = :ticket_id AND cart_id = :cart_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':ticket_id', $ticket_id);
        $stmt->bindParam(':cart_id', $cart->cart_id);
        $stmt->execute();
    }

    public function clearCart($account_id = null, $session_id = null)
    {
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


    public function getCartTickets($account_id = null, $session_id = null)
    {
        if ($account_id !== null) {
            $sql = "SELECT eit.price, eit.persons, ei.name, ei.description, ei.location, ei.venue, ei.cousine, ei.seats FROM cart c 
                    JOIN cart_item ci ON c.id = ci.cart_id 
                    JOIN event_item_ticket eit ON ci.ticket_id = eit.id 
                    JOIN event_item ei ON eit.event_item_id = ei.id 
                    WHERE c.account_id = :account_id";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindParam(':account_id', $account_id);
            $stmt->execute();
            $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT eit.price, eit.persons, ei.name, ei.description, ei.location, ei.venue, ei.cousine, ei.seats FROM cart c 
                    JOIN cart_item ci ON c.id = ci.cart_id 
                    JOIN event_item_ticket eit ON ci.ticket_id = eit.id 
                    JOIN event_item ei ON eit.event_item_id = ei.id 
                    WHERE c.session_id = :session_id";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindParam(':session_id', $session_id);
            $stmt->execute();
            $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $tickets;
    }
    public function getCart($account_id = null, $session_id = null)
    {
        $cart = null;
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

        //TODO: Needs to be tested
        $items_stmt = $this->DB::$connection->prepare("SELECT ci.*, eit.price, eit.event_item_id, eit.persons, ei.name as event_item_name, e.name as event_name FROM `cart` LEFT JOIN cart_item as ci on ci.cart_id = cart.id left join event_item_ticket as eit on ci.ticket_id = eit.id left join event_item as ei on eit.event_item_id = ei.id left join event as e on ei.event_id = e.id WHERE cart.id = :cart_id;");
        $items_stmt->bindParam(':cart_id', $cart->id);
        $items_stmt->execute();
        $items = $stmt->fetchAll();

        $cart_items = [];

          foreach ($items as $row) {
            array_push($pages, new CartItem($row['id'], $row['cart_id'], new Ticket($row['ticket_id'], $row['event_item_id'], $row['event_item_name'], $row['event_name'], $row['persons'], $row['price']), $row['created_at']));
          }

        $cart->cart_items = $cart_items;

        return $cart;
    }

    public function createOrder($accountId) {
        $this->DB::$connection->beginTransaction();

            $stmt = $this->DB::$connection->prepare("INSERT INTO order (account_id) VALUES (:account_id);");
            $stmt->bindParam(':account_id', $accountId);
            $stmt->execute();
            $orderId = $this->DB::$connection->lastInsertId();

            $cart = $this->getCart($accountId);

            $order_items = [];
            foreach ($cart->cart_items as $cart_item) {
                array_push($order_items, array('ticket_id' => $cart_item->ticket->id, 'order_id' => $orderId, 'price' => $cart_item->ticket->price));
            }

            $dataToInsert = array();

            array_push($dataToInsert, array_values($order_items));
            $colNames = array('ticket_id', 'order_id', 'price');

            // setup the placeholders - a fancy way to make the long "(?, ?, ?)..." string
            $rowPlaces = '(' . implode(', ', array_fill(0, count($colNames), '?')) . ')';
            $allPlaces = implode(', ', array_fill(0, count($order_items), $rowPlaces));

            $sql = "INSERT INTO order_item (" . implode(', ', $colNames) . 
                ") VALUES " . $allPlaces;

            // and then the PHP PDO boilerplate
            $stmt = $this->DB::$connection->prepare($sql);

            $stmt->execute($dataToInsert);

        $this->DB::$connection->commit();
    }
}