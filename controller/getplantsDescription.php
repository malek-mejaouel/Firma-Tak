<?php
// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure le fichier de configuration pour établir la connexion à la base de données
require_once '../config/database.php';

// Inclure le modèle de la classe Plant
 // Include the Plant class
require_once '../model/plants.php';

// Obtenir la connexion à la base de données via la méthode statique de la classe config
$conn = (new Database())->getConnection();

// Vérifier si la connexion à la base de données est établie
if (!$conn) {
    // Si la connexion échoue, renvoyer un message d'erreur JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => "Database connection failed."]);
    exit;  // Exit to prevent further script execution
}

// Vérifier si le paramètre 'state', 'animal', ou 'plant' est fourni dans l'URL
if (isset($_GET['state'])) {
    $state = trim($_GET['state']);  // Récupérer l'état via l'URL et enlever les espaces supplémentaires

    // Vérification basique pour éviter les entrées malveillantes
    if (empty($state)) {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Invalid state parameter."]);
        exit;
    }

    // Préparer la requête SQL pour récupérer les plantes en fonction de l'état
    $stmt = $conn->prepare("SELECT ido, namep, descriptionp, statep FROM plants WHERE statep LIKE :state");

    if ($stmt === false) {
        // Si la préparation de la requête échoue, renvoyer une erreur
        header('Content-Type: application/json');
        echo json_encode(["error" => "Failed to prepare the SQL statement."]);
        exit;
    }

    // Lier le paramètre 'state' à la requête, en utilisant % pour les correspondances partielles
    $stmt->bindValue(':state', "%$state%", PDO::PARAM_STR);

    try {
        // Exécuter la requête
        $stmt->execute();
        // Vérifier si des résultats ont été retournés
        $plants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Renvoyer les résultats sous forme de JSON
        header('Content-Type: application/json');
        
        if ($plants) {
            // Retourner les résultats sous forme de JSON
            echo json_encode($plants);
        } else {
            // Si aucune plante n'est trouvée, retourner un tableau vide
            echo json_encode([]);
        }
    } catch (PDOException $e) {
        // En cas d'erreur d'exécution, renvoyer un message d'erreur
        header('Content-Type: application/json');
        echo json_encode(["error" => "Database query failed: " . $e->getMessage()]);
    }
} 
// Si 'animal' est fourni, chercher les plantes qui correspondent à un nom d'animal
else if (isset($_GET['animal'])) {
    $animal = trim($_GET['animal']);  // Récupérer le nom de l'animal via l'URL

    if (empty($animal)) {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Invalid animal parameter."]);
        exit;
    }

    // Préparer la requête SQL pour récupérer les plantes en fonction du nom de l'animal
    $stmt = $conn->prepare("SELECT ido, namep, descriptionp, statep FROM plants WHERE namep LIKE :animal");

    if ($stmt === false) {
        // Si la préparation de la requête échoue, renvoyer une erreur
        header('Content-Type: application/json');
        echo json_encode(["error" => "Failed to prepare the SQL statement."]);
        exit;
    }

    // Lier le paramètre 'animal' à la requête, en utilisant % pour les correspondances partielles
    $stmt->bindValue(':animal', "%$animal%", PDO::PARAM_STR);

    try {
        // Exécuter la requête
        $stmt->execute();
        // Vérifier si des résultats ont été retournés
        $plants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Renvoyer les résultats sous forme de JSON
        header('Content-Type: application/json');
        
        if ($plants) {
            // Retourner les résultats sous forme de JSON
            echo json_encode($plants);
        } else {
            // Si aucune plante n'est trouvée, retourner un tableau vide
            echo json_encode([]);
        }
    } catch (PDOException $e) {
        // En cas d'erreur d'exécution, renvoyer un message d'erreur
        header('Content-Type: application/json');
        echo json_encode(["error" => "Database query failed: " . $e->getMessage()]);
    }
} 
// Si 'plant' est fourni, chercher les plantes qui correspondent à un nom de plante
else if (isset($_GET['plant'])) {
    $plant = trim($_GET['plant']);  // Récupérer le nom de la plante via l'URL

    if (empty($plant)) {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Invalid plant parameter."]);
        exit;
    }

    // Préparer la requête SQL pour récupérer les plantes en fonction du nom de la plante
    $stmt = $conn->prepare("SELECT ido, namep, descriptionp, statep FROM plants WHERE namep LIKE :plant");

    if ($stmt === false) {
        // Si la préparation de la requête échoue, renvoyer une erreur
        header('Content-Type: application/json');
        echo json_encode(["error" => "Failed to prepare the SQL statement."]);
        exit;
    }

    // Lier le paramètre 'plant' à la requête, en utilisant % pour les correspondances partielles
    $stmt->bindValue(':plant', "%$plant%", PDO::PARAM_STR);

    try {
        // Exécuter la requête
        $stmt->execute();
        // Vérifier si des résultats ont été retournés
        $plants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Renvoyer les résultats sous forme de JSON
        header('Content-Type: application/json');
        
        if ($plants) {
            // Retourner les résultats sous forme de JSON
            echo json_encode($plants);
        } else {
            // Si aucune plante n'est trouvée, retourner un tableau vide
            echo json_encode([]);
        }
    } catch (PDOException $e) {
        // En cas d'erreur d'exécution, renvoyer un message d'erreur
        header('Content-Type: application/json');
        echo json_encode(["error" => "Database query failed: " . $e->getMessage()]);
    }
} else {
    // Si aucun paramètre valide n'est fourni dans l'URL, renvoyer un tableau vide
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>
