<?php
class Event {
  public $id;
  public $name;
  public $description;



  function __construct($id = null, $name = null, $description = null) {
    if(!is_null($id)) {
      $this->id = $id;
      $this->name = $name;
      $this->description = $description;
    }
  }

}
