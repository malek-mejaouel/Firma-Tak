<?php
// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure le fichier de configuration pour établir la connexion à la base de données
require_once '../config/database.php';

// Obtenir la connexion à la base de données via la méthode statique de la classe config
$conn = (new Database())->getConnection();


// Vérifier si la connexion à la base de données est établie
if (!$conn) {
    // Assurez-vous que la connexion échoue proprement en renvoyant une réponse JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => "Database connection failed."]);
    exit;  // Exit to prevent further script execution
}

// Vérifier si le paramètre 'state' est fourni dans l'URL (pour la recherche par état)
if (isset($_GET['state'])) {
    $stateName = $_GET['state'];  // Récupérer le nom de l'état via l'URL

    // Préparer la requête SQL pour récupérer les animaux et les informations associées à cet état
    $stmt = $conn->prepare("SELECT name, description, state FROM animals WHERE state LIKE :stateName");

    if ($stmt === false) {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Failed to prepare the SQL statement."]);
        exit;
    }

    // Lier le paramètre 'state' à la requête (en utilisant LIKE pour autoriser une recherche partielle)
    $stmt->bindValue(':stateName', "%$stateName%", PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Vérifier si des résultats ont été retournés
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Assurez-vous de renvoyer le type de contenu approprié
    header('Content-Type: application/json');
    
    if ($animals) {
        // Retourner les résultats sous forme de JSON
        echo json_encode($animals);
    } else {
        // Si aucun animal n'est trouvé pour cet état, retourner un tableau vide
        echo json_encode([]);
    }
}
// Vérifier si le paramètre 'animal' est fourni dans l'URL (pour la recherche par nom d'animal)
else if (isset($_GET['animal'])) {
    $animalName = $_GET['animal'];  // Récupérer le nom de l'animal via l'URL

    // Préparer la requête SQL pour récupérer les détails de l'animal et sa state
    $stmt = $conn->prepare("SELECT name, description, state FROM animals WHERE name LIKE :animalName");

    if ($stmt === false) {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Failed to prepare the SQL statement."]);
        exit;
    }

    // Lier le paramètre 'animal' à la requête (en utilisant LIKE pour autoriser une recherche partielle)
    $stmt->bindValue(':animalName', "%$animalName%", PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Vérifier si des résultats ont été retournés
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Assurez-vous de renvoyer le type de contenu approprié
    header('Content-Type: application/json');
    
    if ($animals) {
        // Retourner les résultats sous forme de JSON
        echo json_encode($animals);
    } else {
        // Si aucun animal n'est trouvé, retourner un tableau vide
        echo json_encode([]);
    }
}
else {
    // Si aucun paramètre 'state' ni 'animal' n'est fourni, retourner un tableau vide
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>
