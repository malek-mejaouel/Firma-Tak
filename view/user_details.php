<!-- user_details.php -->
<?php
require_once '../controller/AuthController.php';

// Créer une connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=webproject', 'root', '');

// Créer une instance du contrôleur AuthController avec la connexion à la base de données
$authController = new AuthController($db);

// Vérifier si un terme de recherche a été soumis via le formulaire
if (isset($_POST['search_term']) && !empty($_POST['search_term'])) {
    $searchTerm = $_POST['search_term'];

    // Effectuer la recherche de l'utilisateur
    $users = $authController->searchUser($searchTerm);

    // Vérifier si des utilisateurs ont été trouvés
    if (!empty($users)) {
        // Utilisez le premier utilisateur trouvé pour afficher ses détails
        $user = $users[0];
    } else {
        // Si aucun utilisateur n'est trouvé
        echo "<p>No user found matching the term '$searchTerm'.</p>";
    }
} else {
    echo "<p>Please enter a search term.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url("images/profile.jpg");
    
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            background-size: cover;
            background-position: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 400px;
            max-width: 100%;
        }

        h1 {
            font-size: 26px;
            color: #2e4d28;
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Roboto', sans-serif;
        }

        .user-details {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #3e5c3f;
        }

        .user-details p {
            font-size: 18px;
            line-height: 1.6;
            margin: 12px 0;
        }

        .user-details strong {
            color: #6a9d3b;
        }

        .error-message {
            color: #e74c3c;
            font-size: 16px;
            text-align: center;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6a9d3b;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #4d7a3e;
        }

        .back-link {
            text-align: center;
        }

        /* Adding button and container styles for better accessibility */
        button {
            background-color: #6a9d3b;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 18px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4d7a3e;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Afficher les détails de l'utilisateur -->
        <?php if (isset($user)): ?>
            <div class="user-details">
                <h1>User Details</h1>
                <p><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
                <p><strong>User Type:</strong> <?= htmlspecialchars($user['user_type']); ?></p>
            </div>
        <?php else: ?>
            <p class="error-message">Please enter a search term or no user found matching your search.</p>
        <?php endif; ?>

        <div class="back-link">
            <a href="dashboard.php">Back to Search</a>
        </div>
    </div>

</body>
</html>