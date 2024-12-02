<?php
require '../db.php';
require '../controllers/ParticipantController.php';

if (isset($_GET['id'])) {
    $participantId = intval($_GET['id']);
    $controller = new ParticipantController($conn);

    if ($controller->deleteParticipant($participantId)) {
        header("Location: listback.php");
        exit;
    } else {
        echo "Failed to delete participant.";
    }
}
?>
