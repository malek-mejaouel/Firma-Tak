<?php
require '../db.php';
require '../controller/EventController.php';
require '../controller/ParticipantController.php';

$controller = new EventController($conn);
$participantController = new ParticipantController($conn);
$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$participantName = isset($_GET['participant_name']) ? trim($_GET['participant_name']) : '';
if ($eventId > 0) {
    $eventQuery = "SELECT * FROM events WHERE id = ?";
    $eventStmt = $conn->prepare($eventQuery);
    $eventStmt->execute([$eventId]);
    $event = $eventStmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Invalid Event ID.";
    exit();
}

if ($eventId > 0 && !empty($participantName)) {
    $query = "SELECT * FROM participant WHERE event_id = :event_id AND name = :name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
    $stmt->bindParam(':name', $participantName, PDO::PARAM_STR);
    $stmt->execute();
    $participant = $stmt->fetch(PDO::FETCH_ASSOC);
    $participantQuery = "SELECT * FROM participant WHERE event_id = ?";
    $participantStmt = $conn->prepare($participantQuery);
    $participantStmt->execute([$eventId]);
    $participants = $participantStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($participant) {
        // Show event details and rating form
        echo "Welcome, " . htmlspecialchars($participantName) . "!";
        // Include rating form and event details here
    } else {
        echo "Participant not found for this event.";
    }
} else {
    echo "Invalid event or participant details.";
}
$ratingQuery = "SELECT AVG(rating) AS average_rating FROM event_ratings WHERE event_id = ?";
$ratingStmt = $conn->prepare($ratingQuery);
$ratingStmt->execute([$eventId]);
$averageRating = $ratingStmt->fetchColumn();
$averageRating = $averageRating ?: 0.0; // Default to 0.0 if no ratings



?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="../assets/style.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo htmlspecialchars($event['title']); ?> - Event Details</title>
</head>
<body>
<h2><?php echo htmlspecialchars($event['title'] ?? 'Event Not Found'); ?></h2>
<p>Date: <?php echo htmlspecialchars($event['event_date'] ?? 'N/A'); ?></p>
<p>Description: <?php echo htmlspecialchars($event['description'] ?? 'N/A'); ?></p>
<p>Average Rating: <?php echo number_format($averageRating, 1); ?> / 5</p>

<h3>Participants:</h3>
<ul>
    <?php if (!empty($participants)): ?>
        <?php foreach ($participants as $participant): ?>
            <li><?php echo htmlspecialchars($participant['name']); ?> (<?php echo htmlspecialchars($participant['email']); ?>)</li>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No participants found.</p>
    <?php endif; ?>
</ul>
<?php if (!empty($participant)): ?>
    <a href="ratingevent.php?event_id=<?php echo $eventId; ?>&participant_id=<?php echo $participant['id']; ?>"class="at">Rate This Event</a>

<?php else: ?>
    <p>Please log in or ensure your participation to rate this event.</p>
<?php endif; ?>


</body>
</html>
