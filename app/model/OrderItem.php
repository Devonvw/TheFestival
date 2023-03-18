<?php
require_once __DIR__ . '/Ticket.php';

class OrderItem {
  public $order_id;
  public Ticket $ticket;
  public $price;
  public $quantity;

  function __construct($order_id = null, $ticket = null, $price = null, $quantity = null) {
    if(!is_null($order_id) && !is_null($ticket) && !is_null($price) && !is_null($quantity)) {
      $this->order_id = $order_id;
      $this->ticket = $ticket;
      $this->price = $price;
      $this->quantity = $quantity;
    }
  }
}
?>