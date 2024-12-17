<?php
// Include database connection file
require_once '../config/database.php';

// Establish database connection
$conn = new Database();
$db = $conn->getConnection();

// Query to get the count of users per user_type
$query = "
    SELECT user_type, COUNT(*) AS count 
    FROM user 
    GROUP BY user_type
";

$stmt = $db->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organize the data into a format suitable for the chart
$userTypes = [];
$userCounts = [];
foreach ($data as $row) {
    $userTypes[] = ucfirst($row['user_type']); // Capitalize the user_type for better readability
    $userCounts[] = $row['count']; // Store the count of users for each user_type
}

// Pass the processed data to JavaScript
echo "<script>const userTypes = " . json_encode($userTypes) . ";</script>";
echo "<script>const userCounts = " . json_encode($userCounts) . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Statistics - User Types</title>
</head>
<body>
    <h1>User Types and Their Counts</h1>

    <!-- Chart.js -->
    <canvas id="userChart" width="400" height="200"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('userChart').getContext('2d');

        const userData = {
            labels: userTypes, // User types (X-axis)
            datasets: [{
                label: 'User Count',
                data: userCounts, // Counts of users per user_type (Y-axis)
                fill: false,
                borderColor: '#FF5733',
                tension: 0.4, // This gives the line a curve
            }]
        };

        const config = {
            type: 'line', // Line chart (curve)
            data: userData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'User Type'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Users'
                        },
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        };

        new Chart(ctx, config);
    </script>
</body>
</html>