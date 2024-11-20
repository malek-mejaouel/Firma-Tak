<?php
include '../../Controller/PublicationC.php';

// Créer une instance du contrôleur des publications
$publicationC = new PublicationC();

// Supprimer la publication avec l'ID passé en paramètre
if (isset($_GET["id"])) {
    $publicationC->deletePublication($_GET["id"]);
}

// Rediriger vers la liste des publications
header('Location:index.php');
exit();
?>
