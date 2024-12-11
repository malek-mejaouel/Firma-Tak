<?php

include_once 'C:/xampp/htdocs/projetagriculture/config.php';


class commentaireC
{
    function filter($text)
    {
        $badWords = array('badword1', 'badword2', 'badword3'); 
    
        $words = explode(' ', strtolower($text)); // Convertir le texte en minuscules avant de l'exploder
        
        $filteredWords = array();
        
        foreach ($words as $word) {
            if (in_array($word, $badWords)) { // Comparer les mots sans tenir compte de la casse
                $filteredWords[] = '****'; 
            } else {
                $filteredWords[] = $word; 
            }
        }
        
        $filteredText = implode(' ', $filteredWords); 
        
        return $filteredText;
    }
    
   
















    public function afficher($id_post)
    {
        $sql = "SELECT * FROM commentaire WHERE id_post = :id_post";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT); // Assurez-vous de passer la bonne variable et de spécifier le type de données
            $stmt->execute();
            $liste = $stmt->fetchAll();
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    

    function supprimer($id_c)
    {
        $sql = "DELETE FROM commentaire WHERE id_c = :id_c";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_c', $id_c);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }


    function ajouter($commentaire)
    {
        $sql = "INSERT INTO commentaire (contenu, date, id_post, emoji) 
                VALUES (:contenu, :date, :id_post, :emoji)";
        
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'contenu' => $commentaire->getcontenu(),
                'date' => $commentaire->getDate(),
                'id_post' => $commentaire->getId(),
                'emoji' => $commentaire->getEmoji()
            ]);
        } catch (Exception $e) {
            echo 'Erreur: '.$e->getMessage();
        }
    }


    function modifier($commentaire, $id_c)
    {   $filtered = $this->filter($commentaire->getcontenu());
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE commentaire SET 
                    contenu = :$filtered, 
                    date = :date,
                    id_post = :id_post
                WHERE id_c= :id_c'
            );
            $query->execute([
                'id_c' => $id_c,
                'contenu' =>  $filtered,
                'date' => $commentaire->getDate(),
                'id_post' => $commentaire->getID()
            ]);
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    

    function recuperercommentaire($id_rep){
        $sql="SELECT * from commentaire where id_c=$id_rep";
        $conn = new config();
        $db=$conn->getConnexion();
        try{
            $query=$db->prepare($sql);
            $query->execute();

            $reponse=$query->fetch();
            return $reponse;
        }
        catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }
    }

    function recupererpost($id_post){
        $sql="SELECT * from post where id_post=$id_post";
        $conn = new config();
        $db=$conn->getConnexion();
        try{
            $liste = $db->query($sql);
            return $liste;
        }
        catch (Exception $e){
            die('Erreur: '.$e->getMessage());
        }
    }



   /* function modifierEtatReclamation($id_rec, $nouvelEtat)
    {
        $sql = "UPDATE reclamation SET etat = :nouvel_etat WHERE id_r = :id_r";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nouvel_etat' => $nouvelEtat,
                'id_rec' => $id_rec
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }*/
    
    


}