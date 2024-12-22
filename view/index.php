<?php
session_start(); // Start the session

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user'])) {
    header('Location: ../log.php'); // Redirect to login page if user is not logged in
    exit();
}

echo "Welcome to the User Home Page, " . $_SESSION['user']['name'] . "!";
// Inclure le fichier nécessaire pour récupérer les publications
include '../controller/PublicationC.php';  

// Créer une instance du contrôleur des publications
$c = new PublicationC();

// Définir le nombre de publications par page
$limit = 3;

// Récupérer la page actuelle
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Vérifier si le tri par titre est demandé
$sortOrder = isset($_GET['sort']) && $_GET['sort'] == 'title' ? 'ASC' : 'DESC';

// Récupérer le terme de recherche
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Gérer la recherche et la pagination
if (!empty($search)) {
    // Si une recherche est effectuée
    $result = $c->searchPublications($search, $page, $limit);
    $publications = $result['publications'];
    $totalPublications = $result['total'];
} else {
    // Code existant pour afficher toutes les publications
    $totalPublications = $c->countPublications();
    $publications = $c->listPublicationsByPageAndSort($page, $limit, $sortOrder);
}

$totalPages = ceil($totalPublications / $limit);

// S'assurer que la page actuelle est valide
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;
if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    $fermier = $_SESSION['user'];  // Get the admin's profile data

    // Get the user's profile picture (if any)
    $profilePicture = !empty($fermier['profile_picture']) ? $fermier['profile_picture'] : 'default_profile_picture.png'; // Provide a default image if none exists

    // You can now use $profilePicture and other session data
} else {
    // Handle case where session is not properly set
    echo "No user session found.";
}

 
   // Now you can call getRecentUser

    // Check if session messages exist and are an array
    
    $admin = $_SESSION['user']; 

    // Get the user's profile picture (if any)
    $profilePicture = !empty($fermier['profile_picture']) ? $fermier['profile_picture'] : 'uploads/default.jpg'; // Default profile picture if none set
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
      <title>Firma-Tak</title>
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
                        <img src="images/logos.png" alt="">
                        <a href="index.html">Firma<span>-Tak</span></a>
                     </div>
                  </div>
                  <div class="col-md-8 col-sm-9">
                     <div class="navbar-area">
                        <nav class="site-navbar">
                           <ul>

                              <li><a class="active" href="index.html">Home</a></li>
                              <li><a href="about.php">feedbackmessage</a></li>
                              <li><a href="services/service.html">Service</a></li>
                               <li><a href="listEvents.php">Projects</a></li>
                                <li><a href="rating.php">rate-firma-tak</a></li>
                              <li><a href="news/news.html">Blog</a></li>
                              <li><a href="contact.php">Contact</a></li>
                              <li><button id="darkModeButton" onclick="toggleDarkMode()">🌙</button></li>

                           </ul>
                           <button class="nav-toggler">
                           <span></span>
                           </button>
                        </nav>
                     </div>
                  </div>
                  <div class="col-md-2 padd_0 d_none">
                     <ul class="email text_align_right">
                        <div class="user">
                <p class="admin-name">
                <?php
                if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] === 'admin') {
                    echo " " . htmlspecialchars($_SESSION['user']['name']);
                }
                ?>
            </p>
           
            <div class="img-case">
            <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" style="max-width: 150px;">
                    </div>
                 
                <?php
                if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] === 'admin') {
                    
                    echo " " . htmlspecialchars($_SESSION['user']['name']);
                    
                }
                ?>
    
<a href="logout.php" class="btn btn-danger">Logout</a>

                    </div>
                     
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
                                       <source srcset="images/ban.jpg" >
                                       <source srcset="images/bani.jpg" >
                                       <img srcset="images/ban.jpg" alt="responsive image" class="d-block img-fluid">
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
                                      <h1> Your Future Farm is waiting for you</h1>
                                    </div>
                                 </div>
                              </div>
                           </div>
         </div>
      </div>
      <!-- end banner -->
      <!-- about -->
      
                   
      <!-- end about -->
      <div class="container mt-5">
    <h2 class="text-center mb-4">Latest Publications 📰</h2>

    <!-- Search and Sort Section -->
    <div class="mb-4 text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Search Form -->
                <form action="" method="get" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search by title..." 
                               value="<?php echo htmlspecialchars($search); ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                🔍 Search
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Sort Button -->
                <form action="" method="get" class="mb-3">
                    <button type="submit" name="sort" value="title" class="btn btn-outline-info btn-sm">
                        Sort by Title
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php if (!empty($publications)) { ?>
        <div class="row">
            <?php foreach ($publications as $publication) { ?>
                <div class="col-md-4 mb-4">
                    <!-- Publication Card -->
                    <div class="card shadow-sm border-light">
                        <div class="card-body">
                            <!-- Publication Title -->
                            <h5 class="card-title text-primary"><?php echo htmlspecialchars($publication['Titre']); ?></h5>
                            
                            <!-- Publication Content -->
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($publication['Contenu'])); ?></p>
                            
                            <!-- Publication Info Section -->
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-muted small">Published on: <?php echo date('F j, Y', strtotime($publication['Date'])); ?></p>
                            </div>

                            <!-- Action Buttons Section -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <!-- Read More Button -->
                                <a href="<?= htmlspecialchars($publication['Lien']); ?>" class="btn btn-outline-secondary btn-sm w-100 mb-2">Read More 📖</a>

                                <!-- Download PDF Button -->
                                <a href="generatePDF.php?id=<?php echo $publication['ID']; ?>" class="btn btn-outline-danger btn-sm w-100 mb-2">📥 PDF</a>

                                <!-- Add Comment Button -->
                                <a href="ajoutercommentaire.php?id=<?php echo $publication['ID']; ?>" class="btn btn-outline-success btn-sm w-100 mb-2">➕ Add Comment</a>

                                <!-- View Comments Button -->
                                <a href="affichercommentaire.php?id=<?php echo $publication['ID']; ?>" class="btn btn-outline-primary btn-sm w-100 mb-2">💬 View Comments</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="text-center">No publications found.</p>
    <?php } ?>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <ul class="pagination">
            <?php if ($page > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=1&sort=<?php echo $sortOrder; ?>&search=<?php echo urlencode($search); ?>">First</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&sort=<?php echo $sortOrder; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                </li>
            <?php } ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&sort=<?php echo $sortOrder; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>

            <?php if ($page < $totalPages) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&sort=<?php echo $sortOrder; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $totalPages; ?>&sort=<?php echo $sortOrder; ?>&search=<?php echo urlencode($search); ?>">Last</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

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
      <style>.header {
         position: relative;
    display: flex; /* Align items horizontally */
    align-items: center; /* Vertically align the image and button */
    gap: 10px; /* Add space between the items */
}
body.dark-mode {
            background-color: #333;
            color: #f4f7f6;
        }

.small-profile {
    cursor: pointer;
    width: 40px; /* Adjust the size as needed */
    height: 40px;
}

/* Styling for the profile picture */
.img-case img {
    width: 50px; /* Adjust size */
    height: 50px;
    border-radius: 50%; /* Make the image circular */
    border: 2px solid #6b7908; /* Green border */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Add shadow for a professional look */
    object-fit: cover;
    margin-right: 10px; /* Add spacing between profile picture and other elements */
}

/* Styling for the logout button */
.logout-button {
    text-decoration: none;
    color: #fff; /* White text for contrast */
    font-size: 14px;
    font-weight: bold;
    padding: 5px 15px;
    border: none; /* Remove border */
    border-radius: 20px; /* Smooth rounded edges */
    background-color: #6b7908; /* Green background */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Slight shadow for depth */
    cursor: pointer;
    transition: all 0.3s ease; /* Smooth hover effect */
}

.logout-button:hover {
    background-color: #5a6a07; /* Darker green on hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Deeper shadow */
}

/* Align profile picture and button horizontally */
.user {
    display: flex;
    align-items: center; /* Align vertically */
    justify-content: flex-end; /* Align to the right */
    gap: 10px; /* Space between profile picture and button */
}

.dark-mode button {
            background-color: #333;
            color: white;
        }

        #darkModeButton {
    position: absolute;
    top: calc(40px -3cm); /* Move the button 4 cm up from the initial position */
    right: calc(20px + 1cm); /* Move the button 6 cm to the right */
    background-color: transparent;
    border: none;
    font-size: 30px;
    cursor: pointer;
    z-index: 50;
}



#darkModeButton:hover {
    transform: scale(1.2);
}
 
.container {
            max-width: 1500px;
        }

        .card {
            border: none;
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .btn {
    font-family: Arial, sans-serif;
    border-radius: 5px;
    transition: all 0.3s ease;
}




        .btn-primary {
            background-color:rgb(40, 106, 20);
            border: none;
        }

        .btn-primary:hover {
            background-color:rgb(110, 162, 99);
        }

        .pagination .page-link {
            border-radius: 50px;
            color:rgb(14, 101, 4);
        }

        .pagination .page-item.active .page-link {
            background-color:rgb(13, 172, 24);
            border-color:rgb(64, 120, 5);
            color: #fff;
        }

        h2 {
            color: #343a40;
        }

        .card-title {
            color:rgb(10, 107, 31);
            font-weight: 600;
        }

        .card-text {
            color: #6c757d;
        }
    
    </style>
</style>
<script>
    // Toggle Dark Mode
    function toggleDarkMode() {
        const body = document.body;
        const button = document.getElementById('darkModeButton');
        
        body.classList.toggle('dark-mode');
        if (body.classList.contains('dark-mode')) {
            button.textContent = '🌞'; // Change to sun emoji when dark mode is active
        } else {
            button.textContent = '🌙'; // Change to moon emoji when dark mode is inactive
        }
    }

</script>
   </body>
</html>