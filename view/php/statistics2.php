<?php



require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../model/plants.php');
require_once(__DIR__ . '/../../controller/plantsC.php');


try {
    $db = ( new Database())->getConnection();
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create an instance of PlantC
$plantC = new PlantC();

// Fetch all plants
$plants = $plantC->listPlants();

// Initialize stateCounts
$stateCounts = [];

// Calculate total population for each state
foreach ($plants as $plant) {
    $state = $plant['statep'];
    $description = $plant['descriptionp'];

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
    <title>Plant Statistics</title>
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
    <h2>Plant Population by State</h2>
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
                    label: 'Plant Population',
                    data: Object.values(stateCounts), // Population numbers
                    backgroundColor: [
                        '#D2B48C', // Tan color (light brown)
                        '#C9A677', // A shade between beige and brown
                        '#A67C52', // Darker brown
                        '#8B5E3C', // Even darker brown
                        '#7A4B28', // Dark brown
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
