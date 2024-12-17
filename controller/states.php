<?php
require_once(__DIR__ . '/../config/database.php');
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


class StateC {
    public function listStates() {
        $sql = "SELECT id, name FROM states"; // Sélectionner id et name
        $db = (new Database())->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer id et name
    }
}

$stateC = new StateC();
$states = $stateC->listStates();

// Vérification de la validité des données
if (empty($states)) {
    echo json_encode(["error" => "Aucun état trouvé ou erreur de base de données"]);
    exit();
}

// Répondre avec les données en JSON
header('Content-Type: application/json');  // Définir le type de contenu comme JSON
$jsonData = json_encode($states);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Erreur de codage JSON: " . json_last_error_msg()]);
    exit();
}
echo $jsonData;
?>
