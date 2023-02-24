<?php 
require __DIR__ . '/../model/Event.php';
require_once __DIR__ . '/../DAL/Database.php';

    class EventDAO {
       public $DB;

       function __construct() {
         $this->DB = new DB();
       }

       function getAllEvent() {
          $stmt = $this->DB::$connection->prepare("SELECT event_item.*, event.* FROM event_item LEFT JOIN event on event.id = event_id;");

          $stmt->execute();
         // $event = $stmt->fetchAll(PDO::FETCH_ASSOC, 'Event');

         $post_arr = array();
          
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
           // $event = new Event($row['id'], $row['event_id'], $row['name'], $row['description'], $row['location'], $row['venue'], $row['cousine'], $row['seats']);
           extract($row);

           $post_item = array(
             'id' => $id,
             'event_id' => $event_id,
             'name' => $name,
             'description' => html_entity_decode($description),
             'location' => $location,
             'venue' => $venue,
             'cousine' => $cousine,
             'seats' => $seats,
           );

           array_push($post_arr, $post_item);
          }
          
          echo json_encode($post_arr);
        
          return $row;
        }

        function AddEvent($id, $event_id, $name, $description, $location, $venue, $cousine, $seats){
          $stmt = $this->DB::$connection->prepare("INSERT INTO event_item (id, event_id, name, description, location, venue, cousine, seats) VALUES (:id, :event_id, :name, :description, :location, :venue, :cousine, :seats)");
        

            $id_param = trim(htmlspecialchars($id));
            $event_id_param = trim(htmlspecialchars($event_id));
            $name_param = trim(htmlspecialchars($name));
            $description_param = trim(htmlspecialchars($description));
            $location_param = trim(htmlspecialchars($location));
            $venue_param = trim(htmlspecialchars($venue));
            $cousine_param = trim(htmlspecialchars($cousine));
            $seats_param = trim(htmlspecialchars($seats));

            $stmt->bindParam(':id', $id_param);
            $stmt->bindParam(':event_id', $event_id_param);
            $stmt->bindParam(':name', $name_param);
            $stmt->bindParam(':description', $description_param);
            $stmt->bindParam(':location', $location_param);
            $stmt->bindParam(':venue', $venue_param);
            $stmt->bindParam(':cousine', $cousine_param);
            $stmt->bindParam(':seats', $seats_param);

            $stmt->execute();
        }

        function deleteEvent($id) {
          //Delete all rows associated with this page
          $del_stmt = $this->DB::$connection->prepare("DELETE FROM event_item  
          WHERE event_item.id = :event_item.id");

          // DELETE event_item, event  FROM event_item  INNER JOIN event  
          // WHERE event.id= event_item.event_id
          $del_stmt->bindValue(':event_item.id', $id, PDO::PARAM_INT);
         
          $del_stmt->execute();

          $del_stmt = $this->DB::$connection->prepare("DELETE FROM event WHERE id = :id");
          $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
          $del_stmt->execute();
        }

        function updateEvent($name, $description, $location, $venue, $cousine, $seats) {

        // $stmt = $this->DB::$connection->prepare("SELECT * FROM event_item WHERE event_id = :event_id LIMIT 1");
        // $stmt->bindValue(':event_id', trim(htmlspecialchars($_SESSION['id'])), PDO::PARAM_INT);
        // $stmt->execute();
        // $event = $stmt->fetchObject("Event");

        $update_stmt = $this->DB::$connection->prepare("UPDATE event_item SET name = :name, description = :description, location = :location, venue = :venue, cousine = :cousine, seats = :seats where event_id = :event_id");
        $update_stmt->bindValue(':event_id', trim(htmlspecialchars(1)), PDO::PARAM_INT);

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
