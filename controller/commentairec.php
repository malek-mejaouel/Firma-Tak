<?php

require_once '../config/database.php';

class commentaireC
{
    function filter($text)
    {
        $badWords = array('badword1', 'badword2', 'badword3'); 
        $words = explode(' ', strtolower($text)); // Convert text to lowercase before exploding
        $filteredWords = array();
        
        foreach ($words as $word) {
            if (in_array($word, $badWords)) { 
                $filteredWords[] = '****'; 
            } else {
                $filteredWords[] = $word; 
            }
        }
        
        return implode(' ', $filteredWords); 
    }

    public function afficher($id_post)
    {
        $sql = "SELECT * FROM commentaire WHERE id_post = :id_post";
        $db = (new Database())->getConnection(); // Updated to use getConnection()
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    function supprimer($id_c)
    {
        $sql = "DELETE FROM commentaire WHERE id_c = :id_c";
        $db = (new Database())->getConnection(); // Updated to use getConnection()
        try {
            $req = $db->prepare($sql);
            $req->bindValue(':id_c', $id_c);
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    function ajouter($commentaire)
    {
        $sql = "INSERT INTO commentaire (contenu, date, id_post, emoji) 
                VALUES (:contenu, :date, :id_post, :emoji)";
        $db = (new Database())->getConnection(); // Updated to use getConnection()
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'contenu' => $commentaire->getcontenu(),
                'date' => $commentaire->getDate(),
                'id_post' => $commentaire->getId(),
                'emoji' => $commentaire->getEmoji()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function modifier($commentaire, $id_c)
    {
        $filtered = $this->filter($commentaire->getcontenu());
        $sql = "UPDATE commentaire SET 
                contenu = :contenu, 
                date = :date,
                id_post = :id_post
                WHERE id_c = :id_c";
        $db = (new Database())->getConnection(); // Updated to use getConnection()
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'contenu' => $filtered,
                'date' => $commentaire->getDate(),
                'id_post' => $commentaire->getID(),
                'id_c' => $id_c
            ]);
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function recuperercommentaire($id_rep)
    {
        $sql = "SELECT * FROM commentaire WHERE id_c = :id_rep";
        $db = (new Database())->getConnection(); // Updated to use getConnection()
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id_rep', $id_rep, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    function recupererpost($id_post)
    {
        $sql = "SELECT * FROM post WHERE id_post = :id_post";
        $db = (new Database())->getConnection(); // Updated to use getConnection()
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id_post', $id_post, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
