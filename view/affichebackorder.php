<?php
// Include the controller for the commandes
include_once '../Controller/commandeC.php';

// Create an instance of the commandeC controller
$commandeController = new commandeC();

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the product ID from the URL
    $id_product = $_GET['id'];
    
    // Call the afficher() method to fetch the orders for the given product ID
    $commandes = $commandeController->afficher($id_product);
} else {
    echo "<p>Veuillez sélectionner un produit pour voir les commandes.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ALPHA Web Admin Panel</title>
    <style>
        .side-menu ul li:hover {
            background-color: #495057;
        }

        .container {
            margin-left: 270px;
            padding: 20px;
        }

        .section-title {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 20px;
        }

        .commande-container {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .commande-container p {
            margin: 5px 0;
        }

        .commande-content {
            display: flex;
            flex-direction: column;
        }

        .commande-actions .btn {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            background-color: #dc3545;
            color: white;
            font-weight: bold;
            display: inline-block;
        }

        .commande-actions .btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="side-menu">
        <div class="brand-name">
            <img src="images/logos.png" alt="">&nbsp;<h2>FIRMA-TAK</h2>
        </div>
        <ul>
            <a href="#">
                <li><img src="images/dashboard (2).png" alt="">&nbsp; <span>Dashboard</span> </li>
            </a>
            <a href="index.php">
                <li><img src="images/reading-book (1).png" alt="">&nbsp;<span>Products</span> </li>
            </a>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h1 class="section-title">📦 Liste des Commandes</h1>
        
        <!-- Check if there are orders to display -->
        <?php if (!empty($commandes)) {
            // Loop through the orders and display them
            foreach ($commandes as $commande) { ?>
                <div class="commande-container" id="commande-<?= htmlspecialchars($commande['ID_Commande']); ?>">
                    <div class="commande-content">
                        <p><strong>🌐 ID Commande:</strong> <?= htmlspecialchars($commande['ID_Commande']); ?></p>
                        <p><strong>🏦 ID Produit:</strong> <?= htmlspecialchars($commande['ID_Produit']); ?></p>
                        <p><strong>➕ Quantité:</strong> <?= htmlspecialchars($commande['Quantite_Commande']); ?></p>
                        <p><strong>📅 Date:</strong> <?= htmlspecialchars($commande['Date_Commande']); ?></p>
                    </div>
                    <div class="commande-actions">
                        <a href="supprimercommande.php?id_commande=<?= htmlspecialchars($commande['ID_Commande']); ?>" class="btn btn-outline-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette commande ?');">❌ Supprimer</a>
                    </div>
                </div>
            <?php }
        } else {
            echo "<p>Aucune commande à afficher pour ce produit.</p>";
        } ?>
    </div>

    <footer>
        <p>&copy; 2024 ALPHA Web Admin Panel</p>
    </footer>
</body>
</html>
