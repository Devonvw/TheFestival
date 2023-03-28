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

    public function deleteMainEvent()
    {
        $dao = new EventDAO();
        $dao->deleteMainEvent();
    }
    public function addEventItem($event_id, $name, $description, $location, $venue, $cousine, $capacity, $image)
    {
        $dao = new EventDAO();
        $dao->addEventItem($event_id, $name, $description, $location, $venue, $cousine, $capacity, $image);
    }

    public function updateEventItem($id, $event_id, $name, $description, $location, $venue, $cousine, $capacity, $image)
    {
        $dao = new EventDAO();
        $dao->updateEventItem($id, $event_id, $name, $description, $location, $venue, $cousine, $capacity, $image);
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

    public function deleteEventItem($id)
    {
        $dao = new EventDAO();
        $dao->deleteEventItem($id);
    }
}
