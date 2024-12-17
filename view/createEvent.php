<?php
require '../db.php';
require '../controller/EventController.php';

$titleError = $descriptionError = $dateError = $imageError = '';
$title = $description = $eventDate = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isValid = true;

    // Validate title
    if (empty($_POST['title'])) {
        $titleError = "The title is required.";
        $isValid = false;
    } else {
        $title = htmlspecialchars($_POST['title']);
    }

    // Validate description
    if (empty($_POST['description'])) {
        $descriptionError = "The description is required.";
        $isValid = false;
    } else {
        $description = htmlspecialchars($_POST['description']);
    }

    // Validate date
    if (empty($_POST['event_date']) || !strtotime($_POST['event_date'])) {
        $dateError = "A valid event date is required.";
        $isValid = false;
    } else {
        $eventDate = $_POST['event_date'];
    }

    // Validate max participants
    $maxParticipantsError = '';
    $maxParticipants = null;

    if (empty($_POST['max_participants']) || !is_numeric($_POST['max_participants']) || $_POST['max_participants'] < 1) {
        $maxParticipantsError = "A valid maximum number of participants is required.";
        $isValid = false;
    } else {
        $maxParticipants = (int)$_POST['max_participants'];
    }

    // Validate and process the image
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $imageError = "An image is required.";
        $isValid = false;
    } else {
        $uploadDir = '../uploads/';
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            echo "Failed to upload the image.";
            exit();
        }
    }

    // Process the form if valid
    if ($isValid) {
        $controller = new EventController($conn);
        $result = $controller->createEvent($title, $description, $eventDate, $imagePath, $maxParticipants);
        if ($result) {
            header('Location: listback.php');
            exit();
        } else {
            echo "<p style='color: red;'>Failed to create the event.</p>";
        }
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
    <h1>Create New Event</h1>
    <form action="createEvent.php" method="post" enctype="multipart/form-data" class="event-form">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" placeholder="Enter event title">
        <p style="color: red;"><?php echo $titleError; ?></p>
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="5" placeholder="Enter event description"><?php echo htmlspecialchars($description); ?></textarea>
        <p style="color: red;"><?php echo $descriptionError; ?></p>
    </div>

    <div class="form-group">
        <label for="event_date">Date:</label>
        <input type="date" id="event_date" name="event_date" value="<?php echo htmlspecialchars($eventDate); ?>">
        <p style="color: red;"><?php echo $dateError; ?></p>
    </div>
    <div class="form-group">
    <label for="max_participants">Max Participants:</label>
    <input type="number" id="max_participants" name="max_participants" min="1" value="<?php echo htmlspecialchars($maxParticipants ?? ''); ?>" required>
    <p style="color: red;"><?php echo $maxParticipantsError ?? ''; ?></p>
</div>

    <div class="form-group">
        <label for="image">Upload Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <p style="color: red;"><?php echo $imageError; ?></p>
    </div>
    
    <div class="form-group"></div>
    <div class="form-buttons">
        <button type="submit" class="btn-submit">Add Event</button>
        <a href="listEvents.php" class="btn-back">Back to Events List</a>
    </div>
</form>

</div>
    <script src="../assets/fonction.js"></script>
</body>

</html>



