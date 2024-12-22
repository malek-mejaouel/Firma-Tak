<?php
require_once(__DIR__ . '/../config/database.php'); // Chemin absolu basé sur l'emplacement réel
require_once(__DIR__ . '/../model/animals.php');   // Chemin absolu basé sur l'emplacement rée
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try { 
    $db =( new Database())->getConnection();
    // echo "Database connection successful!";
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}

class AnimalC {

    public function listAnimals() {
        $sql = "SELECT * FROM animals"; // Requête pour sélectionner tous les animaux
        $db = (new Database())->getConnection(); // Obtenir la connexion à la base de données
        $stmt = $db->prepare($sql); // Préparer la requête SQL
        $stmt->execute(); // Exécuter la requête
    
        // Utiliser fetchAll() pour récupérer tous les résultats comme tableau associatif
        $animals = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
        return $animals; // Retourner le tableau avec tous les animaux
    }

    // Method to list animals by state
    
    public function deleteAnimal($ide) {
        $sql = "DELETE FROM animals WHERE id = :id";
        $db = (new Database())->getConnection();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $ide);

        try {
            $req->execute();
            echo "Animal deleted successfully.";
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addAnimal($animal) {
        // Make sure you're using the methods from the Animal object
        $sql = "INSERT INTO animals (name, description, state) VALUES (:name, :description, :state)";
        $db = (new Database())->getConnection();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'name' => $animal->getName(),           // getName() belongs to Animal
                'description' => $animal->getDescription(), // getDescription() belongs to Animal
                'state' => $animal->getState()           // getState() belongs to Animal
            ]);
          
            echo "Animal added successfully.";
              header('Location: ../../view/php/animalsindex.php');
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    public function calculateStatistics()
    {
        $db =( new Database())->getConnection();
        $sql = "SELECT description FROM animals";
        $query = $db->prepare($sql);
        $query->execute();
        $descriptions = $query->fetchAll(PDO::FETCH_ASSOC);
    
        $numbers = [];
        foreach ($descriptions as $row) {
            // Extract numbers using regex
            preg_match('/~(\d+)/', $row['description'], $matches);
            if (isset($matches[1])) {
                $numbers[] = (int)$matches[1];
            }
        }
    
        // Calculate statistics
        $total = array_sum($numbers);
        $count = count($numbers);
        $average = $count > 0 ? $total / $count : 0;
        $max = $count > 0 ? max($numbers) : 0;
    
        return [
            'total' => $total,
            'average' => $average,
            'max' => $max,
        ];
    }
    
    public function showAnimal($id) {  
        $sql = "SELECT * FROM animals WHERE id = :id"; // Use prepared statement
        $db = (new Database())->getConnection();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id); // Bind the ID
            $query->execute();
            $animal = $query->fetch();
            return $animal;
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function updateAnimal($animal, $id) {   
        try {
            $db =( new Database())->getConnection();
            $query = $db->prepare(
                'UPDATE animals SET 
                    name = :name,
                    description = :description,
                    state = :state
                WHERE id = :idanimal'
            );
            
            $query->execute([
                'idanimal' => $id,
                'name' => $animal->getName(), // Ensure correct method name
                'description' => $animal->getDescription(), // Include description
                'state' => $animal->getState() // Include state
            ]);
            
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo 'Error updating animal: ' . $e->getMessage();
        }
    }
}
?>