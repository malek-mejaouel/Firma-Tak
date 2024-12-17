<?php
require_once '../db.php';
require_once '../model/Participant.php';

class ParticipantController {
    private $model;

    public function __construct($db) {
        $this->model = new Participant($db);
    }

    public function listParticipants() {
        return $this->model->getAllParticipants();
    }

    public function createParticipant($name, $email, $phone, $event_id) {
        return $this->model->createParticipant($name, $email, $phone, $event_id);
    }

    public function viewParticipant($id) {
        return $this->model->getParticipantById($id);
    }

    public function deleteParticipant($id) {
        return $this->model->deleteParticipant($id);
    }

    public function getParticipantById($id) {
        return $this->model->getParticipantById($id);
    }
    public function listParticipantsByEvent($eventId) {
        $stmt = $this->model->getParticipantsByEvent($eventId); // Adjust according to your model function
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
