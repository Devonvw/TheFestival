<?php
require __DIR__ . '/../model/Event.php';
require __DIR__ . '/../model/EventItem.php';
require __DIR__ . '/../model/Ticket.php';
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
      $event_items[] = new EventItem($row['id'], $row['event_id'], $row['name'], $row['description'], $row['location'], $row['venue'], $row['cousine'], $row['image']);
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
      if ($row['description'] && !is_null($row['description'])) {
        $row['description'] = base64_encode($row['description']);
      }
      $events[] = new Event($row['id'], $row['name'], $row['description']);
    }
    return $events;
  }
  function getEventItemTickets()
  {
    $stmt = $this->DB::$connection->prepare(
      "SELECT 
        eist.id, 
        eist.event_item_slot_id, 
        eis.start, 
        eis.end, 
        ei.location, 
        ei.name as event_item_name, 
        ei.image,
        e.name as event_name, 
        eist.persons, 
        eist.price
      FROM event_item_slot_ticket eist
      JOIN event_item_slot eis ON eis.id = eist.event_item_slot_id
      JOIN event_item ei ON ei.id = eis.event_item_id
      JOIN event e ON e.id = ei.event_id"
    );
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $tickets = [];
    foreach ($data as $row) {
      $tickets[] = new Ticket(
        $row['id'],
        $row['event_item_slot_id'],
        $row['start'],
        $row['end'],
        $row['location'],
        $row['event_item_name'],
        $row['image'] ? base64_encode($row['image']) : null,
        $row['event_name'],
        $row['persons'],
        $row['price']
      );
    }
    return $tickets;
  }

  function getEventItemSlots()
  {
    $stmt = $this->DB::$connection->prepare("SELECT event_item_slot.id as slotId, event.name as eventName, event_item.name as eventItemName, event_item_slot.start, event_item_slot.end, event_item_slot.stock, event_item_slot.capacity FROM event_item_slot INNER JOIN event_item ON event_item.id = event_item_slot.event_item_id INNER JOIN event ON event.id = event_item.event_id");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $eventItemSlots = [];
    foreach ($data as $row) {
      $eventItemSlots[] = array(
        'slotId' => $row['slotId'],
        'eventName' => $row['eventName'],
        'eventItemName' => $row['eventItemName'],
        'start' => $row['start'],
        'end' => $row['end'],
        'stock' => $row['stock'],
        'capacity' => $row['capacity']
      );
    }
    return $eventItemSlots;
  }
  function getEventItemSlotById($id)
  {
    $stmt = $this->DB::$connection->prepare("SELECT * FROM event_item_slot WHERE id = :id LIMIT 1");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $slot = $stmt->fetch(PDO::FETCH_ASSOC);

    return $slot;
  }
  function addMainEvent($name, $description)
  {
    if ($description && $description["size"] > 2 * 1024 * 1024) {
      throw new Exception("This image is bigger than 2MB", 1);
    }

    if ($description && !is_uploaded_file($description['tmp_name'])) throw new Exception("This is not the uploaded file", 1);

    if ($description && !is_null($description)) {
      $img_data = file_get_contents($description['tmp_name']);
      $stmt = $this->DB::$connection->prepare("INSERT INTO event (description) VALUES (:description)");

      $stmt->bindValue(':description', $img_data);
      $stmt->execute();
    }

    $stmt = $this->DB::$connection->prepare("INSERT INTO event (name) VALUES (:name)");
    $name_param = trim(htmlspecialchars($name));

    $stmt->bindValue(':name', $name_param);

    if ($stmt->execute()) {
      return true;
    } else {
      throw new Exception("Error: Could not create event.", 1);
    }
  }



  function addEventItem($event_id, $name, $description, $location, $venue, $cousine, $image)
  {
    if ($image && $image["size"] > 2 * 1024 * 1024) {
      throw new Exception("This image is bigger than 2MB", 1);
    }

    if ($image && !is_uploaded_file($image['tmp_name'])) throw new Exception("This is not the uploaded file", 1);

    if ($image && !is_null($image)) {
      $img_data = file_get_contents($image['tmp_name']);
    }

    $stmt = $this->DB::$connection->prepare("INSERT INTO event_item (event_id, name, description, location, venue, cousine, image) VALUES (:event_id, :name, :description, :location, :venue, :cousine, :image)");
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

  function updateEventItem($id, $event_id, $name, $description, $location, $venue, $cousine, $image)
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

  function updateMainEvent($id, $name, $description)
  {
    if ($description && $description["size"] > 2 * 1024 * 1024) {
      throw new Exception("This image is bigger than 2MB", 1);
    }
    if ($description && !is_uploaded_file($description['tmp_name'])) throw new Exception("This is not the uploaded file", 1);

    if ($description && !is_null($description)) {
      $img_data = file_get_contents($description['tmp_name']);

      $stmt = $this->DB::$connection->prepare("UPDATE event SET description = :description where id = :id");
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->bindValue(':description', $img_data);
      $stmt->execute();
    }
    $update_stmt = $this->DB::$connection->prepare("UPDATE event SET name = :name, description = :description where id = :id");
    $update_stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $update_stmt->bindValue(':name', trim(htmlspecialchars($name)));

    $update_stmt->execute();
  }

  function updateEventItemSlot($id, $start, $end, $stock, $capacity)
  {
    $start_date = new DateTime($start);
    $end_date = new DateTime($end);

    if ($start_date > $end_date) {
      throw new Exception("Start date has to be before end date", 1);
    }
    if ($stock > $capacity) {
      throw new Exception("The stock can't be higher than the capacity", 1);
    }


    $update_stmt = $this->DB::$connection->prepare("UPDATE event_item_slot SET start = :start, end = :end, stock = :stock, capacity = :capacity where id = :id");
    $update_stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $update_stmt->bindValue(':start', trim(htmlspecialchars($start)));
    $update_stmt->bindValue(':end', trim(htmlspecialchars($end)));
    $update_stmt->bindValue(':stock', trim(htmlspecialchars($stock)));
    $update_stmt->bindValue(':capacity', trim(htmlspecialchars($capacity)));

    $update_stmt->execute();
  }
  public function updateEventItemTicket($id, $price, $persons)
  {
    if ($price < 0) {
      throw new Exception("Price can't be negative", 1);
    }
    if ($persons <= 0) {
      throw new Exception("The number of persons should be greater than 0", 1);
    }

    $update_stmt = $this->DB::$connection->prepare("UPDATE event_item_slot_ticket SET price = :price, persons = :persons WHERE id = :id");
    $update_stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $update_stmt->bindValue(':price', trim(htmlspecialchars($price)));
    $update_stmt->bindValue(':persons', trim(htmlspecialchars($persons)));

    $update_stmt->execute();
  }
}