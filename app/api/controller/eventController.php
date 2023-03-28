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

    public function getMainEvents()
    {
        try {
            echo json_encode($this->eventService->getMainEvents());
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }


    public function addMainEvent()
    {
        try {
            $body = json_decode(file_get_contents('php://input'), true);

            $this->eventService->addMainEvent($body["e_name"], $body["e_description"]);
            json_encode(['msg' => "Event succesfully added."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function deleteMainEvent()
    {
        try {

            $this->eventService->deleteMainEvent();
            echo json_encode(['msg' => "Event succesfully deleted."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function editEventItem($id)
    {
        try {
            $image = $_FILES ? ($_FILES["image"]["name"] ? $_FILES["image"] : false) : false;
            $this->eventService->updateEventItem($id, $_POST["event_id"], $_POST["name"], $_POST["description"], $_POST["location"], $_POST["venue"], $_POST["cousine"], $_POST["capacity"], $image);
            echo json_encode(['msg' => "Event item successfully updated."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function addEventItem()
    {
        try {
            $image = $_FILES ? ($_FILES["image"]["name"] ? $_FILES["image"] : false) : false;
            $this->eventService->addEventItem($_POST["event_id"], $_POST["name"], $_POST["description"], $_POST["location"], $_POST["venue"], $_POST["cousine"], $_POST["capacity"], $image);
            echo json_encode(['msg' => "Event item successfully added."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getEventItem($id)
    {
        try {
            echo json_encode($this->eventService->getEventItem($id));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }

    public function getEventItems($id)
    {
        try {
            echo json_encode($this->eventService->getEventItems($id));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function deleteEventItem($id)
    {
        try {
            $this->eventService->deleteEventItem($id);
            echo json_encode(['msg' => "Event item successfully deleted."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}
