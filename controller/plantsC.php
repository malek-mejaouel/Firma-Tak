<?php


require_once(__DIR__ . '/../config/database.php'); // Chemin absolu basé sur l'emplacement réel
require_once(__DIR__ . '/../model/plants.php');  

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class PlantC {

    // Method to list all plants
    public function listPlants() {
        $sql = "SELECT * FROM plants"; // SQL query to select all plants
        $db = (new Database())->getConnection(); // Get the database connection
        $stmt = $db->prepare($sql); // Prepare the SQL statement
        $stmt->execute(); // Execute the query

        // Fetch all results as an associative array
        $plants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $plants; // Return the array of plants
    }

    // Method to delete a plant by ID
    public function deletePlant($ido) {
        $sql = "DELETE FROM plants WHERE ido = :ido"; // SQL query to delete a plant
        $db = (new Database())->getConnection();
        $req = $db->prepare($sql);
        $req->bindValue(':ido', $ido); // Bind the plant ID

        try {
            $req->execute(); // Execute the delete query
            echo "Plant deleted successfully.";
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage()); // Handle errors
        }
    }

    // Method to add a new plant
    public function addPlant($plant) {
        // Prepare the SQL query to insert a new plant
        $sql = "INSERT INTO plants (namep, descriptionp, statep) VALUES (:namep, :descriptionp, :statep)";
        $db = (new Database())->getConnection();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'namep' => $plant->getNamep(), // Use getter methods for properties
                'descriptionp' => $plant->getDescriptionp(),
                'statep' => $plant->getStatep()
            ]);

            echo "Plant added successfully.";
            header('Location: ../../view/php/plantsindex.php'); // Redirect after successful insertion
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage(); // Handle errors
        }
    }

    // Method to show details of a single plant by ID
    public function showPlant($ido) {
        $sql = "SELECT * FROM plants WHERE ido = :ido"; // SQL query to fetch a plant by its ID
        $db = (new Database())->getConnection();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':ido', $ido); // Bind the plant ID
            $query->execute();
            $plant = $query->fetch(); // Fetch the plant details

            return $plant; // Return the plant data
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage()); // Handle errors
        }
    }

    // Method to update plant details
    public function updatePlant($plant, $ido) {
        try {
            $db = (new Database())->getConnection();
            // SQL query to update plant details
            $query = $db->prepare(
                'UPDATE plants SET 
                    namep = :namep,
                    descriptionp = :descriptionp,
                    statep = :statep
                WHERE ido = :idplant'
            );

            // Execute the update query with plant values
            $query->execute([
                'idplant' => $ido,
                'namep' => $plant->getNamep(),
                'descriptionp' => $plant->getDescriptionp(),
                'statep' => $plant->getStatep()
            ]);

            echo $query->rowCount() . " record(s) UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo 'Error updating plant: ' . $e->getMessage(); // Handle errors
        }
    }
}
?>
