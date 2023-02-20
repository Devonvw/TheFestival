<?php

class Account {
  public $id;
  public $first_name;
  public $last_name;
  public $email;
  public $type_id;
  public $type_name;
  public $password;
  public $active;
  public $created_at;
  public $profile_picture;

  function __construct($id = null, $first_name = null, $last_name = null, $email = null, $type_id = null, $type_name = null, $password = null, $active = null, $created_at = null, $profile_picture = null) {
    if(!is_null($id) && !is_null($email) && !is_null($first_name) && !is_null($last_name) && !is_null($type_id) && !is_null($profile_picture)) {
      $this->id = $id;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->email = $email;
      $this->type_id = $type_id;
      $this->type_name = $type_name;
      $this->password = $password;
      $this->active = $active;
      $this->created_at = $created_at;
      $this->profile_picture = $profile_picture;
    }
  }

  public function __set($name, $value) {}
}
?>