<?php 
require_once '../config/database.php';
require_once '../controller/AuthController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté et s'il est admin
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'admin') {
    header('Location: log.php'); // Rediriger vers la page de connexion si ce n'est pas un admin
    exit();
}

// Instancier la connexion à la base de données
$conn = new Database();
$db = $conn->getConnection(); // Utiliser la méthode getConnection au lieu de connect()

// Instancier le contrôleur
$controller = new AuthController($db);

// Récupérer la lettre à partir de l'URL (ou définir une valeur par défaut)
$letter = isset($_GET['letter']) ? $_GET['letter'] : 'A'; // Par défaut, 'A' si aucune lettre n'est spécifiée

// Récupérer les utilisateurs triés par la lettre spécifiée
$users = $controller->listUserByLetter($letter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tri des utilisateurs par lettre</title>
    
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ordre des utilisateurs par lettre de début</h1>
            <form method="GET" action="message.php">
                <label for="letter">Trier par la lettre :</label>
                <input type="text" name="letter" id="letter" maxlength="1" required>
                <button type="submit">Trier</button>
            </form>
        </div>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Type d'utilisateur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_type']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Aucun utilisateur trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="dashboard.php" class="return-button">Return to Dashboard</a>

        </div>
    </div>
    <style>/* Reset des marges et paddings */
/* Reset des marges et paddings */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Mise en page générale */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7f6;
    color: #333;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

/* Conteneur principal */
.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 40px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

/* En-tête */
.header {
    text-align: center;
    margin-bottom: 40px;
}

.header h1 {
    font-size: 2.5rem;
    color: #333;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.header p {
    font-size: 1.1rem;
    color: #555;
}

/* Formulaire de filtre */
form {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 30px;
}

form label {
    font-size: 1.1rem;
    font-weight: 500;
    color: #555;
}

form input {
    padding: 12px;
    font-size: 1rem;
    border: 2px solid #ddd;
    border-radius: 6px;
    outline: none;
    width: 200px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

form input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

form button {
    padding: 12px 25px;
    font-size: 1rem;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

form button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Tableau des utilisateurs */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 14px;
    text-align: left;
    border-bottom: 2px solid #f1f1f1;
    font-size: 1.1rem;
}

table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #333;
}

table tbody tr:hover {
    background-color: #f1f1f1;
}

table td {
    color: #555;
}

/* Message lorsqu'aucun utilisateur n'est trouvé */
table td[colspan="4"] {
    text-align: center;
    font-style: italic;
    color: #888;
}

/* Footer */
footer {
    text-align: center;
    margin-top: 40px;
    font-size: 0.9rem;
    color: #777;
}

footer a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

footer a:hover {
    text-decoration: underline;
}

/* Responsive Design pour mobile */
@media (max-width: 768px) {
    .container {
        padding: 20px;
    }

    .header h1 {
        font-size: 2rem;
    }

    form {
        flex-direction: column;
        align-items: center;
    }

    form input, form button {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>
</body>
</html>