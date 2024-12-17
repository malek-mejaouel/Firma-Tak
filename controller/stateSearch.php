<?php
require_once(__DIR__ . '/../config/database.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$state = isset($_GET['state']) ? $_GET['state'] : '';

// Check if the state parameter is provided
if ($state) {
    $query = "SELECT * FROM states WHERE name LIKE :state";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['state' => '%' . $state . '%']);

    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $filteredData = array_filter($data, function($item) use ($state) {
            similar_text($item['name'], $state, $percent);
            return $percent >= 80;
        });

        echo json_encode(['success' => true, 'data' => array_values($filteredData)]);
    } else {
        echo json_encode(['success' => false, 'message' => 'This state doesn\'t exist in Tunis']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid state to search for.']);
}
?>
