<?php
require_once __DIR__ . '/../DAL/EventDAO.php';

class EventService
{
    public function getMainEvents()
    {
        $dao = new EventDAO();
        return $dao->getMainEvents();
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
    public function updateEventItemTicket($id, $price, $persons)
    {
        $dao = new EventDAO();
        $dao->updateEventItemTicket($id, $price, $persons);
    }
    public function addEventItemTicket($id, $price, $persons)
    {
        $dao = new EventDAO();
        $dao->addEventItemTicket($id, $price, $persons);
    }
    public function addEventItemSlot($id, $start, $end, $capacity, $stock)
    {
        $dao = new EventDAO();
        $dao->addEventItemSlot($id, $start, $end, $capacity, $stock);
    }
    public function getEventItemSlotByEventItemId($eventItemId)
    {
        $dao = new EventDAO();
        return $dao->getEventItem($eventItemId);
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
    public function getEventItemTicketById($id)
    {
        $dao = new EventDAO();
        return $dao->getEventItemTicketById($id);
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
    public function getEventItemSlotsByEventItemId($id)
    {
        $dao = new EventDAO();
        return $dao->getEventItemSlotByEventItemId($id);
    }
    public function deleteEventItem($id)
    {
        $dao = new EventDAO();
        $dao->deleteEventItem($id);
    }
    public function deleteEventItemSlot($id)
    {
        $dao = new EventDAO();
        $dao->deleteEventItemSlot($id);
    }
    public function deleteEventItemSlotTicket($id)
    {
        $dao = new EventDAO();
        $dao->deleteEventItemSlotTicket($id);
    }
}
