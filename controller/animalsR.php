<?php
require_once '../config/database.php';
include_once '../model/animals.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class AnimalC {
    public function listAnimals() {
        $sql = "SELECT id, name FROM animals"; // Requête pour sélectionner les animaux (id et name)
        $db = (new Database())->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner le tableau associatif avec id et name
    }
}

$animalC = new AnimalC();
$animals = $animalC->listAnimals();

// Vérifier si la liste est vide et renvoyer un message d'erreur si nécessaire
if (empty($animals)) {
    echo json_encode(["error" => "Aucun animal trouvé"]);
    exit();
}

// Définir l'en-tête de la réponse comme JSON
header('Content-Type: application/json');

// Encoder les données en JSON
echo json_encode($animals);
?>
