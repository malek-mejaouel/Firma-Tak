<?php
require_once '../config/database.php';
require '../controller/LandRentController.php';

// Get the specific land ID from the query string
$highlightLandId = isset($_GET['land_id']) ? $_GET['land_id'] : null;

// Instantiate the controller
$controller = new LandRentController($conn);
$lands = $controller->listLands();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Page</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        #map {
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([33.8869, 9.5375], 6); // Centered on Tunisia

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Load land data
        const lands = <?php echo json_encode($lands); ?>;
        const highlightLandId = "<?php echo $highlightLandId; ?>";

        // Find the land that matches the land_id from the URL
        const landToHighlight = lands.find(land => land.land_id == highlightLandId);

        if (landToHighlight && landToHighlight.latitude && landToHighlight.longitude) {
            // Create the default marker (no custom image)
            const markerIcon = L.icon({
                iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png', // Default marker icon
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
                iconSize: [25, 41], // Default size
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            // Create the marker for the specific land
            const marker = L.marker([landToHighlight.latitude, landToHighlight.longitude], { icon: markerIcon }).addTo(map);

            // Bind popup with land details
            marker.bindPopup(`
                <strong>Owner:</strong> ${landToHighlight.owner}<br>
                <strong>Number:</strong> ${landToHighlight.number}<br>
                <strong>Size:</strong> ${landToHighlight.size_km2} Km<sup>2</sup><br>
                <strong>Price:</strong> ${landToHighlight.price_per_year}<br>
            `);

            // Optionally, zoom in to the marker
            map.setView([landToHighlight.latitude, landToHighlight.longitude], 12); // Zoom level 12 (adjust as needed)
        } else {
            console.log("Land with specified land_id not found.");
        }
    </script>
</body>
</html>
