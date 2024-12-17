<?php
require '../db.php';
require '../controller/ParticipantController.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $name = $data['name'];
    $email = $data['email'];
    $event_id = $data['event_id'];

    // Validate inputs
    if (empty($name) || empty($email) || empty($event_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
        exit;
    }

    try {
        $participantController = new ParticipantController($conn);
        $result = $participantController->createParticipant($name, $email, '123456789', $event_id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Participant added successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add participant. Event may not exist.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
