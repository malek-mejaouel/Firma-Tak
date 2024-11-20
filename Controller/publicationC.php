<?php

require '../../config.php';

class PublicationC
{

    public function listPublications()
    {
        $sql = "SELECT * FROM post"; // Assurez-vous que le nom de la table est correct
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll(); // fetchAll() pour retourner les données sous forme de tableau
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage()); // Utilisez getMessage() pour obtenir le message de l'exception
        }
    }
    

    function deletePublication($ide)
    {
        $sql = "DELETE FROM post WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $ide);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }


    function addPublication($publication)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'INSERT INTO post (Titre, Lien, Contenu, Date) 
                 VALUES (:Titre, :Lien, :Contenu, :Date)'
            );
            
            $query->execute([
                'Titre' => $publication->getTitle(),
                'Lien' => $publication->getLink(),
                'Contenu' => $publication->getContent(),
                'Date' => $publication->getCreationDate(),
            ]);
            
            echo "Publication added successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    

    function showPublication($id)
    {
        $sql = "SELECT * from post where id = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $publication = $query->fetch();
            return $publication;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    function updatePublication($publication, $id)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE post SET 
                    Titre = :Titre, 
                    Lien = :Lien, 
                    Contenu = :Contenu, 
                    Date = :Date 
                 WHERE ID = :idPublication'
            );
            
            $query->execute([
                'idPublication' => $id,
                'Titre' => $publication->getTitle(),
                'Lien' => $publication->getLink(),
                'Contenu' => $publication->getContent(),
                'Date' => $publication->getCreationDate(),
            ]);
            
            echo $query->rowCount() . " record(s) UPDATED successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
}
