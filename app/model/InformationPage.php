<?php
class InformationPage {
  public $id;
  public $url;
  public $title;
  public $subtitle;
  public $meta_title;
  public $meta_description;
  public $image;
  public $sections;

  function __construct($id = null, $url = null, $title = null, $subtitle = null, $meta_title = null, $meta_description = null, $image = null, $sections = null) {
    if(!is_null($id)) {
      $this->id = $id;
      $this->url = $url;
      $this->title = $title;
      $this->subtitle = $subtitle;
      $this->meta_title = $meta_title;
      $this->meta_description = $meta_description;
      $this->image = $image;
      $this->sections = $sections;
    }
  }

  public function __set($name, $value) {}
}
?>