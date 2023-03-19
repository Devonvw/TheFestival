<?php

class Order {
  public $id;
  public $account_id;
  public $session_id;
  public $order_items;
  public $total;
  public $subtotal;
  public $vat;
  public $payment_account_info;
  public $created_at;

  function __construct($id = null, $account_id = null, $session_id = null, $total = null, $payment_account_info = null, $created_at = null) {
    if(!is_null($id) && !is_null($account_id) && !is_null($session_id) && !is_null($created_at)) {
      $this->id = $id;
      $this->account_id = $account_id;
      $this->session_id = $session_id;
      $this->created_at = $created_at;
      $this->total = $total;
      $this->payment_account_info = $payment_account_info;
    }
  }
}
?>