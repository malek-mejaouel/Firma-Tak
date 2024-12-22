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
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
        }

        .btn-index:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            h1 {
                font-size: 1.5em;
            }

            .container {
                padding: 20px;
            }

            .rating-stars {
                font-size: 30px;
            }

            .feedback-form button {
                font-size: 14px;
            }

            .btn-index {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

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