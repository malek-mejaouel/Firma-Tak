<?php
require_once '../model/LandRent.php';

class LandRentController {
    private $conn;

    // Constructor to receive the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // List all lands
    public function listLands() {
        $landRentModel = new LandRent($this->conn);  // Instantiate the LandRent model
        return $landRentModel->getAllLands();  // Call the method from the model
    }

    // Create a new land
    public function createLand($land_id, $owner, $number, $size_km2, $price_per_year) {
        $landRentModel = new LandRent($this->conn);  // Instantiate the LandRent model
        return $landRentModel->createLand($land_id, $owner, $number, $size_km2, $price_per_year);
    }

    // Fetch rented lands
    public function getRentedLands() {
        $landRentModel = new LandRent($this->conn);  // Instantiate the LandRent model
        return $landRentModel->getRentedLands();  // Call the method from the model
    }

    // View a land by ID
    public function viewLand($id) {
        $landRentModel = new LandRent($this->conn);  // Instantiate the LandRent model
        return $landRentModel->getLandById($id);
    }

    // Edit land details
    public function editLand($id, $land_id, $size_km2, $price_per_year) {
        $landRentModel = new LandRent($this->conn);  // Instantiate the LandRent model
        return $landRentModel->updateLand($id, $land_id, $size_km2, $price_per_year);
    }

    // Delete a land
    public function deleteLand($id) {
        // Ensure the LandRent model is instantiated
        $landRentModel = new LandRent($this->conn);
        return $landRentModel->deleteLand($id);  // Call the deleteLand method from the model
    }

    // Search for a land by ID
    public function searchLandById($landId) {
        $landRentModel = new LandRent($this->conn);  // Instantiate the LandRent model
        return $landRentModel->getLandById($landId);
    }

    // Mark land as rented
    public function markLandAsRented($land_id) {
        $landRentModel = new LandRent($this->conn);  // Instantiate the LandRent model
        return $landRentModel->markLandAsRented($land_id);
    }
}
?>
