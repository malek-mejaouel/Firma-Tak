<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

$user = $_SESSION['user']; // Get user data from session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIRMA TAK</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            color: #333;
        }

        /* Header */
        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 2em;
        }

        /* Profile Container */
        .profile-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .profile-card {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            padding: 30px;
            text-align: center;
        }

        .profile-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4CAF50;
        }

        .profile-card h2 {
            margin: 20px 0;
            color: #4CAF50;
        }

        .profile-card p {
            font-size: 1.1em;
            color: #555;
        }

        /* Upload Section */
        .upload-section {
            margin-top: 20px;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .upload-section label {
            display: block;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .upload-section input[type="file"] {
            display: block;
            margin-bottom: 15px;
        }

        .upload-section button {
            background-color: #4CAF50;
            color: white;
            font-size: 1em;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .upload-section button:hover {
            background-color: #45a049;
        }

        /* Return Button */
        .return-button {
            margin-top: 20px;
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            text-align: center;
            display: inline-block;
        }

        .return-button:hover {
            background-color: #555;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 30px;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>FRIMA-TAK PROFILE</h1>
    </header>

    <!-- Profile Section -->
    <div class="profile-container">
        <div class="profile-card">
            <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>
            
            <!-- Display Profile Picture -->
            <div>
                <h3>Profile Picture</h3>
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture">
                <?php else: ?>
                    <p>No profile picture uploaded.</p>
                <?php endif; ?>
            </div>

            <!-- Form for uploading a new profile picture -->
            <div class="upload-section">
                <form action="uploadone.php" method="POST" enctype="multipart/form-data">
                    <label for="file">Upload New Profile Picture:</label>
                    <input type="file" name="file" id="file" required>
                    <button type="submit" name="upload">Upload</button>
                </form>
            </div>

            <!-- Return to Dashboard Button -->
            <a href="index.php" class="return-button">Return to home</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 FIRMA-TAK. All rights reserved.</p>
    </footer>

</body>
</html>