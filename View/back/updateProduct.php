<?php
include '../../Controller/ProductC.php';  // Changed from PublicationC to ProduitC
include '../../model/Product.php';        // Changed from Publication to Produit

$error = "";

// create product
$product = null;
// create an instance of the controller
$produitC = new ProductC();

// Fetch product ID from the URL (GET method)
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    // Retrieve the product from the database
    $product = $produitC->showProduct($productId);
}

// Handle form submission
if (
    isset($_POST["productName"]) &&
    isset($_POST["quantity"]) &&
    isset($_POST["unitPrice"]) &&
    isset($_POST["idProduct"])
) {
    if (
        !empty($_POST['productName']) &&
        !empty($_POST["quantity"]) &&
        !empty($_POST["unitPrice"])
    ) {
        // Create product instance with updated data
        $product = new Produit(
            $_POST['idProduct'],
            $_POST['productName'],
            $_POST['quantity'],
            $_POST['unitPrice']
        );

        // Update product in the database
        $produitC->updateProduct($product, $productId);

        // Redirect to the product list after the update
        header('Location: index.php');
        exit();
    } else {
        $error = "Missing information 😟";
    }
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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f7;
            margin: 0;
        }

       
        .container {
            width: 80%;
            padding: 20px;
            background-color: #ecf0f1;
            min-height: 100vh;
            color: #2c3e50;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        #error {
            color: red;
            text-align: center;
            font-size: 16px;
        }

        form table {
            width: 100%;
            margin-top: 20px;
        }

        form table td {
            padding: 10px;
            font-size: 16px;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="submit"],
        form input[type="reset"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form input[type="submit"],
        form input[type="reset"] {
            width: auto;
            background-color: #2980b9;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            padding: 10px 20px;
        }

        form input[type="submit"]:hover,
        form input[type="reset"]:hover {
            background-color: #3498db;
            transition: background-color 0.3s;
        }

        #errorProductName,
        #errorQuantity,
        #errorUnitPrice {
            color: red;
            font-size: 14px;
        }

        .emoji {
            font-size: 18px;
            margin-right: 5px;
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
            <a href="#"><li><img src="images/dashboard (2).png" alt="">&nbsp; <span>Dashboard</span> </li></a>
            <a href="index.php"><li><img src="images/reading-book (1).png" alt="">&nbsp;<span>Products</span> </li></a>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div id="error"><?php echo $error; ?></div>

        <?php if ($product): ?>

        <div class="form-container">
            <h1>Edit Product <span class="emoji">✏️</span></h1>
            <form action="" method="POST">
                <table>
                    <tr>
                        <td><label for="idProduct">Product ID:</label></td>
                        <td><input type="text" id="idProduct" name="idProduct" value="<?php echo $product['ID_Produit']; ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td><label for="productName">Product Name:</label></td>
                        <td><input type="text" id="productName" name="productName" value="<?php echo $product['Nom_Produit']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="quantity">Quantity:</label></td>
                        <td><input type="number" id="quantity" name="quantity" value="<?php echo $product['Quantite']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="unitPrice">Unit Price:</label></td>
                        <td><input type="number" step="0.01" id="unitPrice" name="unitPrice" value="<?php echo $product['Prix_Unitaire']; ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <input type="submit" value="Save 📝">
                            <input type="reset" value="Reset 🔄">
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <?php else: ?>
            <div class="form-container">
                <p>Product not found 😞</p>
            </div>
        <?php endif; ?>

    </div>
</body>

</html>
