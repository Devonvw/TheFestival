<?php
class Event {
  public $id;
  public $event_id;
  public $name;
  public $description;
  public $location;
  public $venue;
  public $cousine;
  public $seats;



  function construct($id = null, $event_id = null, $name = null, $description = null, $location = null, $venue = null, $cousine = null, $seats = null,) {
    if(!is_null($id) && !is_null($event_id) && !is_null($name) && !is_null($description) && !is_null($location) && !is_null($venue) && !is_null($cousine) && !is_null($seats)) {
      $this->id = $id;
      $this->event_id = $event_id;
      $this->name = $name;
      $this->description = $description;
      $this->location = $location;
      $this->venue = $venue;
      $this->cousine = $cousine;
      $this->seats = $seats;


    }
  }

  public function set($name, $value) {}
}
?>