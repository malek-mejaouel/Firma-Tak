<?php
require_once '../config/database.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL); // Report all errors
ini_set('display_errors', 1); // Display errors

$state = isset($_GET['state']) ? $_GET['state'] : '';

// Check if the state parameter is provided
if ($state) {
    // Prepare the SQL query to search for states
    $query = "SELECT * FROM states WHERE name LIKE :state";
    $stmt = $pdo->prepare($query);
    
    // Bind the search term and execute the query
    $stmt->execute(['state' => '%' . $state . '%']);

    // Check if any results were found
    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Return the results as JSON
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        // Return an error message if no state was found
        echo json_encode(['success' => false, 'message' => 'This state doesn\'t exist in Tunis']);
    }
} else {
    // Return an error message if the 'state' parameter is missing
    echo json_encode(['success' => false, 'message' => 'Please provide a valid state to search for.']);
}
?>