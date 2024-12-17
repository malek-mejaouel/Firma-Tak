<?php
require_once(__DIR__ . '/../../controller/animalsC.php'); // Ensure this is correct
$clientC = new AnimalC(); // Correct case for the class name
$clientC->deleteAnimal($_GET["id"]);
header('Location:animalsindex.php');