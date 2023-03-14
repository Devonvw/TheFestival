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

    public function addEventItem()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
    
            $this->eventService->addEventItem($body["event_id"], $body["name"], $body["description"], $body["location"], $body["venue"], $body["cousine"], $body["seats"]);
            json_encode([ 'msg' => "Event item succesfully added." ]);

        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    
    public function addEvent()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);
    
            $this->eventService->addEvent($body["id"], $body["e_name"], $body["e_description"]);
            json_encode([ 'msg' => "Event succesfully added." ]);

        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function deleteEvent($id)
    {
        try {
            
            $this->eventService->deleteEvent($id);
            echo json_encode([ 'msg' => "Event item succesfully deleted." ]);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function updateEvent($id)
    {
        try {
           
            $this->eventService->updateEvent($id, $_POST["name"], $_POST["description"], $_POST["location"], $_POST["venue"], $_POST["cousine"], $_POST["seats"]);
            echo json_encode([ 'msg' => "Event succesfully updated." ]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
  


}
?>