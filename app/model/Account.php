<?php

class Account {
  public $id;
  public $first_name;
  public $last_name;
  public $email;
  public $type_id;
  public $password;
  public $created_at;

  function __construct($id = null, $first_name = null, $last_name = null, $email = null, $type_id = null, $password = null, $created_at = null) {
    if(!is_null($id) && !is_null($email) && !is_null($first_name) && !is_null($last_name) && !is_null($type_id)) {
      $this->id = $id;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->email = $email;
      $this->type_id = $type_id;
      $this->password = $password;
      $this->created_at = $created_at;
    }
  }

  public function __set($name, $value) {}
}
?>