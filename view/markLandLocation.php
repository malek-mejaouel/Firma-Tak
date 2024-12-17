<?php
require_once '../config/database.php';
require '../controller/LandRentController.php';

$controller = new LandRentController($conn);

// Check if land id is provided
if (isset($_GET['id'])) {
    $land_id = $_GET['id'];
    $land = $controller->getLandById($land_id);
} else {
    echo "No land ID provided!";
    exit;
}

// Handle form submission to save location
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Update land's location
    $controller->updateLandLocation($land_id, $latitude, $longitude);

    // Redirect to the dashboard after updating
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Location for Land ID: <?php echo htmlspecialchars($land['land_id']); ?></title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
            margin-top: 20px;
            border-radius: 8px;
        }
        .form-container {
            margin-top: 20px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Mark Location for Land ID: <?php echo htmlspecialchars($land['land_id']); ?></h2>

    <!-- Map -->
    <div id="map"></div>

    <!-- Location Form -->
    <div class="form-container">
        <form action="markLandLocation.php?id=<?php echo $land_id; ?>" method="POST">
            <input type="hidden" name="latitude" id="latitude" value="<?php echo htmlspecialchars($land['latitude']); ?>">
            <input type="hidden" name="longitude" id="longitude" value="<?php echo htmlspecialchars($land['longitude']); ?>">

            <div>
                <label for="latitude">Latitude:</label>
                <input type="text" id="latitudeField" name="latitude" readonly value="<?php echo htmlspecialchars($land['latitude']); ?>">
            </div>
            <div>
                <label for="longitude">Longitude:</label>
                <input type="text" id="longitudeField" name="longitude" readonly value="<?php echo htmlspecialchars($land['longitude']); ?>">
            </div>

            <button type="submit" class="btn">Save Location</button>
        </form>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    // Initialize the map with the existing location
    var map = L.map('map').setView([<?php echo htmlspecialchars($land['latitude']); ?>, <?php echo htmlspecialchars($land['longitude']); ?>], 13);

    // Set tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Initialize marker at the land's current location
    var marker = L.marker([<?php echo htmlspecialchars($land['latitude']); ?>, <?php echo htmlspecialchars($land['longitude']); ?>]).addTo(map);

    // When the map is clicked, update the marker position and form fields
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lon = e.latlng.lng;

        // Update marker
        marker.setLatLng([lat, lon]);

        // Update hidden input fields with new coordinates
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;
        document.getElementById('latitudeField').value = lat;
        document.getElementById('longitudeField').value = lon;
    });
</script>

</body>
</html>
