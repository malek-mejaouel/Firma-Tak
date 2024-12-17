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
                              <li><a href="about.php">feedback</a></li>
                              <li><a href="chat.php">Chatbot</a></li>
                               <li><a href="listEvents.php">Projects</a></li>
                               <li><a  href="template/news/map.html">Map</a></li>
                               
                                <li><a href="rating.php">rating</a></li>
                                <li><a href="showcaseLands.php">land</a></li>

                              <li><a href="prodi.php">product</a></li>
                              <li><a href="contact.php">Contact</a></li>
                            
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
      <!-- end banner -->
      <!-- about -->
      <?php
include "../controller/productC.php"; // Inclure le contrôleur
$c = new ProductC(); // Créer une instance de ProductC

// Nombre de produits par page
$limit = 2; 

// Obtenir le total des produits pour calculer le nombre total de pages
$totalProducts = $c->getTotalProducts();
$totalPages = ceil($totalProducts / $limit);

// Obtenir la page actuelle à partir des paramètres GET (par défaut page 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Récupérer les produits pour la page actuelle
$tab = $c->listProductsByPage($page, $limit);

// Afficher les produits
if (is_array($tab) && count($tab) > 0) {
?>
<div class="product-cards-container">
    <?php foreach ($tab as $product) { ?>
    <div class="product-card">
        <div class="product-info">
            <h3><?= $product['Nom_Produit']; ?> <span class="emoji">🛒</span></h3>
            <p><strong>Quantity:</strong> <?= $product['Quantite']; ?></p>
            <p><strong>Price:</strong> $<?= number_format($product['Prix_Unitaire'], 2); ?></p>
        </div>
        <div class="product-actions">
            <a href="afficheorder.php?id=<?= $product['ID_Produit']; ?>" class="btn-order">View Order 📦</a>
            <a href="placeOrder.php?id=<?= $product['ID_Produit']; ?>" class="btn-order">Pass Order 🛍️</a>
        </div>
    </div>
    <?php } ?>
</div>

<!-- Pagination -->
<div class="pagination">
    <?php if ($page > 1) { ?>
        <a href="?page=<?= $page - 1; ?>" class="page-link">&laquo; Previous</a>
    <?php }
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a href="?page=' . $i . '" class="page-link">' . $i . '</a>';
    }
    if ($page < $totalPages) { ?>
        <a href="?page=<?= $page + 1; ?>" class="page-link">Next &raquo;</a>
    <?php } ?>
</div>

<?php
} else {
    echo "<p>No products found.</p>";
}
?>

<style>
    .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    padding: 10px 20px;
    margin: 0 5px;
    background-color: #6b7908;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.pagination a:hover {
    background-color: #6b7908
}

.pagination .page-link {
    text-decoration: none;
}
.product-cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
         }

         /* Individual product card style */
         .product-card {
            width: 280px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
         }

         .product-card:hover {
            transform: scale(1.05); /* Scale up the card slightly on hover */
         }

         /* Product info styling */
         .product-info h3 {
            font-size: 1.5em;
            margin: 10px 0;
         }

         .product-info p {
            font-size: 1em;
            margin: 5px 0;
         }

         .emoji {
            font-size: 1.2em;
         }

         /* Action buttons styling */
         .product-actions {
            margin-top: 15px;
         }

         .product-actions a {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
         }

         .product-actions .btn-order {
            background-color: #6b7908
         }

         .product-actions .btn-order:hover {
            background-color: #6b7908
         }
    </style>
      <!-- end about -->
      <!-- services -->
     
      <!-- end services -->
      <!-- customers -->
    
      <!-- end customers -->
      <!-- choose -->
     
      <!-- choose -->
     
      <!-- end news -->
      <!-- contact -->
      
      <!-- end contact -->
      <!--  footer -->
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