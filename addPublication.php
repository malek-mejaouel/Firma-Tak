<?php

include '../../Controller/PublicationC.php';
include '../../model/Publication.php';

$error = "";

// Create publication
$publication = null;

// Create an instance of the controller
$publicationC = new PublicationC();
if (
    isset($_POST["titre"]) &&
    isset($_POST["lien"]) &&
    isset($_POST["date"]) &&
    isset($_POST["contenu"])
) {
    if (
        !empty($_POST['titre']) &&
        !empty($_POST["lien"]) &&
        !empty($_POST["date"]) &&
        !empty($_POST["contenu"])
    ) {
        $publication = new Publication(
            null,
            $_POST['titre'],
            $_POST['lien'],
            $_POST['date'],
            $_POST['contenu']
        );
        $publicationC->addPublication($publication);
        header('Location:index.php');
    } else {
        $error = "Missing information";
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Sidebar -->
    <div class="side-menu">
        <div class="brand-name">
            <img src="images/logos.png" alt="">&nbsp;<h2>FIRMA-TAK</h2>
        </div>
        <ul>
            <a href="#"><li><img src="images/dashboard (2).png" alt="">&nbsp; <span>Dashboard</span> </li></a>
            <a href="index.php"><li><img src="images/reading-book (1).png" alt="">&nbsp;<span>Publications</span> </li></a>
        </ul>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Navbar -->
     

        <!-- Form Section -->
        <div class="form-container">
            <h1>Add Publication</h1>
            <div id="error">
                <?php echo $error; ?>
            </div>
            <form action="" method="POST">
                <table>
                    <tr>
                        <td><label for="titre">Title:</label></td>
                        <td>
                            <input type="text" id="titre" name="titre" />
                            <span id="erreurTitre" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="lien">Link:</label></td>
                        <td>
                            <input type="text" id="lien" name="lien" />
                            <span id="erreurLien" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="date">Date:</label></td>
                        <td>
                            <input type="date" id="date" name="date" />
                            <span id="erreurDate" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="contenu">Content:</label></td>
                        <td>
                            <textarea id="contenu" name="contenu" rows="4" cols="50"></textarea>
                            <span id="erreurContenu" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Save">
                        </td>
                        <td>
                            <input type="reset" value="Reset">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <script src="fonction.js">
        
    </script>
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
