<?php

require_once '../../config.php';

class ProductC
{
    // List all products (without pagination)
    public function listProducts()
    {
        $sql = "SELECT * FROM produit"; // Table name changed to 'produit'
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll(); // Return all results
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Delete a product by ID
    function deleteProduct($id)
    {
        $sql = "DELETE FROM produit WHERE ID_Produit = :id";  // Changed from 'id' to 'ID_Produit'
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Add a new product
    function addProduct($product)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'INSERT INTO produit (Nom_Produit, Quantite, Prix_Unitaire) 
                 VALUES (:Nom_Produit, :Quantite, :Prix_Unitaire)'
            );

            $query->execute([
                'Nom_Produit' => $product->getName(),
                'Quantite' => $product->getQuantity(),
                'Prix_Unitaire' => $product->getPrice(),
            ]);

            echo "Product added successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Show a single product by ID
    function showProduct($id)
    {
        $sql = "SELECT * FROM produit WHERE ID_Produit = :id"; // Changed from 'id' to 'ID_Produit'
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Update a product
    function updateProduct($product, $id)
    {
        try {
            $db = config::getConnexion();
            $query = $db->prepare(
                'UPDATE produit SET 
                    Nom_Produit = :Nom_Produit, 
                    Quantite = :Quantite, 
                    Prix_Unitaire = :Prix_Unitaire 
                 WHERE ID_Produit = :idProduct'
            );

            $query->execute([
                'idProduct' => $id,
                'Nom_Produit' => $product->getName(),
                'Quantite' => $product->getQuantity(),
                'Prix_Unitaire' => $product->getPrice(),
            ]);

            echo $query->rowCount() . " record(s) UPDATED successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Method to fetch products with pagination
    public function listProductsByPage($page, $limit)
    {
        $offset = ($page - 1) * $limit; // Calculate the offset
        $sql = "SELECT * FROM produit LIMIT :limit OFFSET :offset"; // Changed from 'post' to 'produit'
        $db = config::getConnexion();
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
    public function getTotalProducts()
    {
        // SQL query to count the total number of products
        $sql = "SELECT COUNT(*) AS total FROM produit"; // Remplacez 'produit' par le nom de votre table si nécessaire
        $db = config::getConnexion(); // Connexion à la base de données via la méthode de la classe config
        try {
            // Préparer et exécuter la requête SQL
            $query = $db->prepare($sql);
            $query->execute();
            
            // Récupérer le résultat de la requête
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            // Retourner le nombre total de produits
            return $result['total'];
        } catch (Exception $e) {
            // En cas d'erreur, afficher un message d'erreur
            die('Error: ' . $e->getMessage());
        }
    }
    
    // Method to count the total number of products (useful for pagination)
    public function countProducts()
    {
        $sql = "SELECT COUNT(*) AS total FROM produit"; // Changed to 'produit'
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total']; // Returns the total count of products
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Method to search for products
    public function search($searchTerm)
    {
        // Search in 'Nom_Produit', 'Quantite', and 'Prix_Unitaire' columns
        $sql = "SELECT * FROM produit WHERE Nom_Produit LIKE :search OR Quantite LIKE :search OR Prix_Unitaire LIKE :search";
        $db = config::getConnexion();
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute(['search' => "%$searchTerm%"]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Method to sort products by name (ascending/descending) and with pagination
   
    public function listProductsByPageAndSort($page, $limit, $sortOption, $sortOrder = 'ASC') {
        // Sécuriser l'option de tri pour éviter l'injection SQL
        $allowedSortOptions = ['nom', 'quantite', 'prix'];
        if (!in_array($sortOption, $allowedSortOptions)) {
            $sortOption = 'nom'; // Tri par défaut
        }
    
        // Vérifier l'ordre de tri pour éviter l'injection SQL (ASC ou DESC)
        $allowedSortOrders = ['ASC', 'DESC'];
        if (!in_array(strtoupper($sortOrder), $allowedSortOrders)) {
            $sortOrder = 'ASC'; // Ordre par défaut
        }
    
        // Calculer la limite pour la pagination
        $offset = ($page - 1) * $limit;
    
        // Requête SQL avec tri et pagination
        $sql = "SELECT * FROM produit ORDER BY " . $sortOption . " " . $sortOrder . " LIMIT :limit OFFSET :offset";
    
        // Préparer la requête
        $db = config::getConnexion();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
        // Exécuter la requête
        $stmt->execute();
    
        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Include TCPDF library
 // Incluez le chemin correct

public function generatePDF()
{
    // Créer une instance de TCPDF
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Titre du PDF
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Product List', 0, 1, 'C');

    // Récupérer la liste des produits
    $products = $this->listProducts();  // Vous pouvez utiliser listProductsByPage ici si vous voulez une pagination

    // Ajouter les produits dans le PDF
    $pdf->SetFont('Helvetica', '', 12);
    foreach ($products as $product) {
        $pdf->Cell(0, 10, 'ID: ' . $product['ID_Produit'] . ' - ' . $product['Nom_Produit'] . ' - Quantité: ' . $product['Quantite'] . ' - Prix: ' . $product['Prix_Unitaire'], 0, 1);
    }

    // Sauvegarder ou afficher le PDF
    $pdf->Output('products_list.pdf', 'I');
}

public function sortByQuantity($sortOrder = 'ASC')
{
    // Sécuriser l'option de tri pour éviter l'injection SQL
    $allowedSortOrders = ['ASC', 'DESC'];
    if (!in_array(strtoupper($sortOrder), $allowedSortOrders)) {
        $sortOrder = 'ASC'; // Ordre par défaut
    }

    $sql = "SELECT * FROM produit ORDER BY Quantite $sortOrder";
    $db = config::getConnexion();
    try {
        $query = $db->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

}
