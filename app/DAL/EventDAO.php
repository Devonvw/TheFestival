<?php
require __DIR__ . '/../model/Event.php';
require __DIR__ . '/../model/EventItem.php';
require_once __DIR__ . '/../DAL/Database.php';

class EventDAO
{
  public $DB;

  function __construct()
  {
    $this->DB = new DB();
  }

  function getEventItems($id)
  {
    $stmt = $this->DB::$connection->prepare("SELECT * FROM event_item WHERE event_id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $event_items = [];
    foreach ($data as $row) {
      if ($row['image'] && !is_null($row['image'])) {
        $row['image'] = base64_encode($row['image']);
      }
      $event_items[] = new EventItem($row['id'], $row['event_id'], $row['name'], $row['description'], $row['location'], $row['venue'], $row['cousine'], $row['capacity'], $row['image']);
    }

    return $event_items;
  }

  function getEventItem($id)
  {
    $stmt = $this->DB::$connection->prepare("SELECT * FROM event_item WHERE id = :id LIMIT 1");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $event_item = $stmt->fetchObject("EventItem");
    if ($event_item->image && !is_null($event_item->image)) {
      $image_stmt = $this->DB::$connection->prepare("SELECT image FROM event_item WHERE id = :id");
      $image_stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $image_stmt->execute();
      $image = base64_encode($image_stmt->fetch(PDO::FETCH_ASSOC)['image']);
      $event_item->image = $image;
    }
    return $event_item;
  }
  function getMainEvents()
  {
    $stmt = $this->DB::$connection->prepare("SELECT * FROM event");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $events = [];
    foreach ($data as $row) {
      $events[] = new Event($row['id'], $row['name'], $row['description']);
    }
    return $events;
  }

  function addMainEvent($name, $description)
  {
    $stmt = $this->DB::$connection->prepare("INSERT INTO event (name, description) VALUES (:name, :description)");
    $name_param = trim(htmlspecialchars($name));
    $description_param = trim(htmlspecialchars($description));

    $stmt->bindParam(':name', $name_param);
    $stmt->bindParam(':description', $description_param);

    if ($stmt->execute()) {
      return true;
    } else {
      throw new Exception("Error: Could not create event.", 1);
    }
  }



  function addEventItem($event_id, $name, $description, $location, $venue, $cousine, $capacity, $image)
  {
    if ($image && $image["size"] > 2 * 1024 * 1024) {
      throw new Exception("This image is bigger than 2MB", 1);
    }

    if ($image && !is_uploaded_file($image['tmp_name'])) throw new Exception("This is not the uploaded file", 1);

    if ($image && !is_null($image)) {
      $img_data = file_get_contents($image['tmp_name']);
    }

    $stmt = $this->DB::$connection->prepare("INSERT INTO event_item (event_id, name, description, location, venue, cousine, capacity, image) VALUES (:event_id, :name, :description, :location, :venue, :cousine, :capacity, :image)");
    $name_param = trim(htmlspecialchars($name));
    $description_param = trim(htmlspecialchars($description));
    $location_param = trim(htmlspecialchars($location));
    $venue_param = trim(htmlspecialchars($venue));
    $cousine_param = trim(htmlspecialchars($cousine));

    $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
    $stmt->bindValue(':name', $name_param);
    $stmt->bindValue(':description', $description_param);
    $stmt->bindValue(':location', $location_param);
    $stmt->bindValue(':venue', $venue_param);
    $stmt->bindValue(':cousine', $cousine_param);
    $stmt->bindValue(':capacity', $capacity, PDO::PARAM_INT);
    $stmt->bindValue(':image', $img_data);
    if ($stmt->execute()) {
      return true;
    } else {
      throw new Exception("Error: Could not add event item.", 1);
    }
  }

  function deleteMainEvent()
  {
    //Delete all rows associated with this page
    $del_stmt = $this->DB::$connection->prepare("DELETE FROM event  
          WHERE id = :id");

    $del_stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);

    if ($del_stmt->execute()) {
      return true;
    } else {
      throw new Exception("Error: Could not delete event.");
    }
  }

  function updateEventItem($id, $event_id, $name, $description, $location, $venue, $cousine, $capacity, $image)
  {
    if ($image && $image["size"] > 2 * 1024 * 1024) {
      throw new Exception("This image is bigger than 2MB", 1);
    }
    if ($image && !is_uploaded_file($image['tmp_name'])) throw new Exception("This is not the uploaded file", 1);

    if ($image && !is_null($image)) {
      $img_data = file_get_contents($image['tmp_name']);

      $stmt = $this->DB::$connection->prepare("UPDATE event_item SET image = :image where id = :id");
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->bindValue(':image', $img_data);
      $stmt->execute();
    }

    $update_stmt = $this->DB::$connection->prepare("UPDATE event_item SET event_id = :event_id, name = :name, description = :description, location = :location, venue = :venue, cousine = :cousine, capacity = :capacity WHERE id = :id");

    $name_param = trim(htmlspecialchars($name));
    $description_param = trim(htmlspecialchars($description));
    $location_param = trim(htmlspecialchars($location));
    $venue_param = trim(htmlspecialchars($venue));
    $cousine_param = trim(htmlspecialchars($cousine));

    $update_stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $update_stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
    $update_stmt->bindValue(':name', $name_param);
    $update_stmt->bindValue(':description', $description_param);
    $update_stmt->bindValue(':location', $location_param);
    $update_stmt->bindValue(':venue', $venue_param);
    $update_stmt->bindValue(':cousine', $cousine_param);
    $update_stmt->bindValue(':capacity', $capacity, PDO::PARAM_INT);
  }
  function deleteEventItem($id)
  {
    // Delete the event item from the table
    $del_stmt = $this->DB::$connection->prepare("DELETE FROM event_item WHERE id = :id");
    $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
    if ($del_stmt->execute()) {
      return true;
    } else {
      throw new Exception("Error: Could not delete event item.");
    }
  }

  function updateMainEvent($name, $description)
  {

    $update_stmt = $this->DB::$connection->prepare("UPDATE event_item SET name = :name, description = :description where id = :id");

    $update_stmt->bindValue(':name', trim(htmlspecialchars($name)));
    $update_stmt->bindValue(':description', trim(htmlspecialchars($description)));

    $update_stmt->execute();
  }
}
