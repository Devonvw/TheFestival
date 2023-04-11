<?php
class EventItemSlot {
  public $id;
  public $event_item_id;
  public $start;
  public $end;
  public $capacity;
  public $stock;



  function __construct($id = null, $event_item_id = null, $start = null, $end = null, $capacity = null, $stock = null) {
    if(!is_null($id)) {
      $this->id = $id;
      $this->event_item_id = $event_item_id;
      $this->start = $start;
      $this->end = $end;
      $this->capacity = $capacity;
      $this->stock = $stock;
    }
  }

}
