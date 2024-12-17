<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    if ($id && $latitude && $longitude) {
        try {
            // Prepare the SQL statement
            $stmt = $conn->prepare("UPDATE lands SET latitude = :latitude, longitude = :longitude WHERE id = :id");

            // Bind the parameters
            $stmt->bindParam(':latitude', $latitude);
            $stmt->bindParam(':longitude', $longitude);
            $stmt->bindParam(':id', $id);

            // Execute the query
            if ($stmt->execute()) {
                echo 'Location updated successfully';
            } else {
                echo 'Failed to update location';
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    } else {
        echo 'Invalid input';
    }
} else {
    echo 'Invalid request method';
}
?>
