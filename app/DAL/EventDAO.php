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
  //retrieving event items based on event id
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
  //retrieving event item based on event item id
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
  //get main events
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
  //get event tickets filtering in backend
  function getEventItemTickets($artistFilter = '', $priceFilter = '', $startDateFilter = '', $endDateFilter = '', $searchFilter = '')
  {
    //prepare the base query to select data from multiple tables using JOINs
    $query = "SELECT 
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
      JOIN event e ON e.id = ei.event_id
      WHERE 1";

    //initialize an array to store query parameters
    $params = [];

    //if artistFilter is set, add a condition to the query and add the parameter to the array
    if ($artistFilter) {
      $query .= " AND ei.name = :artistFilter";
      $params['artistFilter'] = $artistFilter;
    }

    //if priceFilter is set, add a condition to the query and add the parameter to the array
    if ($priceFilter) {
      $query .= " AND eist.price <= :priceFilter";
      $params['priceFilter'] = $priceFilter;
    }

    //if startDateFilter is set, add a condition to the query and add the parameter to the array
    if ($startDateFilter) {
      $query .= " AND eis.start >= :startDateFilter";
      $params['startDateFilter'] = $startDateFilter;
    }

    // If endDateFilter is set, add a condition to the query and add the parameter to the array
    if ($endDateFilter) {
      $query .= " AND eis.start <= :endDateFilter";
      $params['endDateFilter'] = $endDateFilter;
    }

    //if searchFilter is set, add a condition to the query and add the parameter to the array
    if ($searchFilter) {
      $query .= " AND ei.name LIKE :searchFilter";
      $params['searchFilter'] = '%' . $searchFilter . '%';
    }

    //prepare the statement and execute it with the provided parameters
    $stmt = $this->DB::$connection->prepare($query);
    $stmt->execute($params);

    //fetch all records and store them in an associative array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //initialize an empty array to store Ticket objects
    $tickets = [];

    //iterate through the fetched data and create Ticket objects
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

    //returning the array of Ticket objects
    return $tickets;
  }

  //getting event item tickets based on event item id
  function getEventItemTicketById($id)
  {
    $stmt = $this->DB::$connection->prepare("SELECT * FROM event_item_slot_ticket WHERE id = :id LIMIT 1");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    return $ticket;
  }

  function getEventItemSlots($filters = [])
  {
    $query = "SELECT event_item_slot.id as slotId, event.name as eventName, event_item.name as eventItemName, event_item_slot.start, event_item_slot.end, event_item_slot.stock, event_item_slot.capacity FROM event_item_slot INNER JOIN event_item ON event_item.id = event_item_slot.event_item_id INNER JOIN event ON event.id = event_item.event_id";

    $conditions = [];
    $params = [];

    if (!empty($filters['event_name'])) {
      $conditions[] = "event.name = :event_name";
      $params[':event_name'] = $filters['event_name'];
    }

    if (!empty($filters['start_date'])) {
      $conditions[] = "event_item_slot.start >= :start_date";
      $params[':start_date'] = $filters['start_date'];
    }

    if (!empty($filters['end_date'])) {
      $conditions[] = "event_item_slot.end <= :end_date";
      $params[':end_date'] = $filters['end_date'];
    }

    if (!empty($filters['search'])) {
      $conditions[] = "(event.name LIKE :search OR event_item.name LIKE :search)";
      $params[':search'] = '%' . $filters['search'] . '%';
    }

    if (!empty($filters['stock']) && $filters['stock'] === 'sold_out') {
      $conditions[] = "event_item_slot.stock = 0";
    }

    if (!empty($conditions)) {
      $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $this->DB::$connection->prepare($query);
    $stmt->execute($params);
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
  //getting event item slots based on 
  function getEventItemSlotById($id)
  {
    $stmt = $this->DB::$connection->prepare("SELECT * FROM event_item_slot WHERE id = :id LIMIT 1");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $slot = $stmt->fetch(PDO::FETCH_ASSOC);

    return $slot;
  }
  //getting event item slots based on event item id
  public function getEventItemSlotByEventItemId($eventItemId)
  {
    $stmt = $this->DB::$connection->prepare("SELECT * FROM event_item_slot WHERE event_item_id = :eventItemId");
    $stmt->bindValue(':eventItemId', $eventItemId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  //adding event item
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

  function updateEventItem($id, $name, $description, $location, $venue, $cousine, $image)
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

    $update_stmt = $this->DB::$connection->prepare("UPDATE name = :name, description = :description, location = :location, venue = :venue, cousine = :cousine, capacity = :capacity WHERE id = :id");

    $name_param = trim(htmlspecialchars($name));
    $description_param = trim(htmlspecialchars($description));
    $location_param = trim(htmlspecialchars($location));
    $venue_param = trim(htmlspecialchars($venue));
    $cousine_param = trim(htmlspecialchars($cousine));

    $update_stmt->bindValue(':id', $id, PDO::PARAM_INT);
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
  function deleteEventItemSlot($id)
  {
    // Delete the event item from the table
    $del_stmt = $this->DB::$connection->prepare("DELETE FROM event_item_slot WHERE id = :id");
    $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
    if ($del_stmt->execute()) {
      return true;
    } else {
      throw new Exception("Error: Could not delete event item slot.");
    }
  }
  function deleteEventItemSlotTicket($id)
  {
    // Delete the event item from the table
    $del_stmt = $this->DB::$connection->prepare("DELETE FROM event_item_slot_ticket WHERE id = :id");
    $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
    if ($del_stmt->execute()) {
      return true;
    } else {
      throw new Exception("Error: Could not delete event item slot ticket.");
    }
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
    $update_stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
    $update_stmt->bindValue(':capacity', $capacity, PDO::PARAM_INT);

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
    $update_stmt->bindValue(':price', $price, PDO::PARAM_STR);
    $update_stmt->bindValue(':persons', $persons, PDO::PARAM_INT);

    $update_stmt->execute();
  }

  public function addEventItemTicket($eventItemSlotId, $price, $persons)
  {
    if ($price < 0) {
      throw new Exception("Price can't be negative", 1);
    }
    if ($persons <= 0) {
      throw new Exception("The number of persons should be greater than 0", 1);
    }

    try {
      $stmt = $this->DB::$connection->prepare("INSERT INTO event_item_slot_ticket (event_item_slot_id, persons, price) VALUES (:eventItemSlotId, :persons, :price)");
      $stmt->bindValue(':eventItemSlotId', $eventItemSlotId, PDO::PARAM_INT);
      $stmt->bindParam(':price', $price, PDO::PARAM_STR);
      $stmt->bindParam(':persons', $persons, PDO::PARAM_INT);

      $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("Error adding event item slot ticket: " . $e->getMessage());
    }
  }
  public function addEventItemSlot($eventItemId, $start, $end, $capacity, $stock)
  {
    $start_date = new DateTime($start);
    $end_date = new DateTime($end);

    if ($start_date > $end_date) {
      throw new Exception("Start date has to be before end date", 1);
    }
    if ($stock > $capacity) {
      throw new Exception("The stock can't be higher than the capacity", 1);
    }
    if ($stock <= 0) {
      throw new Exception("The stock must be greater than 0", 1);
    }
    if ($capacity <= 0) {
      throw new Exception("The capacity must be greater than 0", 1);
    }

    try {
      $stmt = $this->DB::$connection->prepare("INSERT INTO event_item_slot (event_item_id, start, end, capacity, stock) VALUES (:eventItemId, :start, :end, :capacity, :stock)");
      $stmt->bindValue(':eventItemId', $eventItemId, PDO::PARAM_INT);
      $stmt->bindValue(':start', trim(htmlspecialchars($start)));
      $stmt->bindValue(':end', trim(htmlspecialchars($end)));
      $stmt->bindValue(':capacity', $capacity, PDO::PARAM_INT);
      $stmt->bindValue(':stock', $stock, PDO::PARAM_INT);

      $stmt->execute();
    } catch (PDOException $e) {
      throw new Exception("Error adding event item slot: " . $e->getMessage());
    }
  }
}
