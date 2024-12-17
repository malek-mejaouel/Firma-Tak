<?php
// Inclure le fichier pour le contrôleur des commandes
include_once '../../Controller/commandeC.php';

// Créer une instance du contrôleur des commandes
$commandeController = new commandeC();

if (isset($_GET['id'])) {
    $id_product = $_GET['id'];
    $commandes = $commandeController->afficher($id_product);
} else {
    echo "<p>Veuillez sélectionner un produit pour voir les commandes.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Agropro</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <!-- end loader -->
      <div class="full_bg">
         <!-- header -->
         <header class="header-area">
            <div class="container-fluid">
               <div class="row d_flex">
                  <div class=" col-md-2 col-sm-3">
                     <div class="logo">
                        <a href="index.html">Agro<span>Pro</span></a>
                     </div>
                  </div>
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
                  <div class="col-md-2 padd_0 d_none">
                     <ul class="email text_align_right">
                        <li><a href="Javascript:void(0)">Login</a>
                        </li>
                        <li><a href="Javascript:void(0)"><i class="fa fa-search" aria-hidden="true"></i>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </header>
         <!-- end header inner -->
         <!-- top -->
         <div class="slider_main">
            <!-- carousel code -->
             <div id="banner1" class="carousel slide carousel-fade" data-ride="carousel" data-interval="6000">
                              <ol class="carousel-indicators">
                                 <li data-target="#banner1" data-slide-to="0" class="active"></li>
                                 <li data-target="#banner1" data-slide-to="1"></li>
                                 <li data-target="#banner1" data-slide-to="2"></li>
                              </ol>
                              <div class="carousel-inner" role="listbox">
                                 <div class="carousel-item active">
                                    <picture>
                                       <source srcset="images/banner.jpg" >
                                     
                                       <img srcset="images/banner.jpg" alt="responsive image" class="d-block img-fluid">
                                    </picture>
                                    <div class="carousel-caption relative">
                                       
                                    </div>
                                 </div>
                                 <!-- /.carousel-item -->
                                 <div class="carousel-item">
                                    <picture>
                                     
                                       <img srcset="images/banner.jpg" alt="responsive image" class="d-block img-fluid">
                                    </picture>
                                    <div class="carousel-caption relative">
                                       
                                    </div>
                                 </div>
                                 <!-- /.carousel-item -->
                                 <div class="carousel-item">
                                    <picture>
                                       <source srcset="images/banner.jpg" >
                                       <source srcset="images/banner.jpg" >
                                       <source srcset="images/banner.jpg" >
                                       <img srcset="images/banner.jpg" alt="responsive image" class="d-block img-fluid">
                                    </picture>
                                    <div class="carousel-caption relative">
                                       
                                    </div>
                                 </div>
                                 <!-- /.carousel-item -->
                              </div>
                              <!-- /.carousel-inner -->
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
                                      <h1> Agriculture Fram</h1>
                                    </div>
                                 </div>
                              </div>
                           </div>
         </div>
      </div>

    <section class="container mt-5">
        <h1 class="section-title">📦 Liste des Commandes</h1>
        <?php if (!empty($commandes)) {
            foreach ($commandes as $commande) { ?>
                <div class="commande-container" id="commande-<?= htmlspecialchars($commande['ID_Commande']); ?>">
                    <div class="commande-content">
                        <p><strong>ID Commande:</strong> <?= htmlspecialchars($commande['ID_Commande']); ?></p>
                        <p><strong>ID Produit:</strong> <?= htmlspecialchars($commande['ID_Produit']); ?></p>
                        <p><strong>Quantité:</strong> <?= htmlspecialchars($commande['Quantite_Commande']); ?></p>
                        <p><strong>Date:</strong> <?= htmlspecialchars($commande['Date_Commande']); ?></p>
                    </div>
                    <div class="commande-actions">
                        <a href="modifiercommande.php?id_commande=<?= htmlspecialchars($commande['ID_Commande']); ?>" class="btn btn-outline-primary">Modifier</a>
                        <a href="supprimercommande.php?id_commande=<?= htmlspecialchars($commande['ID_Commande']); ?>" class="btn btn-outline-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette commande ?');">Supprimer</a>
                    </div>
                </div>
            <?php }
        } else {
            echo "<p>Aucune commande à afficher pour ce produit.</p>";
        } ?>
    </section>
</main>

<footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                         <div class="col-lg-3 col-md-6">
                           <div class="hedingh3  text_align_left">
                              <h3>Newsletter</h3>
                              <form id="colof" class="form_subscri">
                                 <input class="newsl" placeholder="Enter Email" type="text" name="Email">
                                 <button class="subsci_btn"><img src="images/new.png" alt="#"/></button>
                              </form>
                              
                           </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                           <div class="hedingh3 text_align_left">
                              <h3> Explore</h3>
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
                        <div class="col-lg-3 col-md-6">
                           <div class="hedingh3 text_align_left">
                              <h3>Recent Posts</h3>
                              <ul class="recent">
                                 <li><img src="images/resent.jpg" alt="#"/>ea commodo consequat. Duis aute </li>
                                 <li><img src="images/resent.jpg" alt="#"/>ea commodo consequat. Duis aute </li>
                              </ul>
                           </div>
                        </div>
                         <div class="col-lg-3 col-md-6">
                           <div class="hedingh3  flot_right text_align_left">
                              <h3>ContacT</h3>
                              <ul class="top_infomation">
                                 <li><i class="fa fa-phone" aria-hidden="true"></i>
                                    +01 1234567892
                                 </li>
                                 <li><i class="fa fa-envelope" aria-hidden="true"></i>
                                    <a href="Javascript:void(0)">demo@gmail.com</a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
             
            <div class="copyright">
               <div class="container">
                  <div class="row d_flex">
                     <div class="col-md-8">
                        <p>© 2022 All Rights Reserved. Design by <a href="https://html.design/"> Free html Templates</a></p>
                     </div>
                     <div class="col-md-4">
                           <ul class="social_icon ">
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
      <style>
        /* Global Styles */
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f8f9fa;
    overflow-x: hidden;
}

h1.section-title {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 30px;
    color: #4CAF50; /* Green color for agriculture */
    text-transform: uppercase;
    font-weight: bold;
    position: relative;
}

h1.section-title::after {
    content: "🌿";
    font-size: 2rem;
    position: absolute;
    right: -40px;
    top: -5px;
}

p {
    margin-bottom: 10px;
    font-size: 1rem;
}

.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
}

/* Loader */
.loader_bg {
    background: #fff;
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
}

.loader img {
    width: 80px;
    animation: spin 1.5s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

/* Navbar */
.navbar-area ul {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: space-around;
}

.navbar-area ul li a {
    color: #333;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.navbar-area ul li a:hover {
    background-color: #4CAF50;
    color: white;
}

/* Commande Cards */
.commande-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
    margin-bottom: 20px;
    position: relative;
}

.commande-container::before {
    content: "📦";
    position: absolute;
    left: 10px;
    font-size: 1.5rem;
}

.commande-content {
    flex: 1;
    padding-left: 50px;
}

.commande-content p {
    font-size: 1rem;
    margin: 5px 0;
}

.commande-actions a {
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 5px;
    font-size: 0.9rem;
    font-weight: bold;
    transition: all 0.3s ease;
}

.commande-actions .btn-outline-primary {
    color: #007BFF;
    border: 1px solid #007BFF;
}

.commande-actions .btn-outline-primary:hover {
    background-color: #007BFF;
    color: white;
}

.commande-actions .btn-outline-danger {
    color: #dc3545;
    border: 1px solid #dc3545;
}

.commande-actions .btn-outline-danger:hover {
    background-color: #dc3545;
    color: white;
}

/* Footer */
footer {
    background-color: #343a40;
    color: #fff;
    padding: 20px 0;
}

footer .social_icon a {
    color: white;
    margin: 0 10px;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

footer .social_icon a:hover {
    color: #4CAF50;
}

/* Responsive Design */
@media (max-width: 768px) {
    .commande-container {
        flex-direction: column;
        align-items: flex-start;
    }

    .commande-actions {
        margin-top: 10px;
    }
}
        </style>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/owl.carousel.min.js"></script>
      <script src="js/bootstrap-datepicker.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>