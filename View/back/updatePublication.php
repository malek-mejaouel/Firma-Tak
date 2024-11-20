<?php

include '../../Controller/PublicationC.php';  // Remplacer JoueurC par PublicationC
include '../../model/Publication.php';        // Remplacer Joueur par Publication
$error = "";

// create publication
$publication = null;
// create an instance of the controller
$publicationC = new PublicationC();


if (
    isset($_POST["titre"]) &&
    isset($_POST["lien"]) &&
    isset($_POST["contenu"]) &&
    isset($_POST["date_creation"])
) {
    if (
        !empty($_POST['titre']) &&
        !empty($_POST["lien"]) &&
        !empty($_POST["contenu"]) &&
        !empty($_POST["date_creation"])
    ) {
        // Afficher les données soumises pour le débogage
        foreach ($_POST as $key => $value) {
            echo "Key: $key, Value: $value<br>";
        }

        $publication = new Publication(
            null,  // L'ID sera attribué automatiquement
            $_POST['titre'],
            $_POST['lien'],
            $_POST['contenu'],
            $_POST['date_creation']
        );
        var_dump($publication);

        // Mettre à jour la publication dans la base de données
        $publicationC->updatePublication($publication, $_POST['idPublication']);

        // Rediriger vers la liste des publications après la mise à jour
        header('Location:index.php');
        exit();
    } else {
        $error = "Missing information";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Publication</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Global styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .side-menu {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            position: fixed;
            top: 0;
            bottom: 0;
            padding: 20px 0;
        }

        .side-menu .brand-name {
            text-align: center;
            padding-bottom: 20px;
        }

        .side-menu img {
            width: 50px;
            vertical-align: middle;
        }

        .side-menu h2 {
            display: inline-block;
            font-size: 18px;
            margin: 0;
        }

        .side-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .side-menu ul a {
            text-decoration: none;
            color: #ecf0f1;
            display: block;
            padding: 15px;
        }

        .side-menu ul a:hover {
            background-color: #34495e;
        }

        .side-menu ul a li {
            display: flex;
            align-items: center;
        }

        .side-menu ul a li img {
            width: 20px;
            margin-right: 10px;
        }

        /* Top navbar */
        .nav-bar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .nav-bar h1 {
            margin: 0;
            font-size: 18px;
        }

        /* Main content */
        .main-content {
            margin: 60px 20px 20px 270px;
            flex: 1;
        }

        /* Form styling */
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        form table {
            width: 100%;
        }

        form table td {
            padding: 10px 0;
        }

        form input, form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form input[type="submit"], form input[type="reset"] {
            width: auto;
            padding: 10px 20px;
            background-color: #2980b9;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        form input[type="submit"]:hover, form input[type="reset"]:hover {
            background-color: #1f618d;
        }

        /* Error message */
        #error {
            text-align: center;
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="side-menu">
        <div class="brand-name">
            <img src="images/logos.png" alt="Logo">
            <h2>FIRMA-TAK</h2>
        </div>
        <ul>
            <a href="#">
                <li><img src="images/dashboard (2).png" alt="">&nbsp; Dashboard</li>
            </a>
            <a href="index.php">
                <li><img src="images/reading-book (1).png" alt="">&nbsp; Publications</li>
            </a>
        </ul>
    </div>

    <!-- Top Nav-bar -->
    <div class="nav-bar">
        <h1>Update Publication</h1>
        <button><a href="listPublications.php" style="color: white; text-decoration: none;">Back to List</a></button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div id="error"><?php echo $error; ?></div>

        <?php
        if (isset($_POST['idPublication'])) {
            $publication = $publicationC->showPublication($_POST['idPublication']);
        ?>

        <form action="" method="POST">
            <table>
                <tr>
                    <td><label for="idPublication">Publication ID :</label></td>
                    <td><input type="text" id="idPublication" name="idPublication" value="<?php echo $_POST['idPublication'] ?>" readonly /></td>
                </tr>
                <tr>
                    <td><label for="titre">Title :</label></td>
                    <td><input type="text" id="titre" name="titre" value="<?php echo $publication['Titre'] ?>" /></td>
                </tr>
                <tr>
                    <td><label for="lien">Link :</label></td>
                    <td><input type="text" id="lien" name="lien" value="<?php echo $publication['Lien'] ?>" /></td>
                </tr>
                <tr>
                    <td><label for="contenu">Content :</label></td>
                    <td><textarea id="contenu" name="contenu"><?php echo $publication['Contenu'] ?></textarea></td>
                </tr>
                <tr>
                    <td><label for="date_creation">Creation Date :</label></td>
                    <td><input type="date" id="date_creation" name="date_creation" value="<?php echo $publication['Date'] ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" value="Save">
                        <input type="reset" value="Reset">
                    </td>
                </tr>
            </table>
        </form>

        <?php } ?>
    </div>


   


     <script>
// Fonction de validation
function validateForm(event) {
    // Réinitialiser les messages d'erreur
    document.getElementById("erreurTitre").innerText = "";
    document.getElementById("erreurLien").innerText = "";
    document.getElementById("erreurDate").innerText = "";
    document.getElementById("erreurContenu").innerText = "";

    // Variables pour les erreurs
    let isValid = true;

    // Récupérer les valeurs des champs
    const titre = document.getElementById("titre").value;
    const lien = document.getElementById("lien").value;
    const date = document.getElementById("date").value;
    const contenu = document.getElementById("contenu").value;

    // Validation du champ "Titre"
    if (titre.trim() === "") {
        document.getElementById("erreurTitre").innerText = "Le titre est requis.";
        isValid = false;
    }

    // Validation du champ "Lien"
    if (lien.trim() === "") {
        document.getElementById("erreurLien").innerText = "Le lien est requis.";
        isValid = false;
    } else if (!isValidURL(lien)) {
        document.getElementById("erreurLien").innerText = "Le lien n'est pas valide. Assurez-vous qu'il commence par 'http://' ou 'https://'.";
        isValid = false;
    }

    // Validation du champ "Date"
    if (date.trim() === "") {
        document.getElementById("erreurDate").innerText = "La date est requise.";
        isValid = false;
    }

    // Validation du champ "Contenu"
    if (contenu.trim() === "") {
        document.getElementById("erreurContenu").innerText = "Le contenu est requis.";
        isValid = false;
    } else if (!isValidContent(contenu)) {
        document.getElementById("erreurContenu").innerText = "Le contenu ne doit pas dépasser 25 mots.";
        isValid = false;
    }

    // Si tout est valide, on soumet le formulaire, sinon on empêche l'envoi
    if (!isValid) {
        event.preventDefault();
    }
}

// Fonction pour vérifier si l'URL est valide
function isValidURL(url) {
    const pattern = new RegExp("^(https?:\\/\\/)?([a-z0-9]+[.])+[a-z0-9]+(\\/.*)?$", "i");
    return pattern.test(url);
}

// Fonction pour vérifier si le contenu ne dépasse pas 25 mots
function isValidContent(content) {
    const wordCount = content.trim().split(/\s+/).length;
    return wordCount <= 25;
}

// Ajouter l'écouteur d'événement pour la soumission du formulaire
document.querySelector("form").addEventListener("submit", validateForm);
</script>
</body>

</html>
