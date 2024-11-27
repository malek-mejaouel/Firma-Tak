<?php
session_start();

// Check if the user is logged in as a standard user
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'user') {
    header("Location: log.php"); // Redirect to login if not authorized
    exit();
}

// Retrieve user information from the session
$user = $_SESSION['user'];
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
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Upload an image:</label>
            <input type="file" name="file" id="file" accept="image/*" required>
            <button type="submit" name="upload">Upload</button>
        </form>
        <a href="index.php" class="back-button">Back to the main</a>
    </div>
</body>
</html>