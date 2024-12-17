<?php
require '../db.php';
require '../controller/EventController.php';

$controller = new EventController($conn);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        $controller->deleteEvent($id);
        header('Location: listback.php');
        exit;
    } else { 
        echo "Are you sure you want to delete this event? 
              <a href='deleteEvent.php?id=$id&confirm=yes'>Yes</a>/ 
              <a href='listback.vephp'>No</a>";
    }
}
