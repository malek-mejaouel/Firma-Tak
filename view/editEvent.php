<?php
require '../db.php';
require '../controller/EventController.php';

// Instantiate the controller
$controller = new EventController($conn);

// Check if an ID is provided in the URL and fetch the event details
if (isset($_GET['id'])) {
    $event = $controller->viewEvent($_GET['id']);
    if (!$event) {
        // Redirect to the event list if the event is not found
        header('Location: listEvents.php');
        exit();
    }
} else {
    // Redirect if no ID is provided
    header('Location: listEvents.php');
    exit();
}

// Handle form submission for updating the event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->editEvent($_POST['id'], $_POST['title'], $_POST['description'], $_POST['event_date']);
    if ($result) {
        header('Location: listEvents.php');
        exit();
    } else {
        echo "Failed to update the event.";
    }
}
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
    <h1>Edit Event</h1>
    <form action="editEvent.php?id=<?php echo $event['id']; ?>" method="post" enctype="multipart/form-data" class="event-form">
        <input type="hidden" name="id" value="<?php echo $event['id']; ?>">

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required placeholder="Enter event title">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required placeholder="Enter event description"><?php echo htmlspecialchars($event['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="event_date">Date:</label>
            <input type="date" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>" required>
        </div>

        <div class="form-group">
            <label for="image">Change Image (Optional):</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Update Event</button>
            <a href="listEvents.php" class="btn-back">Back to Events List</a>
        </div>
    </form>
</div>
    <script src="../assets/fonction.js"></script>
</body>

</html>
