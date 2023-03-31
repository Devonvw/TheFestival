<?php
require_once __DIR__ . '/../DAL/EventDAO.php';

class EventService
{
    public function getMainEvents()
    {
        $dao = new EventDAO();
        return $dao->getMainEvents();
    }

    public function addMainEvent($name, $description)
    {
        $dao = new EventDAO();
        $dao->addMainEvent($name, $description);
    }
    public function updateMainEvent($id, $name, $description)
    {
        $dao = new EventDAO();
        $dao->updateMainEvent($id, $name, $description);
    }

    public function deleteMainEvent()
    {
        $dao = new EventDAO();
        $dao->deleteMainEvent();
    }
    public function addEventItem($event_id, $name, $description, $location, $venue, $cousine, $image)
    {
        $dao = new EventDAO();
        $dao->addEventItem($event_id, $name, $description, $location, $venue, $cousine, $image);
    }

    public function updateEventItem($id, $event_id, $name, $description, $location, $venue, $cousine, $image)
    {
        $dao = new EventDAO();
        $dao->updateEventItem($id, $event_id, $name, $description, $location, $venue, $cousine, $image);
    }
    public function updateEventItemSlot($id, $start, $end, $stock, $capacity)
    {
        $dao = new EventDAO();
        $dao->updateEventItemSlot($id, $start, $end, $stock, $capacity);
    }
    

    public function getEventItem($id)
    {
        $dao = new EventDAO();
        return $dao->getEventItem($id);
    }

    public function getEventItems($id)
    {
        $dao = new EventDAO();
        return $dao->getEventItems($id);
    }
    public function getEventItemTickets()
    {
        $dao = new EventDAO();
        return $dao->getEventItemTickets();
    }
    public function getEventItemSlots()
    {
        $dao = new EventDAO();
        return $dao->getEventItemSlots();
    }
    public function getEventItemSlotById($id)
    {
        $dao = new EventDAO();
        return $dao->getEventItemSlotById($id);
    }
    public function deleteEventItem($id)
    {
        $dao = new EventDAO();
        $dao->deleteEventItem($id);
    }
}
