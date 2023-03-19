<?php
require_once __DIR__ . '/../model/Cart.php';
require_once __DIR__ . '/../model/CartItem.php';
require_once __DIR__ . '/../model/Ticket.php';

class cartDAO
{
    public $DB;

    function __construct()
    {
        $this->DB = new DB();
    }
    private function cartExist()
    {
        $cart = $this->getCart();
        if (!$cart) {
            $this->createCart();
        }
        return true;
    }

    public function createCart($account_id = null, $session_id = null)
    {
        if ($account_id !== null) {
            $stmt = $this->DB::$connection->prepare("INSERT INTO cart (account_id) VALUES (:account_id)");
            $stmt->bindValue(':account_id', $account_id, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->DB::$connection->prepare("INSERT INTO cart (session_id) VALUES (:session_id)");

            $stmt->bindValue(':session_id', $session_id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function addToCart($ticket_id, $account_id = null, $session_id = null)
    {
        $cart = $this->getCart($account_id, $session_id);

        //Handle cart quantity
        $sql = "INSERT INTO cart_item (ticket_id, cart_id) VALUES (:ticket_id, :cart_id) ON DUPLICATE KEY UPDATE quantity = quantity + 1";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $stmt->bindValue(':cart_id', $cart->id, PDO::PARAM_INT);
        $stmt->execute();

        //update modified_at value
        $modified_at = date('Y-m-d H:i:s');
        $sql = "UPDATE cart SET modified_at = :modified_at WHERE id = :cart_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':modified_at', $modified_at);
        $stmt->bindParam(':cart_id', $cart->id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public function removeFromCart($ticket_id, $account_id = null, $session_id = null)
    {
        $cart = $this->getCart($account_id, $session_id);

        $sql = "SELECT * FROM cart_item WHERE ticket_id = :ticket_id AND cart_id = :cart_id LIMIT 1";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindValue(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $stmt->bindValue(':cart_id', $cart->id, PDO::PARAM_INT);
        $stmt->execute();
        $cartItem = $stmt->fetchObject();

        if ($cartItem->quantity == 1) {
            $sql = "DELETE FROM cart_item WHERE id = :cart_item_id";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindParam(':cart_item_id', $cartItem->id, PDO::PARAM_INT);
            $stmt->execute();
        }
        else {
            $sql = "UPDATE cart_item SET quantity = quantity - 1 WHERE id = :cart_item_id";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindParam(':cart_item_id', $cartItem->id, PDO::PARAM_INT);
            $stmt->execute();
        }
        

        //update modified_at value
        $modified_at = date('Y-m-d H:i:s');
        $sql = "UPDATE cart SET modified_at = :modified_at WHERE id = :cart_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':modified_at', $modified_at);
        $stmt->bindParam(':cart_id', $cart->id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function clearCart($account_id = null, $session_id = null)
    {
        $cart = $this->getCart($account_id, $session_id);

        $sql = "DELETE FROM cart_item WHERE cart_id = :cart_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':cart_id', $cart->id, PDO::PARAM_INT);
        $stmt->execute();

        //update modified_at value
        $modified_at = date('Y-m-d H:i:s');
        $sql = "UPDATE cart SET modified_at = :modified_at WHERE id = :cart_id";
        $stmt = $this->DB::$connection->prepare($sql);
        $stmt->bindParam(':modified_at', $modified_at);
        $stmt->bindParam(':cart_id', $cart->id, PDO::PARAM_INT);
        $stmt->execute();
    }

public function getCart($account_id = null, $session_id = null)
    {
        $cart = null;

        if ($account_id !== null) {
            $sql = "SELECT * FROM cart WHERE account_id = :account_id LIMIT 1";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindValue(':account_id', $account_id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
            $cart = $stmt->fetch();
        } else {
            $sql = "SELECT * FROM cart WHERE session_id = :session_id LIMIT 1";
            $stmt = $this->DB::$connection->prepare($sql);
            $stmt->bindValue(':session_id', $session_id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
            $cart = $stmt->fetch();
        }

        //Create cart if it doesnt exist yet
        if (!$cart) {
            $this->createCart($account_id, $session_id);

            if ($account_id !== null) {
                $sql = "SELECT * FROM cart WHERE account_id = :account_id";
                $stmt = $this->DB::$connection->prepare($sql);
                $stmt->bindValue(':account_id', $account_id, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
                $cart = $stmt->fetch();
            } else {
                $sql = "SELECT * FROM cart WHERE session_id = :session_id";
                $stmt = $this->DB::$connection->prepare($sql);
                $stmt->bindValue(':session_id', $session_id, PDO::PARAM_INT);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
                $cart = $stmt->fetch();
            }
        }

        $items_stmt = $this->DB::$connection->prepare("SELECT ci.*, eis.start, eis.end, eist.price, eist.persons, eist.event_item_slot_id, ei.location, ei.name as event_item_name, e.name as event_name FROM cart INNER JOIN cart_item as ci on ci.cart_id = cart.id left join event_item_slot_ticket as eist on ci.ticket_id = eist.id left join event_item_slot as eis on eis.id = eist.event_item_slot_id left join event_item as ei on eis.event_item_id = ei.id left join event as e on ei.event_id = e.id WHERE cart.id = :cart_id;");
        $items_stmt->bindParam(':cart_id', $cart->id, PDO::PARAM_INT);
        $items_stmt->execute();
        $items = $items_stmt->fetchAll();

        $cart_items = [];

        $total = $subtotal = $vat = 0;

        foreach ($items as $row) {
            $total += $row['price'] * $row['quantity'];
            $subtotal += ($row['price'] * $row['quantity']) / 1.21;
            $vat +=  $row['price'] * $row['quantity'] - ($row['price'] * $row['quantity']) / 1.21;
            array_push($cart_items, new CartItem($row['id'], $row['cart_id'], new Ticket($row['ticket_id'], $row['event_item_slot_id'], $row['start'], $row['end'], $row['location'], $row['event_item_name'], $row['event_name'], $row['persons'], $row['price']), $row['quantity'], $row['created_at']));
        }

        $cart->total = $total;
        $cart->subtotal = $subtotal;
        $cart->vat = $vat;
        $cart->cart_items = $cart_items;

        return $cart;
    }
}