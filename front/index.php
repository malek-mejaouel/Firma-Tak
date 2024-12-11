<?php
// Inclure le fichier nécessaire pour récupérer les publications
include '../../Controller/PublicationC.php';  

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agropro</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
    <style>
    .input-group {
        max-width: 500px;
        margin: 0 auto;
    }

    .input-group input {
        border-radius: 20px 0 0 20px;
    }

    .input-group .btn {
        border-radius: 0 20px 20px 0;
        padding: 0.375rem 1.5rem;
    }

    .input-group-append .btn {
        border-left: 0;
    }
    </style>
</head>

<body class="main-layout">

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

        <!-- Footer Section -->
        <footer>
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="hedingh3 text_align_left">
                                <h3>Contact</h3>
                                <ul class="conta">
                                    <li>Phone: +91 9876543210</li>
                                    <li>Email: agropro@gmail.com</li>
                                    <li>Address: 28 New York City</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <style>
            .card-body .btn {
    border-radius: 25px;
    padding: 10px 15px;
    text-align: center;
}

.card-body .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
            </style>

    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
</body>

</html>
