<?php
include 'C:/xampp/htdocs/projetagriculture/Controller/commentaireC.php';


if (isset($_GET["id_c"])) {
    $idToDelete = $_GET["id_c"];
    
    $d = new commentaireC();
    $d->supprimer($idToDelete);
    header('Location:index.php');
} 
else 
{
    echo "Invalid request.";
}


?>