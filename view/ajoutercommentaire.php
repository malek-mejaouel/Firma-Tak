<?php

include_once '../controller/commentairec.php';
include_once '../controller/publicationC.php';
include_once '../model/commentaire.php';

date_default_timezone_set('Africa/Tunis');
$currentDateTime = date('Y-m-d');

function containsBadWords($text) {
    $badWords = array(
        'fuck', 'shit', 'pute', 'merde', 'connard', 'ass', 'bitch'
        // Ajoutez d'autres bad words selon vos besoins
    );
    
    $text = strtolower($text);
    foreach ($badWords as $word) {
        if (strpos($text, $word) !== false) {
            return true;
        }
    }
    return false;
}

    $error = "";
    // create user
    $commentaire= null;
    $publicationC = new publicationC();
    // create an instance of the controller
    $commentaireC = new commentaireC();
    if (isset($_POST['commentaire']) && isset($_POST['emoji'])) {
        $commentaireText = trim($_POST['commentaire']);
        $emoji = $_POST['emoji'];
        
        if (empty($commentaireText)) {
            $error = "Le commentaire ne peut pas être vide";
        } elseif (strlen($commentaireText) < 2) {
            $error = "Le commentaire doit contenir au moins 2 caractères";
        } elseif (containsBadWords($commentaireText)) {
            $error = "Le commentaire contient des mots inappropriés";
        } else {
            $commentaire = new commentaire(
                $commentaireText,
                $currentDateTime,
                $_GET["id"],
                $emoji
            );
            $commentaireC->ajouter($commentaire);
            header('Location: index.php');
            exit();
        }
    }  
    
	if(isset($_POST['ajout']))
	{
    	header ('Location:index.php');
	}

    $publication=$publicationC->showPublication($_GET["id"]);

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

/* Ajoutez ces styles pour l'affichage des erreurs */
.text-danger {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.comment-form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-primary {
    transition: all 0.3s ease;
}

.btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Ajoutez ces styles pour les boutons de lecture */
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

/* Ajoutez ces styles à votre section style existante */
.comment-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.comment-actions a {
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-outline-primary {
    color: #007bff;
    border-color: #007bff;
}

.btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545;
}

.btn-outline-primary:hover, .btn-outline-danger:hover {
    color: white;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

.comment-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 10px 0;
    font-size: 0.9em;
    color: #666;
}

.voice-input-buttons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.btn-record {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-record.recording {
    background-color: #dc3545;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.recording-status {
    color: #dc3545;
    font-size: 0.9em;
    margin-top: 5px;
    display: none;
}

/* Ajoutez ces styles pour les emojis */
.emoji-selector {
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f8f9fa;
}

.emoji-options {
    display: flex;
    gap: 15px;
    justify-content: center;
}

.emoji-option {
    position: relative;
    cursor: pointer;
}

.emoji-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.emoji-option span {
    display: inline-block;
    font-size: 24px;
    padding: 5px 15px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.emoji-option input[type="radio"]:checked + span {
    background: #007bff;
    color: white;
    transform: scale(1.1);
}

.emoji-option:hover span {
    background: #e9ecef;
    transform: scale(1.1);
}

.emoji-label {
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
    text-align: center;
}
</style>

<script>
function verif() {
    let commentaire = document.getElementById('commentaire').value.toLowerCase();
    let erreurCommentaire = document.getElementById('erreur_commentaire');
    
    // Vérifier si le commentaire est vide
    if (commentaire.trim() === '') {
        erreurCommentaire.textContent = 'Le commentaire ne peut pas être vide';
        return false;
    }

    // Vérifier la longueur minimale
    if (commentaire.length < 2) {
        erreurCommentaire.textContent = 'Le commentaire doit contenir au moins 2 caractères';
        return false;
    }

    // Vérifier les bad words
    const badWords = [
        'fuck', 'shit', 'pute', 'merde', 'connard', 'ass', 'bitch'
    ];
    
    for (let word of badWords) {
        if (commentaire.includes(word)) {
            erreurCommentaire.textContent = 'Le commentaire contient des mots inappropriés';
            return false;
        }
    }

    // Vérifier si un emoji est sélectionné
    const emojiSelected = document.querySelector('input[name="emoji"]:checked');
    if (!emojiSelected) {
        erreurCommentaire.textContent = 'Veuillez sélectionner une humeur';
        return false;
    }

    erreurCommentaire.textContent = '';
    return true;
}

// Modifier la fonction checkComment
function checkComment() {
    let submitBtn = document.querySelector('input[type="submit"]');
    
    if (verif()) {
        submitBtn.disabled = false;
        document.getElementById('erreur_commentaire').style.color = 'green';
        document.getElementById('erreur_commentaire').textContent = 'Commentaire valide';
    } else {
        submitBtn.disabled = true;
    }
}

// Fonction pour lire le texte à voix haute
function readComment() {
    const commentaire = document.getElementById('commentaire').value;
    if (commentaire.trim() !== '') {
        const utterance = new SpeechSynthesisUtterance(commentaire);
        utterance.lang = 'fr-FR'; // Définir la langue en français
        speechSynthesis.speak(utterance);
    }
}

// Fonction pour arrêter la lecture
function stopReading() {
    speechSynthesis.cancel();
}

// Fonction pour la reconnaissance vocale
let recognition = null;
let isRecording = false;

function initSpeechRecognition() {
    if ('webkitSpeechRecognition' in window) {
        recognition = new webkitSpeechRecognition();
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = 'fr-FR'; // Définir la langue en français

        recognition.onstart = function() {
            isRecording = true;
            document.getElementById('recordButton').classList.add('recording');
            document.getElementById('recordingStatus').style.display = 'block';
            document.getElementById('recordButton').innerHTML = '🛑 Arrêter l\'enregistrement';
        };

        recognition.onend = function() {
            isRecording = false;
            document.getElementById('recordButton').classList.remove('recording');
            document.getElementById('recordingStatus').style.display = 'none';
            document.getElementById('recordButton').innerHTML = '🎤 Dicter le commentaire';
        };

        recognition.onresult = function(event) {
            let finalTranscript = '';
            for (let i = event.resultIndex; i < event.results.length; i++) {
                if (event.results[i].isFinal) {
                    finalTranscript += event.results[i][0].transcript;
                }
            }
            if (finalTranscript !== '') {
                let commentaireTextarea = document.getElementById('commentaire');
                commentaireTextarea.value = commentaireTextarea.value + ' ' + finalTranscript;
                // Déclencher la vérification du commentaire
                checkComment();
            }
        };

        recognition.onerror = function(event) {
            console.error('Erreur de reconnaissance vocale:', event.error);
            stopRecording();
        };
    } else {
        alert('La reconnaissance vocale n\'est pas supportée par votre navigateur.');
    }
}

function toggleRecording() {
    if (!recognition) {
        initSpeechRecognition();
    }

    if (isRecording) {
        stopRecording();
    } else {
        startRecording();
    }
}

function startRecording() {
    if (recognition) {
        recognition.start();
    }
}

function stopRecording() {
    if (recognition) {
        recognition.stop();
    }
}

// Initialiser la reconnaissance vocale au chargement de la page
document.addEventListener('DOMContentLoaded', initSpeechRecognition);

// Ajoutez ces fonctions à votre script existant
document.addEventListener('DOMContentLoaded', function() {
    const emojiOptions = document.querySelectorAll('.emoji-option');
    
    emojiOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Retirer la classe selected de toutes les options
            emojiOptions.forEach(opt => opt.classList.remove('selected'));
            // Ajouter la classe selected à l'option cliquée
            this.classList.add('selected');
            // Sélectionner le radio button
            this.querySelector('input[type="radio"]').checked = true;
        });
    });
});
</script>

        <!-- Latest Publications Section -->
        
        <div class="container mt-5">
            <div class="comment-form">
                <h3 class="mb-4">Ajouter un commentaire</h3>
                <form method="POST" onsubmit="return verif();">
                    <div class="form-group">
                        <label for="commentaire">Votre commentaire</label>
                        <textarea 
                            name="commentaire" 
                            class="form-control" 
                            id="commentaire" 
                            rows="4"
                            placeholder="Saisissez votre commentaire ici"
                            oninput="checkComment()"
                            required
                        ></textarea>
                        <span id="erreur_commentaire" class="text-danger"></span>
                        
                        <!-- Sélecteur d'emoji -->
                        <div class="emoji-selector">
                            <span class="emoji-label">Choisissez votre humeur :</span>
                            <div class="emoji-options">
                                <label class="emoji-option">
                                    <input type="radio" name="emoji" value="😊" onclick="checkComment()">
                                    <span>😊</span>
                                </label>
                                <label class="emoji-option">
                                    <input type="radio" name="emoji" value="😐" onclick="checkComment()">
                                    <span>😐</span>
                                </label>
                                <label class="emoji-option">
                                    <input type="radio" name="emoji" value="😠" onclick="checkComment()">
                                    <span>😠</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Boutons de lecture -->
                        <div class="read-buttons">
                            <button type="button" class="btn-read" onclick="readComment()">
                                🔊 Lire le commentaire
                            </button>
                            <button type="button" class="btn-stop" onclick="stopReading()">
                                🛑 Arrêter la lecture
                            </button>
                        </div>

                        <!-- Boutons de dictée vocale -->
                        <div class="voice-input-buttons">
                            <button type="button" id="recordButton" class="btn-record" onclick="toggleRecording()">
                                🎤 Dicter le commentaire
                            </button>
                        </div>
                        <div id="recordingStatus" class="recording-status">
                            Enregistrement en cours... Parlez maintenant
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <input 
                            type="submit" 
                            name="ajout" 
                            value="Commenter" 
                            class="btn btn-primary"
                            disabled
                        >
                    </div>
                </form>
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

</body>
</html>


 

 