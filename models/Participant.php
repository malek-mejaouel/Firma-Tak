<?php
class Participant {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all participants
    public function getAllParticipants() {
        $stmt = $this->conn->prepare("SELECT * FROM participant ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new participant
    public function createParticipant($name, $email, $phone, $event_id) {
        $stmt = $this->conn->prepare("SELECT id FROM events WHERE id = :event_id");
        $stmt->bindParam(':event_id', $event_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $stmt = $this->conn->prepare("INSERT INTO participant(name, email, phone, event_id) VALUES (:name, :email, :phone, :event_id)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':event_id', $event_id);
            return $stmt->execute();
        } else {
            return false; // Event doesn't exist
        }
    }

    // Fetch a single participant by ID
    public function getParticipantById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM participant WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update an existing participant
    public function updateParticipant($id, $name, $email, $phone, $event_id) {
        $stmt = $this->conn->prepare("UPDATE participant SET name = :name, email = :email, phone = :phone, event_id = :event_id WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':event_id', $event_id);
        return $stmt->execute();
    }

    // Delete a participant by ID
    public function deleteParticipant($id) {
        $stmt = $this->conn->prepare("DELETE FROM participant WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getParticipantsByEvent($eventId) {
        $stmt = $this->conn->prepare("SELECT * FROM participant WHERE event_id = :event_id");
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        return $stmt;
    }
    
    
}


?>
