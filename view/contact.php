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
            background-color: #6b7908
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
            border: 3px solid #6b7908
        }

        .profile-card h2 {
            margin: 20px 0;
            color: #6b7908
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
            background-color: #6b7908
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
          /* Navbar styles */
          .menu-container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .navbar-area {
            display: flex;
            justify-content: flex-start; /* Align to the left */
            align-items: center;
            background-color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-area .logo {
            display: flex;
            align-items: center;
            margin-right: 20px; /* Add space between logo and menu */
        }

        .navbar-area .logo img {
            max-width: 40px; /* Logo size */
            margin-right: 10px;
        }

        .navbar-area .logo a {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }

        .site-navbar ul {
            display: flex;
            gap: 20px;
            list-style: none; /* Remove bullet points */
            padding: 0;
            margin: 0;
        }

        .site-navbar a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .site-navbar a.active {
            background-color:rgb(92, 137, 4); /* Green background for active link */
            color: white;
        }

        .site-navbar a:hover {
            background-color: #575757;
            color: white;
        }

        /* Toggle button for smaller screens */
        .nav-toggler {
            display: none; /* Hide toggle button on larger screens */
        }

        /* Media query for responsive design */
        @media (max-width: 768px) {
            .site-navbar ul {
                flex-direction: column;
                gap: 10px;
                width: 100%;
                display: none;
            }

            .navbar-area.active .site-navbar ul {
                display: flex;
            }

            .nav-toggler {
                display: block;
                background-color: #333;
                width: 40px;
                height: 30px;
                border: none;
                cursor: pointer;
            }

            .nav-toggler span {
                background-color: white;
                display: block;
                width: 100%;
                height: 4px;
                margin: 5px 0;
            }

            .site-navbar a {
                font-size: 14px;
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
    <div class="menu-container">
    <div class="navbar-area">
        <div class="logo">
            <img src="images/logos.png" alt="Logo"> <!-- Make sure the path is correct -->
            <a href="#">FIRMA <span>-TAK</span></a>
        </div>
        <button class="nav-toggler">
            <span></span>
        </button>
        <nav class="site-navbar">
            <ul>
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="about.php">Feedback</a></li>
                <li><a href="chat.php">Chatbot</a></li>
                <li><a href="listEvents.php">Projects</a></li>
                <li><a href="template/news/map.html">Map</a></li>
                <li><a href="rating.php">Rating</a></li>
                <li><a href="showcaseLands.php">Land</a></li>
                <li><a href="prodi.php">Product</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>
</div>

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