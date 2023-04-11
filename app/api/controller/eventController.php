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
            echo json_encode(['msg' => "Event item slot successfully updated."]);

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
    public function getEventItemTicketById($id)
    {
        try {
            echo json_encode($this->eventService->getEventItemTicketById($id));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function getEventItemSlotByEventItemId($id)
    {
        try {
            echo json_encode($this->eventService->getEventItemSlotByEventItemId($id));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function getEventItemSlotsByEventItemId($id)
    {
        try {
            echo json_encode($this->eventService->getEventItemSlotsByEventItemId($id));
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }


    public function editEventItemTicket($id)
    {
        try {
            $this->eventService->updateEventItemTicket($id, $_POST["price"], $_POST["persons"]);
            echo json_encode(['msg' => "Event item ticket successfully updated."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function addEventItemTicket()
    {
        try {
            $this->eventService->addEventItemTicket($_POST['eventItemSlotId'], $_POST["price"], $_POST["persons"]);
            echo json_encode(['msg' => "Event item ticket successfully added."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function addEventItemSlot()
    {
        try {
            $this->eventService->addEventItemSlot($_POST['eventItemId'], $_POST["start"], $_POST["end"], $_POST["capacity"], $_POST["stock"]);
            echo json_encode(['msg' => "Event item ticket successfully added."]);
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
    public function deleteEventItemSlot($id)
    {
        try {
            $this->eventService->deleteEventItemSlot($id);
            echo json_encode(['msg' => "Event item slot successfully deleted."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
    public function deleteEventItemSlotTicket($id)
    {
        try {
            $this->eventService->deleteEventItemSlotTicket($id);
            echo json_encode(['msg' => "Event item slot ticket successfully deleted."]);
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}
