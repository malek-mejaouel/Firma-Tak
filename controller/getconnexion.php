<?php

require_once(__DIR__ . '/../config/database.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    $conn = (new Database())->getConnection();
    $state = 'Sfax'; // Change this to test other states
    $stmt = $conn->prepare("SELECT name, description FROM animals WHERE state = :state");
    $stmt->bindParam(':state', $state, PDO::PARAM_STR);
    $stmt->execute();
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($animals);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}
?>