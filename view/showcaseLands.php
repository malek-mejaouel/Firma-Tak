<?php
require_once '../config/database.php';
require '../controller/LandRentController.php';

// Ensure $conn is properly instantiated
if (!isset($conn)) {
    $database = new Database();
    $conn = $database->getConnection();
}

// Instantiate the controller and fetch lands
$controller = new LandRentController($conn);
$lands = $controller->listLands();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Land Showcase</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        header {
            background-color: #6b7908
            padding: 20px;
            color: white;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 15px;
            text-align: center;
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-title {
            font-weight: bold;
            font-size: 1.2em;
        }

        .btn-block {
            margin-top: 10px;
        }

        .btn-primary {
            background-color:rgb(83, 134, 7);
            border-color:rgb(86, 123, 12);
        }

        .btn-primary:hover {
            background-color:rgb(40, 123, 5);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .container .row {
            margin-top: 20px;
        }

        .alert {
            font-weight: bold;
        }
           /* Navbar styles */
           .menu-container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .navbar-area {
            display: flex;
            justify-content: flex-start; /* Align to the left */
            align-items: center;
            background-color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-area .logo {
            display: flex;
            align-items: center;
            margin-right: 20px; /* Add space between logo and menu */
        }

        .navbar-area .logo img {
            max-width: 40px; /* Logo size */
            margin-right: 10px;
        }

        .navbar-area .logo a {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }

        .site-navbar ul {
            display: flex;
            gap: 20px;
            list-style: none; /* Remove bullet points */
            padding: 0;
            margin: 0;
        }

        .site-navbar a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .site-navbar a.active {
            background-color:rgb(92, 137, 4); /* Green background for active link */
            color: white;
        }

        .site-navbar a:hover {
            background-color: #575757;
            color: white;
        }

        /* Toggle button for smaller screens */
        .nav-toggler {
            display: none; /* Hide toggle button on larger screens */
        }

        /* Media query for responsive design */
        @media (max-width: 768px) {
            .site-navbar ul {
                flex-direction: column;
                gap: 10px;
                width: 100%;
                display: none;
            }

            .navbar-area.active .site-navbar ul {
                display: flex;
            }

            .nav-toggler {
                display: block;
                background-color: #333;
                width: 40px;
                height: 30px;
                border: none;
                cursor: pointer;
            }

            .nav-toggler span {
                background-color: white;
                display: block;
                width: 100%;
                height: 4px;
                margin: 5px 0;
            }

            .site-navbar a {
                font-size: 14px;
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
    <header class="header-area">
            <div class="container-fluid">
               <div class="row d_flex">
                  <div class=" col-md-2 col-sm-3">
                     <div class="logo">
                        <img src="images/logos.png" alt="">
                        <a href="index.html">Firma<span>Tak</span></a>
                     </div>
                  </div>
                  <div class="col-md-8 col-sm-9">
                     <div class="navbar-area">
                        <nav class="site-navbar">
                           <ul>

                              <li><a  href="index.php">Home</a></li>
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
                  
        
         </header>
    </header>
    <main>
        <div class="container text-center">
            <a href="createLand.php" class="btn btn-primary mb-3">+ Add a Land</a>
        </div>
        <div class="container">
            <div class="row">
                <?php if (!empty($lands)): ?>
                    <?php foreach ($lands as $land): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="images/landIm.jpg" class="card-img-top" alt="Land Image">
                                <div class="card-body">
                                    <h5 class="card-title">Land ID: <?php echo htmlspecialchars($land['land_id']); ?></h5>
                                    <p class="card-text"><strong>Owner:</strong> <?php echo htmlspecialchars($land['owner']); ?></p>
                                    <p class="card-text"><strong>Contact Number:</strong> <?php echo htmlspecialchars($land['number']); ?></p>
                                    <p class="card-text"><strong>Size:</strong> <?php echo htmlspecialchars($land['size_km2']); ?> Km²</p>
                                    <p class="card-text"><strong>Price per Year:</strong> $<?php echo htmlspecialchars($land['price_per_year']); ?></p>
                                    <div>
                                        <a href="landRented.php?land_id=<?php echo $land['land_id']; ?>" class="btn btn-success btn-block">Rent</a>
                                        <a href="mapPage.php?land_id=<?php echo $land['land_id']; ?>" class="btn btn-primary btn-block">Location</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            No land records found. Please check back later or <a href="createLand.php">add a new listing</a>.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Land Showcase. Powered by <a href="https://example.com" target="_blank">Your Company</a>.</p>
    </footer>
</body>
</html>
