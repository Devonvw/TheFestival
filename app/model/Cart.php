<?php

class Cart {
  public $id;
  public $account_id;
  public $session_id;
  public $share_token;
  public $cart_items;
  public $total;
  public $subtotal;
  public $vat;
  public $created_at;
  public $modified_at;

  function __construct($id = null, $account_id = null, $session_id = null, $created_at = null, $modified_at = null) {
    if(!is_null($id) && !is_null($account_id) && !is_null($session_id) && !is_null($created_at) && !is_null($modified_at)) {
      $this->id = $id;
      $this->account_id = $account_id;
      $this->session_id = $session_id;
      $this->created_at = $created_at;
      $this->modified_at = $modified_at;
    }
  }
}
?>