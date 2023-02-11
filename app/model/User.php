<?php

class User {
  public $id;
  public $username;
  public $password;
  public $email;

  function __construct($id = null, $username = null, $password = null, $email =null) {
    if(!is_null($id) && !is_null($username)) {
      $this->id = $id;
      $this->username = $username;
      $this->password = $password;
      $this->email = $email;
    }
  }

  public function __set($name, $value) {}
}
?>