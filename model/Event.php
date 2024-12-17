<?php
class Event {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    // Fetch all events
    public function getAllEvents() {
        $stmt = $this->conn->prepare("SELECT * FROM events ORDER BY event_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new event
    public function createEvent($title, $description, $event_date) {
        $stmt = $this->conn->prepare("INSERT INTO events (title, description, event_date) VALUES (:title, :description, :event_date)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':event_date', $event_date);
        return $stmt->execute();
    }

    // Fetch a single event by ID
    public function getEventById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update an existing event
    public function updateEvent($id, $title, $description, $event_date) {
        $stmt = $this->conn->prepare("UPDATE events SET title = :title, description = :description, event_date = :event_date WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':event_date', $event_date);
        return $stmt->execute();
    }

    // Delete an event
    public function deleteEvent($id) {
        // Delete participants associated with the event
        $stmt = $this->conn->prepare("DELETE FROM participant WHERE event_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        // Now delete the event
        $stmt = $this->conn->prepare("DELETE FROM events WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function searchEvents($searchQuery) {
        $query = "SELECT * FROM events WHERE title LIKE :search OR description LIKE :search";
        $stmt = $this->conn->prepare($query);
        $likeSearch = '%' . $searchQuery . '%';
        $stmt->bindParam(':search', $likeSearch, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>
