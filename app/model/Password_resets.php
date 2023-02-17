<?php

class Password_resets {
  public $id;
  public $email;
  public $token;
  public $expiration;

  function __construct($id = null, $token = null, $expiration = null, $email = null) {
    if(!is_null($id) && !is_null($email) && !is_null($token) && !is_null($expiration)) {
      $this->id = $id;
      $this->email = $email;
      $this->expiration = $expiration;
      $this->token = $token;
    }
  }
}
?>