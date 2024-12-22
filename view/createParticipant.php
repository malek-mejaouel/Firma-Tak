<?php
require '../db.php';
require '../controller/ParticipantController.php';

$name = $email = $phone = $event_id = ""; // Initialize variables
$nameError = $emailError = $phoneError = $event_idError = ""; // Initialize error variables

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['Name'];
    $email = $_POST['email'];
    $phone = $_POST['number'];
    $event_id = $_POST['event_id'];

    $isValid = true;

    // Validate Name
    if (empty($name)) {
        $nameError = "Name is required.";
        $isValid = false;
    }

    // Validate Email
    if (empty($email)) {
        $emailError = "Email is required.";
        $isValid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format.";
        $isValid = false;
    }

    // Validate Phone
    if (empty($phone)) {
        $phoneError = "Phone number is required.";
        $isValid = false;
    }

    // Validate Event ID
    if (empty($event_id)) {
        $event_idError = "Event ID is required.";
        $isValid = false;
    }

    if ($isValid) {
        $controller = new ParticipantController($conn);
        $controller->createParticipant($name, $email, $phone, $event_id);
        header('Location: listback.php');
        exit();
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
    <h1>Add participant</h1>
    <form action="createParticipant.php" method="post" enctype="multipart/form-data" class="event-form">
    <div class="form-group">
        <label for="Name">Name:</label>
        <input type="text" id="Name" name="Name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter participant name">
        <p style="color: red;"><?php echo $nameError; ?></p>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input id="email" name="email" rows="5" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>">
        <p style="color: red;"><?php echo $emailError; ?></p>
    </div>

    <div class="form-group">
        <label for="phone">phone:</label>
        <input type="number" id="number" name="number" value="<?php echo htmlspecialchars($name); ?>">
        <p style="color: red;"><?php echo $nameError; ?></p>
    </div>

    <div class="form-group">
        <label for="event_id">Event Id:</label>
        <input type="number" id="event_id" name="event_id"  value="<?php echo htmlspecialchars($event_id); ?>">
        <p style="color: red;"><?php echo $event_idError; ?></p>
    </div>

    <div class="form-buttons">
        <button type="submit" class="btn-submit">Add Participant</button>
        <a href="listEvents.php" class="btn-back">Back to Events List</a>
    </div>
</form>

</div>
    <script src="../assets/fonction.js"></script>
</body>

</html>



