<?php
// Include database connection file
require_once '../config/database.php';

// Define the function to get user statistics
function getUserStatistics($db) {
    $query = "SELECT user_type, COUNT(*) AS count FROM user GROUP BY user_type";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Establish database connection
$conn = new Database();
$db = $conn->getConnection();

// Fetch user statistics
$statistics = getUserStatistics($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Statistics - Agriculture Society</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            color: #4e4d4b;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            color: #4CAF50;
            margin-top: 40px;
        }

        .statistics {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .stat-item {
            background-color: #e8f4e8;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .stat-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .stat-item h3 {
            font-size: 22px;
            color: #388E3C;
            margin-bottom: 15px;
        }

        .stat-item p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }

        .stat-item button {
            padding: 12px 25px;
            background-color: #388E3C;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .stat-item button:hover {
            background-color: #2c6e1f;
        }

        .stat-item button:focus {
            outline: none;
        }

        /* Emoji styles */
        .stat-item span {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .canvas-container {
            text-align: center;
            margin-top: 40px;
        }

        canvas {
            max-width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>User Statistics - Agricultural Society 🌾</h1>

    <div class="statistics">
        <h2>Our Community Members</h2>
        <div class="stat-grid">
            <?php foreach ($statistics as $stat): ?>
                <div class="stat-item">
                    <span>🌱</span>
                    <h3><?php echo ucfirst($stat['user_type']); ?></h3>
                    <p><?php echo $stat['count']; ?> members</p>
                    <form action="type_chart.php" method="GET">
                        <input type="hidden" name="user_type" value="<?php echo $stat['user_type']; ?>">
                        <button type="submit">View Curve 📊</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="canvas-container">
        <canvas id="userChart" width="400" height="200"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('userChart').getContext('2d');

    const userData = {
        labels: <?php echo json_encode(array_column($statistics, 'user_type')); ?>,
        datasets: [{
            label: 'Users 🌍',
            data: <?php echo json_encode(array_column($statistics, 'count')); ?>,
            backgroundColor: ['#388E3C', '#FFC107', '#FF5722'],
            borderColor: '#4CAF50',
            borderWidth: 2,
            hoverBackgroundColor: '#81C784'
        }]
    };

    const config = {
        type: 'pie', // Pie chart to show user distribution by type
        data: userData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ": " + tooltipItem.raw + " members 🌿";
                        }
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
</script>

</body>
</html>