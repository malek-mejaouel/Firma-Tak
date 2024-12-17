<?php
require '../db.php';
require '../controller/EventController.php';
require '../controller/ParticipantController.php';

$controller = new EventController($conn);
$controller1 = new ParticipantController($conn);
$events = $controller->listEvents();
$participant = $controller1->listParticipants();
$message = "";

// Handle participant deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_participant_name'])) {
    $participantName = trim($_POST['delete_participant_name']);
    if (!empty($participantName)) {
        try {
            $query = "DELETE FROM participant WHERE name = :name";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $participantName);
            $stmt->execute();

            $deletedRows = $stmt->rowCount();
            if ($deletedRows > 0) {
                $message = "Participant '$participantName' deleted successfully.";
            } else {
                $message = "No participant found with the name '$participantName'.";
            }
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Please enter a valid participant name.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistics</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color:#6b7908;
        }
        .side-menu {
            position: fixed;
            width: 250px;
            height: 100%;
            background-color:#6b7908;
            color: white;
            padding: 20px;
        }
        .side-menu ul {
            padding: 0;
            list-style: none;
        }
        .side-menu ul li {
            margin: 10px 0;
        }
        .side-menu ul li a {
            color: white;
            text-decoration: none;
        }
        .side-menu ul li a:hover {
            text-decoration: underline;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .table-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .statistics {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .statistics h3 {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color:rgb(86, 117, 7);
            border: none;
        }
        .btn-primary:hover {
            background-color:rgb(54, 84, 5);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard Statistics -->
        <div class="statistics">
            <h3>Dashboard Statistics</h3>
            <p><strong>Total Events:</strong> <?php echo count($events); ?></p>
            <p><strong>Total Participants:</strong> <?php echo count($participant); ?></p>
        </div>

        <!-- Events Table -->
        <div class="delete-participant-form">
    <h3>Delete Participant</h3>
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="delete_participant_name">Enter Participant Name:</label>
            <input type="text" name="delete_participant_name" id="delete_participant_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger">Delete Participant</button>
    </form>
</div>
<style>
    .delete-participant-form {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px #6b7908;
        margin-top: 20px;
    }

    .delete-participant-form h3 {
        margin-bottom: 15px;
    }

    .alert {
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 5px;
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

        <div class="table-container">
            <h3>List of Events</h3>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Participants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $event): ?>
                            <?php 
                                $participantsForEvent = array_filter($participant, fn($p) => $p['event_id'] === $event['id']);
                                $remainingSpots = $event['max_participants'] - count($participantsForEvent);
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['title']); ?></td>
                                <td><?php echo htmlspecialchars($event['description']); ?></td>
                                <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                                <td>
                                    <ul>
                                        <?php foreach ($participantsForEvent as $p): ?>
                                            <li><?php echo htmlspecialchars($p['name']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <p><strong>Remaining Spots:</strong> <?php echo max(0, $remainingSpots); ?></p>
                                </td>
                                <td>
                                    <a href="editEvent.php?id=<?php echo $event['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="deleteEvent.php?id=<?php echo $event['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No events found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
