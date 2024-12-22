<?php

require_once(__DIR__ . '/../config/database.php');

require_once(__DIR__ . '/../model/plants.php'); 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class PlantC {

    // Method to list all plants
    public function listPlants() {
        $sql = "SELECT ido, namep FROM plants"; // SQL query to select all plants (id and name)
        $db = (new Database())->getConnection(); // Get the database connection
        $stmt = $db->prepare($sql); // Prepare the SQL statement
        $stmt->execute(); // Execute the query

        // Fetch all results as an associative array
        $plants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $plants; // Return the array of plants
    }
}

$plantC = new PlantC();
$plants = $plantC->listPlants();

// Check if no plants are found
if (empty($plants)) {
    echo json_encode(["error" => "Aucune plante trouvée"]);
    exit();
}

// Set the response header to application/json
header('Content-Type: application/json');

// Encode and return the plants data as JSON
echo json_encode($plants);
?>
