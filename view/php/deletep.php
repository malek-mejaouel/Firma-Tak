<?php
require_once(__DIR__ . '/../../controller/plantsC.php'); // Ensure this is correct
$clientC = new PlantC(); // Correct case for the class name
$clientC->deletePlant($_GET["id"]);
header('Location:plantsindex.php');