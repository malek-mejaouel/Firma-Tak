<?php
require '../db.php'; // Include the database connection

// Validate and retrieve the event ID from the URL
$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
if ($eventId <= 0) {
    die("Invalid Event ID.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;
    $participantId = isset($_GET['participant_id']) ? (int)$_GET['participant_id'] : 0;

    // Default to 1 if no participant_id is provided
    if ($rating && $rating >= 1 && $rating <= 5) {
        try {
            // Check if participant_id exists in the participant table
            $query = "SELECT COUNT(*) FROM participant WHERE id = :participant_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':participant_id', $participantId);
            $stmt->execute();
            $participantExists = $stmt->fetchColumn();

            if ($participantExists) {
                // Proceed with inserting the rating
                $query = "INSERT INTO event_ratings (event_id, participant_id, rating, comment) 
                          VALUES (:event_id, :participant_id, :rating, :comment)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':event_id', $eventId);
                $stmt->bindParam(':participant_id', $participantId);
                $stmt->bindParam(':rating', $rating);
                $stmt->bindParam(':comment', $comment); // Assuming comment field is passed
                $stmt->execute();
                $message = "<div class='message success'>Thank you for your rating!</div>";

            } else {
                $message = "<div class='message error'>An error occurred. Please try again.</div>";
            }
        } catch (Exception $e) {
            $message = "<div class='message error'>Error: " . $e->getMessage() . "</div>";
        }
    }
}

// Fetch existing rating if available
$participantId = isset($_GET['participant_id']) ? (int)$_GET['participant_id'] : 0;
$query = "SELECT rating FROM event_ratings WHERE event_id = :event_id AND participant_id = :participant_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':event_id', $eventId);
$stmt->bindParam(':participant_id', $participantId);
$stmt->execute();
$existingRating = $stmt->fetchColumn();
?>

<form method="POST" action="ratingevent.php?event_id=<?php echo $eventId; ?>&participant_id=<?php echo $participantId; ?>">
    <label for="rating">Rating (1 to 5):</label>
    <div class="star-rating">
        <input id="rating-5" type="radio" name="rating" value="5" <?php echo $existingRating == 5 ? 'checked' : ''; ?> />
        <label for="rating-5" class="star">&#9733;</label>

        <input id="rating-4" type="radio" name="rating" value="4" <?php echo $existingRating == 4 ? 'checked' : ''; ?> />
        <label for="rating-4" class="star">&#9733;</label>

        <input id="rating-3" type="radio" name="rating" value="3" <?php echo $existingRating == 3 ? 'checked' : ''; ?> />
        <label for="rating-3" class="star">&#9733;</label>

        <input id="rating-2" type="radio" name="rating" value="2" <?php echo $existingRating == 2 ? 'checked' : ''; ?> />
        <label for="rating-2" class="star">&#9733;</label>

        <input id="rating-1" type="radio" name="rating" value="1" <?php echo $existingRating == 1 ? 'checked' : ''; ?> />
        <label for="rating-1" class="star">&#9733;</label>
    </div>
    
    
    <button type="submit">Submit Rating</button>
</form>

<?php if (!empty($message)) echo $message; ?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    label {
        display: block;
        font-size: 16px;
        color: #555;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .star-rating {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 35px;
        color: #ddd;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .star-rating input:checked ~ label,
    .star-rating input:hover ~ label {
        color: #ffcc00;
    }

    .star-rating input:checked + label {
        color: #ffcc00;
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
    }

    button:active {
        background-color: #388e3c;
    }

    .star-rating input:checked ~ label,
    .star-rating input:hover ~ label {
        color: gold;
    }

    .message {
        padding: 15px;
        margin-top: 20px;
        border-radius: 5px;
        text-align: center;
        font-size: 16px;
    }

    .success {
        background-color: #4CAF50;
        color: white;
    }

    .error {
        background-color: #f44336;
        color: white;
    }
</style>
