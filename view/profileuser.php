<?php
session_start();

// Check if the user is logged in as a standard user
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'user') {
    header("Location: log.php"); // Redirect to login if not authorized
    exit();
}

// Retrieve user information from the session
$user = $_SESSION['user'];
require_once '../config/database.php';
require_once '../controller/AuthController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: log.php');
    exit();
}

$conn = new Database();
$db = $conn->getConnection(); 
$controller = new AuthController($db);


// Handle the profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $userId = $_SESSION['user']['id']; // Get logged-in user ID
    $image = $_FILES['profile_picture'];

    // Check if the image is valid (optional)
    if ($image['error'] === 0) {
        $imagePath = 'uploads/' . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Update the user's profile picture in the database
            if ($controller->updateProfilePicture($userId, $imagePath)) {
                echo "<script>alert('Profile picture updated successfully!');</script>";
            } else {
                echo "<script>alert('Failed to update profile picture.');</script>";
            }
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }
}

// Fetch user details for displaying in the profile page
$user = $controller->getUserById($_SESSION['user']['id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-header h1 {
            font-size: 24px;
            color: #333;
        }
        .profile-info {
            margin: 10px 0;
            font-size: 16px;
        }
        .profile-info label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #6b7908;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }
        .back-button:hover {
            background: #5a6907;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>User Profile</h1>
        </div>
        <div class="profile-info">
            <p><label>Name:</label> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><label>Email:</label> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><label>User Type:</label> <?php echo htmlspecialchars($user['user_type']); ?></p>
        </div>
        <div class="profile-container">
        <h2>Your Profile</h2>
        <!-- Profile Picture -->
        <div class="profile-picture">
            <img src="<?php echo isset($user['profile_picture']) ? $user['profile_picture'] : 'images/default-avatar.png'; ?>" alt="Profile Picture">
        </div>
        
        <!-- Profile Picture Upload Form -->
        <form method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Choose a Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
    </div>
        <a href="index.php" class="back-button">Back to the main</a>
    </div>
</body>
</html>