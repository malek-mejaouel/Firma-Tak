<?php
// Inclure le fichier nécessaire pour récupérer les publications
include_once 'C:/xampp/htdocs/projetagriculture/Controller/commentaireC.php';  // Remplacez par le chemin correct vers votre fichier PublicationC.php

// Créer une instance du contrôleur des publications
$commentaireController = new commentaireC();
    
if(isset($_GET['id'])) {
    $id_post = $_GET['id'];
    $commentaires = $commentaireController->afficher($id_post);
} else {
    // Redirection, afficher un message plus convivial, etc.
    echo "<p>Veuillez sélectionner un post pour voir les commentaires.</p>";
    exit; // Ou redirection avec header('Location: url_de_redirection');
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Title and Description -->
    <title>Agropro</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- External CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
    <style>
    /* Styles pour les boutons de lecture */
    .read-buttons {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        justify-content: flex-start;
    }

    .btn-read {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-stop {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-read:hover, .btn-stop:hover {
        opacity: 0.9;
    }

    .comment-card {
        background: white;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .comment-text {
        margin-bottom: 10px;
    }

    .comment-date {
        color: #666;
        font-size: 0.9em;
    }
    </style>
</head>

<body class="main-layout">

    <!-- Loader -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#"/></div>
    </div>

    <div class="full_bg">

        <!-- Header Section -->
        <header class="header-area">
            <div class="container-fluid">
                <div class="row d_flex">
                    <div class="col-md-2 col-sm-3">
                        <div class="logo">
                            <a href="index.html">Agro<span>Pro</span></a>
                        </div>
                    </div>

                    <!-- Navbar -->
                    <div class="col-md-8 col-sm-9">
                        <div class="navbar-area">
                            <nav class="site-navbar">
                                <ul>
                                    <li><a class="active" href="index.html">Home</a></li>
                                    <li><a href="index.php">About</a></li>
                                </ul>
                                <button class="nav-toggler">
                                    <span></span>
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- Login and Search -->
                    <div class="col-md-2 padd_0 d_none">
                        <ul class="email text_align_right">
                            <li><a href="Javascript:void(0)">Login</a></li>
                            <li><a href="Javascript:void(0)"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Banner Section -->
        <div class="slider_main">
            <div id="banner1" class="carousel slide carousel-fade" data-ride="carousel" data-interval="6000">
                <ol class="carousel-indicators">
                    <li data-target="#banner1" data-slide-to="0" class="active"></li>
                    <li data-target="#banner1" data-slide-to="1"></li>
                    <li data-target="#banner1" data-slide-to="2"></li>
                </ol>

                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="images/banner.jpg" class="d-block img-fluid" alt="responsive image">
                    </div>
                    <div class="carousel-item">
                        <img src="images/banner.jpg" class="d-block img-fluid" alt="responsive image">
                    </div>
                    <div class="carousel-item">
                        <img src="images/banner.jpg" class="d-block img-fluid" alt="responsive image">
                    </div>
                </div>

                <a class="carousel-control-prev" href="#banner1" role="button" data-slide="prev">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#banner1" role="button" data-slide="next">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="willom">
                            <h1>Agriculture Fram</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
        /* Card Styling */
.card {
    border: none; /* Enlève la bordure par défaut */
    border-radius: 10px; /* Coins arrondis */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Ombre douce autour de la carte */
    background-color: #f9f9f9; /* Fond léger pour les cartes */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Effet d'animation pour le survol */
}

.card:hover {
    transform: translateY(-5px); /* Carte qui se soulève légèrement lors du survol */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); /* Ombre plus marquée */
}

/* Card Image Styling */
.card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    height: 200px; /* Hauteur fixe pour les images */
    object-fit: cover; /* Couvre la zone sans déformer l'image */
}

/* Button Styling */
.btn {
    border-radius: 50px; /* Boutons avec des bords arrondis */
    padding: 10px 20px;
    font-weight: 600;
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Buttons on Hover */
.btn-outline-secondary:hover, .btn-outline-primary:hover {
    background-color: #3498db; /* Bleu pour l'effet hover */
    color: white; /* Texte blanc sur fond bleu */
}

/* Read More Button */
.btn-outline-secondary {
    border-color: #3498db;
    color: #3498db; /* Texte bleu */
}

/* Comment Button */
.btn-outline-primary {
    border-color: #2ecc71;
    color: #2ecc71; /* Texte vert */
}

/* Card Text Styling */
.card-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333; /* Couleur du titre */
}

.card-text {
    font-size: 1rem;
    color: #555; /* Texte de contenu dans la carte */
    line-height: 1.6; /* Espacement entre les lignes */
    height: 100px; /* Hauteur fixe pour le texte, évite des blocs de texte trop longs */
    overflow: hidden; /* Masque tout texte qui dépasse */
    text-overflow: ellipsis; /* Ajoute des points de suspension si le texte dépasse */
}

/* Publication Info Section */
.text-muted {
    font-size: 0.85rem;
    color: #888;
}

/* Container for Publications */
.container.mt-5 {
    margin-top: 50px;
}

/* Section Titles */
h2.text-center {
    color: #2c3e50; /* Couleur du titre de la section */
    font-size: 2rem;
    font-weight: 700;
    text-transform: uppercase;
}

/* Publication Card Container */
.row {
    margin-top: 30px;
}
</style>


        <!-- Latest Publications Section -->
        
        <div class="container mt-5">
    <h2 class="text-center mb-4">Liste des commentaires</h2>
    <div class="attendance-list">
        <?php 
        if (!empty($commentaires)) {
            foreach ($commentaires as $commentaire) { ?>
                <div class="comment-card">
                    <!-- Contenu du commentaire avec ID unique pour la lecture -->
                    <div class="comment-text" id="comment-<?= $commentaire['id_c']; ?>">
                        <?= htmlspecialchars($commentaire['contenu']); ?>
                    </div>
                    
                    <!-- Métadonnées du commentaire -->
                    <div class="comment-meta">
                        <div class="comment-date">
                            Date: <?= htmlspecialchars($commentaire['date']); ?>
                        </div>
                    </div>

                    <!-- Boutons de lecture -->
                    <div class="read-buttons">
                        <button type="button" class="btn-read" onclick="readComment(<?= $commentaire['id_c']; ?>)">
                            🔊 Lire le commentaire
                        </button>
                        <button type="button" class="btn-stop" onclick="stopReading()">
                            🛑 Arrêter la lecture
                        </button>
                    </div>

                    <!-- Actions sur le commentaire -->
                    <div class="comment-actions mt-3">
                        <a href="modifiercommentaire.php?id_c=<?= $commentaire['id_c']; ?>" class="btn btn-outline-primary btn-sm">
                            ✏️ Modifier
                        </a>
                        <a href="supprimercommentaire.php?id_c=<?= $commentaire['id_c']; ?>" 
                           onclick="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');"
                           class="btn btn-outline-danger btn-sm">
                            🗑️ Supprimer
                        </a>
                    </div>
                </div>
            <?php 
            }
        } else { ?>
            <div class="alert alert-info text-center">
                Aucun commentaire à afficher pour ce post.
            </div>
        <?php } ?>
    </div>

    <!-- Bouton de retour -->
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary">
            ← Retour aux publications
        </a>
    </div>
</div>

        </div>

        <!-- Footer Section -->
        <footer>
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <!-- Newsletter Section -->
                        <div class="col-lg-3 col-md-6">
                            <div class="hedingh3 text_align_left">
                                <h3>Newsletter</h3>
                                <form id="colof" class="form_subscri">
                                    <input class="newsl" placeholder="Enter Email" type="text" name="Email">
                                    <button class="subsci_btn"><img src="images/new.png" alt="#"/></button>
                                </form>
                            </div>
                        </div>

                        <!-- Explore Section -->
                        <div class="col-lg-3 col-md-6">
                            <div class="hedingh3 text_align_left">
                                <h3>Explore</h3>
                                <ul class="menu_footer">
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="service.html">Service</a></li>
                                    <li><a href="Javascript:void(0)">Projects</a></li>
                                    <li><a href="testimonail.html">Testimonail</a></li>
                                    <li><a href="contact.html">Contact us</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Recent Posts Section -->
                        <div class="col-lg-3 col-md-6">
                            <div class="hedingh3 text_align_left">
                                <h3>Recent Posts</h3>
                                <ul class="recent">
                                    <li><img src="images/resent.jpg" alt="#"/>ea commodo consequat. Duis aute </li>
                                    <li><img src="images/resent.jpg" alt="#"/>ea commodo consequat. Duis aute </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contact Section -->
                        <div class="col-lg-3 col-md-6">
                            <div class="hedingh3 flot_right text_align_left">
                                <h3>Contact</h3>
                                <ul class="top_infomation">
                                    <li><i class="fa fa-phone" aria-hidden="true"></i> +01 1234567892</li>
                                    <li><i class="fa fa-envelope" aria-hidden="true"></i> <a href="Javascript:void(0)">demo@gmail.com</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Copyright Section -->
                <div class="copyright">
                    <div class="container">
                        <div class="row d_flex">
                            <div class="col-md-8">
                                <p>© 2022 All Rights Reserved. Design by <a href="https://html.design/"> Free html Templates</a></p>
                            </div>
                            <div class="col-md-4">
                                <ul class="social_icon">
                                    <li><a href="Javascript:void(0)"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="Javascript:void(0)"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="Javascript:void(0)"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div> <!-- End of full_bg -->

    <!-- Javascript files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/custom.js"></script>
    <script>
    // Fonction pour lire le texte à voix haute
    function readComment(commentId) {
        const commentText = document.getElementById('comment-' + commentId).textContent;
        if (commentText.trim() !== '') {
            const utterance = new SpeechSynthesisUtterance(commentText);
            utterance.lang = 'fr-FR'; // Définir la langue en français
            speechSynthesis.speak(utterance);
        }
    }

    // Fonction pour arrêter la lecture
    function stopReading() {
        speechSynthesis.cancel();
    }
    </script>

</body>
</html>


 