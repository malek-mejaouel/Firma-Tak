<?php
include '../../Controller/ProductC.php';

// Create an instance of the product controller
$produitC = new ProductC();

// Delete the product with the ID passed as a parameter
if (isset($_GET["id"])) {
    $produitC->deleteProduct($_GET["id"]);
}

// Redirect to the list of products
header('Location: index.php');
exit();
?>
