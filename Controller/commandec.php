<?php

require_once  '../../config.php';

class commandeC
{
    // Fonction pour filtrer les mauvaises quantités (si nécessaire)
    function filter($quantite)
    {
        // Par exemple, éviter les quantités inférieures ou égales à 0
        if ($quantite <= 0) {
            return 1; // On remplace par une quantité valide
        }
        return $quantite;
    }

    // Afficher les commandes d'un produit spécifique
    public function afficher($id_produit)
    {
        $sql = "SELECT * FROM commande WHERE ID_Produit = :id_produit";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
            $stmt->execute();
            $liste = $stmt->fetchAll();
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Supprimer une commande
    function supprimer($id_commande)
    {
        $sql = "DELETE FROM commande WHERE ID_Commande = :id_commande";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_commande', $id_commande);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Ajouter une nouvelle commande
    function ajouter($commande)
    {
        // Filtrer la quantité de la commande
        $filteredQuantite = $this->filter($commande->getQuantiteCommande());

        $sql = "INSERT INTO commande (ID_Produit, Quantite_Commande, Date_Commande)
                VALUES (:id_produit, :quantite_commande, :date_commande)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_produit' => $commande->getIdProduit(),
                'quantite_commande' => $filteredQuantite,
                'date_commande' => $commande->getDateCommande()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Modifier une commande existante
    function modifier($commande, $id_commande)
    {
        // Filtrer la quantité de la commande
        $filteredQuantite = $this->filter($commande->getQuantiteCommande());

        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE commande SET 
                    Quantite_Commande = :quantite_commande, 
                    Date_Commande = :date_commande,
                    ID_Produit = :id_produit
                WHERE ID_Commande = :id_commande'
            );
            $query->execute([
                'id_commande' => $id_commande,
                'quantite_commande' => $filteredQuantite,
                'date_commande' => $commande->getDateCommande(),
                'id_produit' => $commande->getIdProduit()
            ]);
            echo $query->rowCount() . " record(s) UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Récupérer une commande spécifique par son ID
    function recupererCommande($id_commande)
    {
        $sql = "SELECT * FROM commande WHERE ID_Commande = :id_commande";
        $conn = new config();
        $db = $conn->getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id_commande', $id_commande, PDO::PARAM_INT);
            $query->execute();
            $reponse = $query->fetch();
            return $reponse;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Récupérer le produit d'une commande
    function recupererProduit($id_produit)
    {
        $sql = "SELECT * FROM produit WHERE ID_Produit = :id_produit";
        $conn = new config();
        $db = $conn->getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
}
?>
