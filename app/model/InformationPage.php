<?php
class InformationPage {
  public $id;
  public $title;
  public $subtitle;
  public $meta_title;
  public $meta_description;
  public $sections;

  function __construct($id = null, $title = null, $subtitle = null, $meta_title = null, $meta_description = null, $sections = null) {
    if(!is_null($id) && !is_null($title)) {
      $this->id = $id;
      $this->title = $title;
      $this->subtitle = $subtitle;
      $this->meta_title = $meta_title;
      $this->meta_description = $meta_description;
      $this->sections = $sections;
    }
  }

  public function __set($name, $value) {}
}
?>