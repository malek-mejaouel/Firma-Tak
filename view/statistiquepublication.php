<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Publications</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        
        .stats-container {
            display: flex;
            gap: 30px;
            margin: 20px 0;
            width: 100%;
            max-width: 1200px;
        }
        
        .chart-container {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stats-table {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fa;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
        }
        
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Statistiques des Publications et Commentaires</h1>
    </div>

    <div class="stats-container">
        <div class="chart-container">
            <canvas id="commentChart"></canvas>
        </div>
        
        <div class="stats-table">
            <h2>Top Publications par Commentaires</h2>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Nombre de Commentaires</th>
                        <th>Pourcentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../../Controller/PublicationC.php';
                    
                    $publicationC = new PublicationC();
                    $stats = $publicationC->getPublicationStats();
                    
                    $totalComments = array_sum(array_column($stats, 'nb_commentaires'));
                    
                    foreach ($stats as $stat) {
                        $percentage = ($totalComments > 0) ? 
                            round(($stat['nb_commentaires'] / $totalComments) * 100, 2) : 0;
                        
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($stat['Titre']) . "</td>";
                        echo "<td>" . $stat['nb_commentaires'] . "</td>";
                        echo "<td>" . $percentage . "%</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        <?php
        // Préparer les données pour le graphique
        $titles = array_column($stats, 'Titre');
        $comments = array_column($stats, 'nb_commentaires');
        ?>

        const ctx = document.getElementById('commentChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($titles); ?>,
                datasets: [{
                    label: 'Nombre de Commentaires',
                    data: <?php echo json_encode($comments); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Nombre de Commentaires par Publication'
                    }
                }
            }
        });
    </script>

    <div class="footer">
        <a href="index.php">Retour à la liste des publications</a>
    </div>
</body>
</html>
