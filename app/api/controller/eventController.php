<?php
require __DIR__ . '/../../service/eventService.php';

class APIEventController
{
    private $eventService;

    // initialize services
    function __construct()
    {
        $this->eventService = new EventService();
    }

  
    public function getAllEvents()
    {
        try {
            session_start();
            echo json_encode($this->eventService->getAllEvents());
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function addEvent()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->eventService->addEvent($body["id"], $body["event_id"], $body["name"], $body["description"], $body["location"], $body["venue"], $body["cousine"], $body["seats"]);
            
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function deleteEvent($id)
    {
        try {
            
            $this->eventService->deleteEvent($id);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function updateEvent()
    {
        try {
           

            $this->eventService->updateEvent($_POST["name"], $_POST["description"], $_POST["location"], $_POST["venue"], $_POST["cousine"], $_POST["seats"]);
           
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
  


}