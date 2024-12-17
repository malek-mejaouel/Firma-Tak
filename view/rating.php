<?php
session_start();
if (file_exists('../config/database.php')) {
    require_once '../config/database.php';
} else {
    die('Database configuration file not found.');
}
// Database connection
$conn = new Database();
$db = $conn->getConnection();

// Check if a rating is submitted
if (isset($_POST['submit_rating'])) {
    $rating = (int)$_POST['rating'];

    if ($rating >= 1 && $rating <= 5) {
        // If user is logged in, store their user_id, else NULL
        $user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : NULL;

        // Insert the rating into the database
        $stmt = $db->prepare("INSERT INTO website_ratings (user_id, rating) VALUES (?, ?)");
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $rating, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect to avoid resubmitting on page refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch average rating
$stmt = $db->prepare("SELECT AVG(rating) AS avg_rating FROM website_ratings");
$stmt->execute();
$averageRating = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Our Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Global styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 2em;
            color: #333;
            text-align: center;
            margin-top: 20px;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .rating-stars {
            display: flex;
            justify-content: center;
            direction: rtl;
            font-size: 40px;
            margin: 20px 0;
            color: #ddd;
        }

        .rating-stars input {
            display: none;
        }

        .rating-stars label {
            cursor: pointer;
            padding: 5px;
        }

        .rating-stars input:checked ~ label {
            color: #FFD700; /* Gold for filled stars */
        }

        .rating-stars input:hover ~ label,
        .rating-stars input:checked:hover ~ label {
            color: #FFD700;
        }

        .current-rating {
            text-align: center;
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .feedback-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .feedback-form button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .feedback-form button:hover {
            background-color: #45a049;
        }

        .btn-index {
            margin-top: 20px;
            display: inline-block;
            background-color:rgb(35, 111, 2);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
        }

        .btn-index:hover {
            background-color:rgb(128, 179, 0);
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

<!-- Navbar -->
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

<!-- Main Content -->
<div class="container">
    <h1>Rate Our Website</h1>
 
    <!-- Display Average Rating -->
    <div class="current-rating">
        <p>Average Rating: <?php echo round($averageRating, 1); ?> / 5</p>
    </div>

    <!-- Rating Stars -->
    <form method="POST" action="" class="feedback-form">
        <div class="rating-stars">
            <input type="radio" id="star5" name="rating" value="5">
            <label for="star5">&#9733;</label>

            <input type="radio" id="star4" name="rating" value="4">
            <label for="star4">&#9733;</label>

            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3">&#9733;</label>

            <input type="radio" id="star2" name="rating" value="2">
            <label for="star2">&#9733;</label>

            <input type="radio" id="star1" name="rating" value="1">
            <label for="star1">&#9733;</label>
        </div>
        <button type="submit" name="submit_rating">Submit Rating</button>
        <a href="index.php" class="btn-index"><i class="fas fa-home"></i> Go to Home</a>
    </form>
</div>

</body>
</html>
