<?php
// Include the necessary files for the database and controller
require_once '../config/database.php';
require_once '../controller/LandRentController.php';

// Create a new instance of Database and LandRentController
$database = new Database();
$conn = $database->getConnection();  // Get the connection

// Instantiate the controller
$controller = new LandRentController($conn);

// Fetch the lands
$lands = $controller->listLands();  // Call the listLands method

// Check if there are lands

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="styles.css">
    <title>ALPHA Web Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        /* Sidebar */
        .side-menu {
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #343a40;
            color: #fff;
            padding-top: 20px;
        }
        .side-menu .brand-name {
            text-align: center;
            margin-bottom: 20px;
        }
        .side-menu ul {
            list-style: none;
            padding: 0;
        }
        .side-menu ul a {
            color: #fff;
            text-decoration: none;
            padding: 15px 20px;
            display: block;
            border-radius: 5px;
        }
        .side-menu ul a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header .search input {
            width: 300px;
            padding: 8px;
            border-radius: 4px;
        }

        .header .user img {
            width: 40px;
            height: 40px;
            margin-left: 15px;
            border-radius: 50%;
        }

        .btn {
            background-color: #343a40;
            color: #fff;
            border: none;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Table Styling */
        .table-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .table-container h2 {
            margin-bottom: 20px;
        }

        .table-responsive {
            margin-top: 20px;
        }
        #map {
            height: 450px;
            margin-top: 25px;
            border-radius: 10px;
        }
        .dark-mode {
            background-color: #121212;
            color: white;
        }

        .toggle-dark-mode {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: white;
            color: black;
            border: none;
            border-radius: 20px;
            font-size: 1.2em;
            width: 50px;
            height: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, color 0.3s;
        }

        .toggle-dark-mode.dark {
            background-color: black;
            color: white;
        }

        body.dark-mode {
            background-color: #121212;
            color: #ffffff; /* Ensures text color is white */
        }

        body.dark-mode .side-menu {
            background-color: #1f1f1f;
            color: #ffffff; /* Ensures sidebar text is white */
        }

        body.dark-mode .side-menu ul a {
            background-color: #1f1f1f;
            color: #ffffff; /* Ensures sidebar links are white */
        }

        body.dark-mode .side-menu ul a:hover {
            background-color: #333333;
        }

        body.dark-mode .table-container {
            background-color: #1f1f1f;
            color: #ffffff; /* Ensures table text is white */
            border: 1px solid #333333;
        }

        body.dark-mode .table th,
        body.dark-mode .table td {
            color: #ffffff; /* Ensures table header and data text are white */
        }

        body.dark-mode .btn {
            background-color: #ffffff;
            color: #121212; /* Ensures buttons have inverted colors */
        }

        body.dark-mode .search-bar input {
            background-color: #333333;
            color: #ffffff; /* Ensures search bar text is white */
            border: 1px solid #555555;
        }

        body.dark-mode #map {
            background-color: #1f1f1f; /* Ensures map container matches dark theme */
        }
    </style>
</head>

<body>


    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div class="user">
                <button class="toggle-dark-mode" id="darkModeToggle">☀️</button>
                <a href="createLand.php" class="btn">Add New Land</a>
                <a href="allrentedlands.php" class="btn">Lands rented</a>
            </div>
        </div>

        <div class="table-container">
            <h2 class="text-center">Available Lands for Rent</h2>

            <!-- Search Bar -->
            <div class="search-bar mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search for lands by ID...">
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Land ID</th>
                            <th>Owner</th>
                            <th>Number</th>
                            <th>Size (Km²)</th>
                            <th>Price per Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="landTableBody">
                        <?php if (count($lands) > 0): ?>
                            <?php foreach ($lands as $land): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($land['land_id']); ?></td>
                                    <td><?php echo htmlspecialchars($land['owner']); ?></td>
                                    <td><?php echo htmlspecialchars($land['number']); ?></td>
                                    <td><?php echo htmlspecialchars($land['size_km2']); ?></td>
                                    <td><?php echo htmlspecialchars($land['price_per_year']); ?></td>
                                    <td>
                                        <a href="deleteLand.php?id=<?php echo $land['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this land rental record?');">Delete</a> |
                                        <button class="btn btn-primary btn-sm mark-location" 
                                            data-land-id="<?php echo $land['id']; ?>" 
                                            data-latitude="<?php echo $land['latitude']; ?>" 
                                            data-longitude="<?php echo $land['longitude']; ?>">
                                            Mark Location
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No land rental records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Map -->
            <div id="map"></div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize map with default location set to Tunisia
        var map = L.map('map').setView([33.8869, 9.5375], 6); // Tunisia center

        // Load map tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Store references to markers
        var markers = {};

        // Add existing land markers
        const lands = <?php echo json_encode($lands); ?>;
        lands.forEach(land => {
            if (land.latitude && land.longitude) {
                // Add a marker only if it doesn't already exist
                if (!markers[land.land_id]) {
                    const marker = L.marker([land.latitude, land.longitude]).addTo(map);
                    marker.bindPopup(`
                        <strong>Owner: ${land.owner}</strong><br>
                        Number: ${land.number}<br>
                        Size: ${land.size_km2} Km<sup>2</sup><br>
                        Price: ${land.price_per_year}
                    `);

                    // Add a tooltip for each marker
                    marker.bindTooltip(`State: ${land.state}<br>Size: ${land.size_km2} Km<sup>2</sup>`, {
                        permanent: false, // Tooltip appears on hover
                        direction: 'top'  // Position the tooltip above the marker
                    });

                    // Save the marker in the markers object
                    markers[land.land_id] = marker;
                }
            }
        });

        // Handle dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        darkModeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            darkModeToggle.classList.toggle('dark');
        });

        // Handle land search
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function () {
            const filter = searchInput.value.toLowerCase();
            const tableRows = document.querySelectorAll('#landTableBody tr');
            tableRows.forEach(row => {
                const landId = row.cells[0].textContent.toLowerCase();
                row.style.display = landId.includes(filter) ? '' : 'none';
            });
        });

        // Handle marking locations on map
        const markButtons = document.querySelectorAll('.mark-location');
        markButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const landId = event.target.dataset.landId;
                const latitude = parseFloat(event.target.dataset.latitude);
                const longitude = parseFloat(event.target.dataset.longitude);
                const landMarker = L.marker([latitude, longitude]).addTo(map);
                landMarker.bindPopup('Land ID: ' + landId);
            });
        });
    </script>
</body>

</html>
