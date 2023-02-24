<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/eventService.php';

class EventController extends Controller
{
  private $eventService;

  // initialize services
  function __construct()
  {
    $this->eventService = new EventService();
  }
  public function eventManager()
  {
    $this->displayView("");
  }
}
?>