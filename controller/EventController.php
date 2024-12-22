<?php
require_once '../db.php'; // Adjust the path if necessary
require_once '../model/Event.php';

class EventController {
    private $model;
    private $conn;

    public function __construct($db) {
        $this->model = new Event($db);
        $this->conn = $db;
    }

    // Fetch and return all events
    public function listEvents() {
        return $this->model->getAllEvents();
    }

    // Create a new event
    public function createEvent($title, $description, $event_date, $image_path, $max_participants) {
        $query = "INSERT INTO events (title, description, event_date, image_path, max_participants) VALUES (:title, :description, :event_date, :image_path, :max_participants)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':event_date', $event_date);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':max_participants', $max_participants);
        return $stmt->execute();
    }
    
    

    // Fetch a specific event by ID
    public function viewEvent($id) {
        return $this->model->getEventById($id);
    }

    // Update an event
    public function editEvent($id, $title, $description, $event_date) {
        if ($this->model->updateEvent($id, $title, $description, $event_date)) {
            return "Event updated successfully!";
        } else {
            return "Failed to update the event.";
        }
    }

    // Delete an event
    public function deleteEvent($id) {
        if ($this->model->deleteEvent($id)) {
            return "Event deleted successfully!";
        } else {
            return "Failed to delete the event.";
        }
    }
    
}
?>
