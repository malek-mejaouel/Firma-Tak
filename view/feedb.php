<?php
session_start();
require_once '../config/database.php';

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: log.php");
    exit();
}

// Database connection
$conn = new Database();
$db = $conn->getConnection();

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
    <title>Messages</title>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        .container {
            width: 80%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .message-box {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .message-box h2 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        td a {
            color: #e74c3c;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }

        /* Pagination and Styling */
        .message-box, .container {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .empty-message {
            text-align: center;
            font-style: italic;
            color: #aaa;
        }

        /* Button Styling */
        .btn-dashboard {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 1rem;
            text-align: center;
        }

        .btn-dashboard:hover {
            background-color: #45a049;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>Your Messages</h1>
    </header>

    <div class="container">

        <!-- Message Box -->
        <div class="message-box">
            <h2><i class="fas fa-envelope"></i> Messages Received</h2>
            <table>
                <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($messages): ?>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($message['name']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="empty-message">No messages found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Button to Dashboard -->
        <a href="dashboard.php" class="btn-dashboard"><i class="fas fa-tachometer-alt"></i> Go to Dashboard</a>

    </div>

</body>
</html>