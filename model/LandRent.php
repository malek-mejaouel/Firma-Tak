<?php
class LandRent {
    private $conn;  // The database connection

    // Constructor to receive the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function listLands() {
        // Create an instance of the LandRent model
        $landRentModel = new LandRent($this->conn);
        // Fetch all lands
        $lands = $landRentModel->getAllLands();
        // Return the fetched lands
        return $lands;
    }
    // Delete a land by ID
    public function deleteLand($id) {
        $query = "DELETE FROM lands WHERE id = :id";  // Delete query
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();  // Execute the query and return the result
    }
    // Function to get all lands
    public function getAllLands() {
        $query = "SELECT * FROM lands";  // Example query to get all lands
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Function to get land by ID
    public function getLandById($id) {
        $query = "SELECT * FROM lands WHERE land_id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Function to create a new land
    public function createLand($land_id, $owner, $number, $size_km2, $price_per_year) {
        $query = "INSERT INTO lands (land_id, owner, number, size_km2, price_per_year)
                  VALUES (:land_id, :owner, :number, :size_km2, :price_per_year)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':land_id', $land_id);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':size_km2', $size_km2);
        $stmt->bindParam(':price_per_year', $price_per_year);
        return $stmt->execute();
    }

    // Function to update land details
    public function updateLand($id, $land_id, $size_km2, $price_per_year) {
        $query = "UPDATE lands SET land_id = :land_id, size_km2 = :size_km2, price_per_year = :price_per_year WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':land_id', $land_id);
        $stmt->bindParam(':size_km2', $size_km2);
        $stmt->bindParam(':price_per_year', $price_per_year);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Function to delete a land
   

    // Function to get rented lands
    public function getRentedLands() {
        $query = "SELECT 
                    rl.land_id, 
                    l.owner, 
                    l.size_km2, 
                    l.price_per_year, 
                    rl.renter_name, 
                    rl.renter_phone, 
                    rl.rent_date 
                FROM rented_lands rl
                INNER JOIN lands l ON rl.land_id = l.land_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
