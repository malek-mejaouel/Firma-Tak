<?php
require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../model/animals.php');
require_once(__DIR__ . '/../../controller/animalsC.php');
try {
    $db = ( new Database())->getConnection();
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create an instance of AnimalC
$animalC = new AnimalC();

// Fetch all animals
$animals = $animalC->listAnimals();

// Initialize stateCounts
$stateCounts = [];

// Calculate total population for each state
foreach ($animals as $animal) {
    $state = $animal['state'];
    $description = $animal['description'];

    // Extract the population number from the description using regex
    preg_match('/~(\d+(?:,\d+)*)/', $description, $matches);

    if (!empty($matches[1])) {
        $population = (int)str_replace(',', '', $matches[1]); // Remove commas from numbers

        if (!isset($stateCounts[$state])) {
            $stateCounts[$state] = 0;
        }

        $stateCounts[$state] += $population;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f1f1f1;
            padding: 20px;
        }
        h1, h2 {
            color: #444;
        }
        canvas {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Animal Population by State</h2>
    <canvas id="stateChart"></canvas>

    <script>
        // Pass the PHP-calculated stateCounts to JavaScript
        const stateCounts = <?php echo json_encode($stateCounts); ?>;

        // Render the chart
        const ctx = document.getElementById('stateChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(stateCounts), // State names
                datasets: [{
                    label: 'Animal Population',
                    data: Object.values(stateCounts), // Population numbers
                    backgroundColor: [
                        '#6b7908', // Shade 1 (Dark Olive Green)
                        '#747f2f', // A shade between #6b7908 and #b0b68a
                        '#7a8c56', 
                        '#8c9b79', 
                        '#9b9f8f', 
                        '#a7b59e', 
                        '#b0b68a', // Shade 2 (Lighter Olive Green)
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Population'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'States'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
