<?php
// Include the database and controller files
require_once '../config/database.php';
require_once '../controller/LandRentController.php';

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Make sure the $conn variable is available
    $database = new Database();
    $conn = $database->getConnection(); // Establish the database connection

    // Instantiate the controller and pass the $conn variable to it
    $controller = new LandRentController($conn);

    // Call the delete function from the controller
    $result = $controller->deleteLand($id);

    // Check the result of the deletion and redirect
    if ($result) {
        header('Location: listLands.php'); // Redirect to the list page after successful delete
        exit();
    } else {
        echo "Failed to delete the land rental record.";
    }
} else {
    echo "Invalid request.";
}
?>
