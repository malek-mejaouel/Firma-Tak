
<?php
require '../db.php';
require '../controllers/EventController.php';
require '../controllers/ParticipantController.php';
$controller = new EventController($conn);
$controller1= new ParticipantController($conn);
$events = $controller->listEvents();
$participant = $controller1->listParticipants();

ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../assets/form.css">
    <title>ALPHA Web Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
            <img src="../assets/images/logos.png" alt="">&nbsp;<h2>FIRMA-TAK</h2>
        </div>
        <ul>
            <a href="#"><li><img src="../assets/images/dashboard (2).png" alt="">&nbsp; <span>Dashboard</span> </li></a>
            <a href="#"><li><img src="../assets/images/reading-book (1).png" alt="">&nbsp;<span>Offers</span> </li></a>
            <a href="#"><li><img src="../assets/images/converted_image_2.png" alt="">&nbsp;<span>Farmers</span> </li></a>
            <a href="#"><li><img src="../assets/images/white_image_revised.png">&nbsp;<span>Grocerers</span> </li></a>
            <a href="#"><li><img src="../assets/images/payment.png" alt="">&nbsp;<span>Stock</span> </li></a>
            <a href="#"><li><img src="../assets/images/help-web-button.png" alt="">&nbsp; <span>News</span></li></a>
            <a href="#"><li><img src="../assets/images/settings.png" alt="">&nbsp;<span>Settings</span> </li></a>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" placeholder="Search..">
                    <button type="submit"><img src="../assets/images/search.png" alt=""></button>
                </div>
                <div class="user">
                    <a href="#" class="btn">Add New</a>
                    <img src="../assets/images/notifications.png" alt="">
                    <div class="img-case">
                        <img src="../assets/images/user.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
        <section>
     <style>
    table {
        width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
    }
    h3 {
        font-size: 30px;
            color: #6b7908;
            margin-left: 50px;
        text-align: center;
    }
    .at {
    display: inline-block;
    padding: 8px 14px;
    text-transform: uppercase;
    font-weight: bold;
    border-radius: 5px;
    background-color: #6b7908; /* Green shade */
    color: white;
    text-decoration: none;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.at:hover {
    background-color: #4a5705; /* Darker green shade */
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.at:active {
    background-color: #344003; /* Even darker for active */
    transform: translateY(0);
}

</style>
     <h3>List of Events</h3>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($events) > 0): ?>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?php echo htmlspecialchars($event['title']); ?></td>
                <td><?php echo htmlspecialchars($event['description']); ?></td>
                <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                <td>
                    <?php if (!empty($event['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($event['image_path']); ?>" alt="Event Image" style="width: 100px; height: auto;">
                    <?php endif; ?>
                </td>
                <td>
                    <a class="at" href="createEvent.php">Create New Event</a>
                    <a class="at" href="editEvent.php?id=<?php echo $event['id']; ?>">Edit</a>
                    <a class="at" href="deleteEvent.php?id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                </td>
            </tr>
            <!-- Participants Section -->
           <!-- Participants Section -->
           <tr>
    <td colspan="5">
        <strong>Participants:</strong>
        <ul>
            <?php
            // Fetch participants for the current event
            $participantsForEvent = array_filter($participant, function ($p) use ($event) {
                return $p['event_id'] === $event['id'];
            });

            if (count($participantsForEvent) > 0): ?>
                <?php foreach ($participantsForEvent as $singleParticipant): ?>
                    <li>
                        <?php echo htmlspecialchars($singleParticipant['name']); ?> (<?php echo htmlspecialchars($singleParticipant['email']); ?>)
                        <a href="deleteParticipant.php?id=<?php echo $singleParticipant['id']; ?>" 
                           class="at" 
                           onclick="return confirm('Are you sure you want to delete this participant?');">Delete</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No participants found for this event.</li>
            <?php endif; ?>
        </ul>
    </td>
</tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No events found.</td>
        </tr>
    <?php endif; ?>
</tbody>

</table>
     </section>
</div>
    <script src="../assets/fonction.js"></script>
    
</body>

</html>



