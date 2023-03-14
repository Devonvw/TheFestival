<?php 
require __DIR__ . '/../model/Event.php';
require_once __DIR__ . '/../DAL/Database.php';

    class EventDAO {
       public $DB;

       function __construct() {
         $this->DB = new DB();
       }

       function getAllEvent() {
        
          $stmt = $this->DB::$connection->prepare("SELECT e.id AS event_id, ei.id AS event_item_id, ei.name AS event_item_name, ei.description AS event_item_description, ei.location, ei.venue, ei.cousine, ei.seats
                                                   FROM event_item AS ei LEFT JOIN event AS e on e.id = ei.event_id;");

          $stmt->execute();
          $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $pages = [];

          foreach ($data as $row) {
            $pages[] = new Event($row['event_id'], $row['event_item_id'], $row['event_item_name'], $row['event_item_description'], $row['location'], $row['venue'], $row['cousine'], $row['seats']);
          }
          
          return $pages;
      
          
        
          

        }

        function addEvent($id, $name, $description) {
          $stmt = $this->DB::$connection->prepare("INSERT INTO event (id, name, description) VALUES (:id, :name, :description)");
          $id_param = trim(htmlspecialchars($id));
          $name_param = trim(htmlspecialchars($name));
          $description_param = trim(htmlspecialchars($description));

          $stmt->bindParam(':id', $id_param);
          $stmt->bindParam(':name', $name_param);
          $stmt->bindParam(':description', $description_param);
          
          if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Error: Could not create event.");
        }
      }

        

        function AddEventItem($event_id, $name, $description, $location, $venue, $cousine, $seats){
          $stmt = $this->DB::$connection->prepare("INSERT INTO event_item (event_id, name, description, location, venue, cousine, seats) VALUES (:event_id, :name, :description, :location, :venue, :cousine, :seats)");
 

         
            $event_id_param = trim(htmlspecialchars($event_id));
            $name_param = trim(htmlspecialchars($name));
            $description_param = trim(htmlspecialchars($description));
            $location_param = trim(htmlspecialchars($location));
            $venue_param = trim(htmlspecialchars($venue));
            $cousine_param = trim(htmlspecialchars($cousine));
            $seats_param = trim(htmlspecialchars($seats));

           
            $stmt->bindParam(':event_id', $event_id_param);
            $stmt->bindParam(':name', $name_param);
            $stmt->bindParam(':description', $description_param);
            $stmt->bindParam(':location', $location_param);
            $stmt->bindParam(':venue', $venue_param);
            $stmt->bindParam(':cousine', $cousine_param);
            $stmt->bindParam(':seats', $seats_param);
            
            if ($stmt->execute()) {
              return true;
          } else {
              throw new Exception("Error: Could not create event.");
          }
           
        }

        function deleteEvent($id) {
          //Delete all rows associated with this page
          $del_stmt = $this->DB::$connection->prepare("DELETE FROM event_item  
          WHERE id = :id");

          $del_stmt->bindValue(':id', trim(htmlspecialchars($id)), PDO::PARAM_INT);
         
          if ($del_stmt->execute()) {
            return true;
        } else {
            throw new Exception("Error: Could not create event.");
        }

          // $del_stmt = $this->DB::$connection->prepare("DELETE FROM event WHERE id = :id");
          // $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
          // $del_stmt->execute();
        }

        function updateEvent($id, $name, $description, $location, $venue, $cousine, $seats) {

        // $stmt = $this->DB::$connection->prepare("SELECT * FROM event_item WHERE event_id = :event_id LIMIT 1");
        // $stmt->bindValue(':event_id', trim(htmlspecialchars($_SESSION['id'])), PDO::PARAM_INT);
        // $stmt->execute();
        // $event = $stmt->fetchObject("Event");

        $update_stmt = $this->DB::$connection->prepare("UPDATE event_item SET name = :name, description = :description, location = :location, venue = :venue, cousine = :cousine, seats = :seats where id = :id");
        $update_stmt->bindValue(':id', trim(htmlspecialchars($id)), PDO::PARAM_INT);
        $update_stmt->bindValue(':name', trim(htmlspecialchars($name)));
        $update_stmt->bindValue(':description', trim(htmlspecialchars($description)));
        $update_stmt->bindValue(':location', trim(htmlspecialchars($location)));
        $update_stmt->bindValue(':venue', (trim(htmlspecialchars($venue))));
        $update_stmt->bindValue(':cousine', $cousine, PDO::PARAM_LOB);
        $update_stmt->bindValue(':seats', $seats, PDO::PARAM_LOB);

        $update_stmt->execute();

        }
     }
?>