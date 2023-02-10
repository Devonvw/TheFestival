<?php
class InformationPage {
  public $id;
  public $title;
  public $description;
  public $sections;

  function __construct($id = null, $title = null, $description = null, $sections = null) {
    if(!is_null($id) && !is_null($title) && !is_null($description)) {
      $this->id = $id;
      $this->title = $title;
      $this->description = $description;
      $this->sections = $sections;
    }
  }

  public function __set($name, $value) {}
}
?>