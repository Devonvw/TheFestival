<?php
class EventItem {
  public $id;
  public $event_id;
  public $name;
  public $description;
  public $location;
  public $venue;
  public $cousine;
  public $capacity;
  public $image;



  function __construct($id = null, $event_id = null, $name = null, $description = null, $location = null, $venue = null, $cousine = null, $capacity = null, $image = null) {
    if(!is_null($id)) {
      $this->id = $id;
      $this->event_id = $event_id;
      $this->name = $name;
      $this->description = $description;
      $this->location = $location;
      $this->venue = $venue;
      $this->cousine = $cousine;
      $this->capacity = $capacity;
      $this->image = $image;


   }
  }

  public function set($name, $value) {}
}
?>