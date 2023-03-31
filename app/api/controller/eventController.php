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
            $image = $_FILES ? ($_FILES["image"]["name"] ? $_FILES["image"] : false) : false;
            $this->eventService->addMainEvent($_POST["name"], $image);
            json_encode(['msg' => "Event succesfully added."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function editMainEvent($id)
    {
        try {
            $image = $_FILES ? ($_FILES["image"]["name"] ? $_FILES["image"] : false) : false;
            $this->eventService->updateMainEvent($id, $_POST["name"], $image);
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
            $this->eventService->updateEventItem($id, $_POST["event_id"], $_POST["name"], $_POST["description"], $_POST["location"], $_POST["venue"], $_POST["cousine"], $image);
            echo json_encode(['msg' => "Event item successfully updated."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function editEventItemSlot($id)
    {
        try {
            $this->eventService->updateEventItemSlot($id, $_POST["start"], $_POST["end"], $_POST["stock"], $_POST["capacity"]);
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
            $this->eventService->addEventItem($_POST["event_id"], $_POST["name"], $_POST["description"], $_POST["location"], $_POST["venue"], $_POST["cousine"], $image);
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
    public function getEventItemTickets()
    {
        try {
            echo json_encode($this->eventService->getEventItemTickets());
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function getEventItemSlots()
    {
        try {
            echo json_encode($this->eventService->getEventItemSlots());
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function getEventItemSlotById($id)
    {
        try {
            echo json_encode($this->eventService->getEventItemSlotById($id));
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
