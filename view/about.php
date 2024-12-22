<?php
session_start();
require_once '../config/database.php';

// Ensure user is logged in
if (!isset($_SESSION['user']['id'])) {
    header("Location: log.php");
    exit();
}

// Database connection
$conn = new Database();
$db = $conn->getConnection();

// Check if message is being submitted
if (isset($_POST['submit_message'])) {
    $userId = $_SESSION['user']['id']; // Get logged-in user ID
    $message = trim($_POST['message']); // Get the message input

    // Sanitize the message to avoid SQL injection and malicious input
    if (!empty($message)) {
        $message = htmlspecialchars($message);

        // Insert message into the database
        $stmt = $db->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $message, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $successMessage = "Message sent successfully!";
        } else {
            $errorMessage = "Failed to send message!";
        }
    } else {
        $errorMessage = "Message cannot be empty!";
    }
}

// Check if delete request is made
if (isset($_GET['delete_message_id'])) {
    $messageId = $_GET['delete_message_id']; // Get the ID of the message to delete

    // Delete the message from the database
    $stmt = $db->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bindValue(1, $messageId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $successMessage = "Message deleted successfully!";
    } else {
        $errorMessage = "Failed to delete message!";
    }
}

// Fetch all messages from the database
$stmt = $db->prepare("SELECT m.id, m.message, u.name FROM messages m JOIN user u ON m.user_id = u.id ORDER BY m.created_at DESC");
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Message</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Global styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            margin: 30px auto;
        }

        /* Form Styles */
        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 1.1em;
            margin-bottom: 8px;
            display: block;
        }

        textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
            resize: vertical;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Message Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 1.1em;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td a {
            color: #f44336;
            text-decoration: none;
            font-size: 1em;
        }

        td a:hover {
            text-decoration: underline;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 5px;
            font-size: 1.1em;
        }

        .alert-success {
            background-color: #4CAF50;
            color: white;
        }

        .alert-error {
            background-color: #f44336;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            header h1 {
                font-size: 2em;
            }

            button {
                font-size: 1em;
            }

            textarea {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>FIRMA-TAK Message Center</h1>
    </header>

    <div class="container">

        <!-- Display Success or Error Message -->
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <!-- Message Submission Form -->
        <form action="about.php" method="POST">
            <label for="message">Your Message:</label><br>
            <textarea name="message" id="message" required></textarea><br>
            <button type="submit" name="submit_message">Send Message</button>
        </form>

        <!-- Messages Table -->
        <h2>Messages</h2>
        <table>
            <thead>
                <tr>
                    <th>Sender</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($messages): ?>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($message['name']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                            <td><a href="?delete_message_id=<?php echo $message['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?')">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center;">No messages found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn-index"><i class="fas fa-tachometer-alt"></i> Go to Home</a>

    </div>

</body>
</html>







