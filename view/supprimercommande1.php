<?php
include '../Controller/commandeC.php';

// Vérification si un identifiant de commande est passé
if (isset($_GET["id_commande"])) {
    $idToDelete = $_GET["id_commande"];
    
    // Créer une instance du contrôleur des commandes
    $commandeController = new commandeC();
    
    // Appeler la méthode de suppression pour la commande
    $commandeController->supprimer($idToDelete);
    
    // Redirection vers la page d'accueil ou la liste des commandes
    header('Location:index.php');
} 
else 
{
    // Afficher un message d'erreur si la requête est invalide
    echo "Requête invalide. Aucun identifiant de commande fourni.";
}
?>
