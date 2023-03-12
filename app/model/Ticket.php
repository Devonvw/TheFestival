<?php


class Ticket {
  public $id;
  public $event_item_id;
  public $event_item_name;
  public $event_name;
  public $persons;
  public $price;

  function __construct($id = null, $event_item_id = null, $event_item_name = null, $event_name = null, $persons = null, $price = null) {
    if(!is_null($id) && !is_null($event_item_id) && !is_null($event_name) && !is_null($persons) && !is_null($price)) {
      $this->id = $id;
      $this->event_item_id = $event_item_id;
      $this->event_item_name = $event_item_name;
      $this->event_name = $event_name;
      $this->persons = $persons;
      $this->price = $price;
    }
  }
}
?>