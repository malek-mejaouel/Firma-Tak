<?php
require '../db.php'; // Ensures db.php is included for the database connection
require '../controllers/EventController.php';

// Create an instance of EventController
$controller = new EventController($conn);

// Test: List all events
$events = $controller->listEvents();

// Display the events
echo "<h1>List of Events</h1>";
foreach ($events as $event) {
    echo "Title: " . htmlspecialchars($event['title']) . "<br>";
    echo "Date: " . htmlspecialchars($event['event_date']) . "<br>";
    echo "Description: " . htmlspecialchars($event['description']) . "<br><br>";
}
?>
