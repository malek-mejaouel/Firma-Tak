<?php

require_once '../config/database.php';

class PublicationC
{
    // List all publications (without pagination)
    public function listPublications()
    {
        $sql = "SELECT * FROM post"; // Make sure the table name is correct
        $database = new Database();  // Create an instance of Database
        $db = $database->getConnection();  // Get the connection
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll(); // Return all results
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Delete a publication by ID
    function deletePublication($ide)
    {
        $sql = "DELETE FROM post WHERE id = :id";
        $database = new Database();  // Create an instance of Database
        $db = $database->getConnection();  // Get the connection
        $req = $db->prepare($sql);
        $req->bindValue(':id', $ide);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Add a new publication
    function addPublication($publication)
    {
        try {
            $database = new Database();  // Create an instance of Database
            $db = $database->getConnection();  // Get the connection
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

    // Show a single publication by ID
    function showPublication($id)
    {
        $sql = "SELECT * FROM post WHERE id = :id";
        $database = new Database();  // Create an instance of Database
        $db = $database->getConnection();  // Get the connection
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Update a publication
    function updatePublication($publication, $id)
    {
        try {
            $database = new Database();  // Create an instance of Database
            $db = $database->getConnection();  // Get the connection
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

    // Method to fetch publications with pagination
    public function listPublicationsByPage($page, $limit)
    {
        $offset = ($page - 1) * $limit; // Calculate the offset
        $sql = "SELECT * FROM post LIMIT :limit OFFSET :offset";
        $database = new Database();  // Create an instance of Database
        $db = $database->getConnection();  // Get the connection
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Method to count the total number of publications (useful for pagination)
    public function countPublications()
    {
        $sql = "SELECT COUNT(*) AS total FROM post"; // Ensure this matches your table name
        $database = new Database();  // Create an instance of Database
        $db = $database->getConnection();  // Get the connection
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total']; // Returns the total count of publications
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function listPublicationsByPageAndSort($page, $limit, $sortOrder) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM post ORDER BY Titre $sortOrder LIMIT :limit OFFSET :offset";  // Changer "publications" en "post" (si nécessaire)
        $database = new Database();  // Create an instance of Database
        $db = $database->getConnection();  // Get the connection
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get statistics of comments
    public function getStatistiquesCommentaires() {
        $database = new Database();  // Create an instance of Database
        $db = $database->getConnection();  // Get the connection
        $sql = "SELECT id_post, COUNT(id_c) AS nb_commentaires FROM commentaire GROUP BY id_post";
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $statistiques = $query->fetchAll(PDO::FETCH_ASSOC);
            // Add default color to each publication
            foreach ($statistiques as &$stat) {
                $stat['couleur'] = '#007bff'; // You can use any default color here
            }
            return $statistiques;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Search publications by title, content, or date
    function recherche($rech)
    {
        // SQL query to search in the 'Titre', 'contenu', and 'date' columns
        $sql = "SELECT * FROM post WHERE Titre LIKE :rech OR contenu LIKE :rech OR date LIKE :rech";
        $database = new Database();  // Create an instance of Database
        $db = $database->getConnection();  // Get the connection
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute(['rech' => "%$rech%"]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    
    public function searchPublications($searchTerm, $page = 1, $limit = 3) {
        try {
            $database = new Database();  // Create an instance of Database
            $db = $database->getConnection();  // Get the connection
            
            // Count total results for pagination
            $countQuery = "SELECT COUNT(*) FROM post WHERE Titre LIKE :searchTerm";
            $countStmt = $db->prepare($countQuery);
            $countStmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
            $total = $countStmt->fetchColumn();
            
            // Calculate offset for pagination
            $offset = ($page - 1) * $limit;
            
            // Main query with LIMIT and OFFSET for pagination
            $query = "SELECT * FROM post WHERE Titre LIKE :searchTerm ORDER BY Date DESC LIMIT :limit OFFSET :offset";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return [
                'publications' => $stmt->fetchAll(),
                'total' => $total
            ];
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Get publication statistics (e.g., number of comments per publication)
    public function getPublicationStats() {
        try {
            $database = new Database();  // Create an instance of Database
            $db = $database->getConnection();  // Get the connection
            $query = "SELECT p.Titre, COUNT(c.id_c) as nb_commentaires 
                     FROM post p 
                     LEFT JOIN commentaire c ON p.ID = c.id_post 
                     GROUP BY p.ID, p.Titre 
                     ORDER BY nb_commentaires DESC";
            
            $stmt = $db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
?>










