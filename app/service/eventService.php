<?php
require_once __DIR__ . '/../DAL/EventDAO.php';

class EventService {
    public function getAllEvents() {
        $dao = new EventDAO();
       return $dao->getAllEvent();
    }

    public function addEvent($name, $description) {
        $dao = new EventDAO();
        $dao->addEvent($name, $description);
    }

    
    public function addEventItem($event_id, $name, $description, $location, $venue, $cousine, $seats) {
        $dao = new EventDAO();
        $dao->addEventItem($event_id, $name, $description, $location, $venue, $cousine, $seats);
    }

    public function deleteEvent($id) {
        $dao = new EventDAO();
        $dao->deleteEvent($id);
    }

    public function updateEvent($id, $name, $description, $location, $venue, $cousine, $seats) {
        $dao = new EventDAO();
        $dao->updateEvent($id, $name, $description, $location, $venue, $cousine, $seats);
    }
       
    }

?>