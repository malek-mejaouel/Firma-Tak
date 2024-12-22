<?php
require_once '../config/database.php';  // Include the database configuration
require_once '../model/user.php';  // Include the User model
session_start();  // Start the session to get user info

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Create a database connection
$db = new Database();
$conn = $db->getConnection();  // Use the getConnection method to get the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    // Get the uploaded file info
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // Allowed file types
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileType = mime_content_type($fileTmpName);

    // Check if the file is an allowed type
    if (in_array($fileType, $allowedTypes)) {
        if ($fileError === 0) {
            // Check if the file is within the size limit (5MB)
            if ($fileSize <= 5 * 1024 * 1024) {
                // Create a unique name for the file
                $newFileName = uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                // Set the upload directory
                $uploadDir = '../view/images/';  // Your images directory
                $fileDestination = $uploadDir . $newFileName;

                // Move the uploaded file to the desired directory
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Get the user ID from the session
                    $userId = $_SESSION['user']['id'];

                    // Create an instance of the User class
                    $userModel = new User($conn);

                    // Update the profile picture path in the database
                    if ($userModel->updateProfilePicture($userId, $fileDestination)) {
                        // Update the session with the new profile picture URL
                        $_SESSION['user']['profile_picture'] = $fileDestination;

                        // Redirect to profile page
                        header("Location: profile.php");
                        exit();
                    } else {
                        echo "Error updating profile picture in the database.";
                    }
                } else {
                    echo "There was an error uploading the file.";
                }
            } else {
                echo "The file is too large. Maximum size is 5MB.";
            }
        } else {
            echo "There was an error uploading the file.";
        }
    } else {
        echo "Only JPEG, PNG, and GIF images are allowed.";
    }
}
?>