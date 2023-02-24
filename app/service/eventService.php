<?php
require_once __DIR__ . '/../DAL/EventDAO.php';

class EventService {
    public function getAllEvents() {
        $dao = new EventDAO();
        $dao->getAllEvent();
    }

    public function addEvent($id, $event_id, $name, $description, $location, $venue, $cousine, $seats) {
        $dao = new EventDAO();
        $dao->addEvent($id, $event_id, $name, $description, $location, $venue, $cousine, $seats);
    }

    public function deleteEvent($id) {
        $dao = new EventDAO();
        $dao->deleteEvent($id);
    }

    public function updateEvent($name, $description, $location, $venue, $cousine, $seats) {
        $dao = new EventDAO();
        $dao->updateEvent($name, $description, $location, $venue, $cousine, $seats);
    }
       
    }



  

?>