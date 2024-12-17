<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ALPHA Web Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Your existing CSS styles go here */
    </style>
</head>
<style>
        body {
            display: flex;
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f7;
            margin: 0;
        }

        .container {
            width: 80%;
            padding: 20px;
            background-color: #ecf0f1;
            min-height: 100vh;
            color: rgb(95, 134, 80);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }

        table th {
            background-color: rgb(84, 130, 85);
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .header ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .header ul li a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: bold;
            padding: 8px;
            border-radius: 5px;
        }

        .header ul li a:hover {
            background-color: #2980b9;
            color: white;
            transition: background-color 0.3s;
        }

        h1,
        h2 {
            text-align: center;
            color: rgb(158, 188, 34);
            font-size: 28px;
        }

        h2 a {
            text-decoration: none;
            color: rgb(154, 185, 41);
            font-weight: bold;
        }

        h2 a:hover {
            color: rgb(132, 196, 37);
        }

        p {
            text-align: center;
            color: red;
        }

        .btn-primary {
            background-color: rgb(89, 185, 41);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #3498db;
            transition: background-color 0.3s;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transition: background-color 0.3s;
        }

        .btn-update {
            background-color: #f39c12;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-update:hover {
            background-color: #e67e22;
            transition: background-color 0.3s;
        }

        .btn-view {
            background-color: #16a085;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-view:hover {
            background-color: #1abc9c;
            transition: background-color 0.3s;
        }

        .emoji {
            font-size: 18px;
            margin-right: 5px;
        }

        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-container input {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #2980b9;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #3498db;
        }
    </style>
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
        <!-- Search Form -->
   

        <!-- Products Table -->
        <?php
        include "../../controller/productC.php"; // Updated to use ProductC class

        $c = new ProductC(); // Product controller instance

        // Handle Search and Sorting
        $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
        $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'ASC';

        if (!empty($searchTerm)) {
            $tab = $c->search($searchTerm); // Search products based on search term
        } else {
            $tab = $c->sortByQuantity($sortOrder); // Sort products by quantity (default order is 'ASC')
        }

        if (is_array($tab) && count($tab) > 0) {
        ?>     <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="searchTerm" placeholder="Search for a product..." value="<?= isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '' ?>">
            <button type="submit">Search 🔍</button>
        </form>
    </div>

    <!-- Sort Form -->
    <div class="sort-container" style="text-align: center; margin-bottom: 20px;">
        <form method="GET" action="">
            <label for="sortOrder">Sort by Quantity: </label>
            <select name="sortOrder" id="sortOrder" onchange="this.form.submit()">
                <option value="ASC" <?= (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'ASC') ? 'selected' : '' ?>>Ascending</option>
                <option value="DESC" <?= (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'DESC') ? 'selected' : '' ?>>Descending</option>
            </select>
        </form>
    </div>
            <h1>List of Products</h1>
            <h2>
                <a href="addProduct.php">Add Product ➕</a>
                
            </h2>
            <table>
                <tr>
                    <th>Id Product 🆔</th>
                    <th>Name 🏷️</th>
                    <th>Quantity 📦</th>
                    <th>Price 💰</th>
                    <th>Actions ⚙️</th>
                </tr>

                <?php
                foreach ($tab as $product) {
                ?>
                    <tr>
                        <td><?= $product['ID_Produit']; ?></td>
                        <td><?= $product['Nom_Produit']; ?></td>
                        <td><?= $product['Quantite']; ?></td>
                        <td><?= $product['Prix_Unitaire']; ?></td>
                        <td>
                            <a href="deleteProduct.php?id=<?= $product['ID_Produit']; ?>" class="btn-danger">Delete ❌</a>
                            <a href="updateProduct.php?id=<?= $product['ID_Produit']; ?>" class="btn-update">Update ✏️</a>
                            <a href="affichebackorder.php?id=<?= $product['ID_Produit']; ?>" class="btn-view">View Order 📝</a>
                            <a href="generatePDF.php?id=<?php echo $product['ID_Produit']; ?>" class="btn-primary" target="_blank">Télécharger le PDF</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        <?php
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>
</body>

</html>
