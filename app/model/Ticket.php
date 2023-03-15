<?php


class Ticket {
  public $id;
  public $start;
  public $end;
  public $event_item_name;
  public $event_name;
  public $persons;
  public $price;

  function __construct($id = null, $start = null, $end = null, $event_item_name = null, $event_name = null, $persons = null, $price = null) {
    if(!is_null($id) && !is_null($start) && !is_null($end) && !is_null($event_name) && !is_null($persons) && !is_null($price)) {
      $this->id = $id;
      $this->start = $start;
      $this->end = $end;
      $this->event_item_name = $event_item_name;
      $this->event_name = $event_name;
      $this->persons = $persons;
      $this->price = $price;
    }
  }
}
?>