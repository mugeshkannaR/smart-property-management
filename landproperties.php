<?php
require("config.php");

// Fetch land properties from the database
$query = "SELECT property_id, owner_name, contact_details, coordinates FROM property_details";
$result = mysqli_query($con, $query);
$properties = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['coordinates'] = json_decode($row['coordinates'], true);
    $properties[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management System - Geospatial</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        #map {
            width: 100%;
            height: 600px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center">Land Properties</h3>
        <div class="form-group">
            <label for="propertySearch">Search Property</label>
            <select id="propertySearch" class="form-control">
                <option value="">Select a property</option>
                <?php foreach ($properties as $property) { ?>
                    <option value="<?php echo htmlspecialchars(json_encode($property['coordinates'])); ?>"><?php echo $property['property_id']; ?></option>
                <?php } ?>
            </select>
            <button id="searchButton" class="btn btn-primary mt-2">Search</button>
        </div>
        <div id="map"></div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <!-- Custom JS -->
    <script>
        var properties = <?php echo json_encode($properties); ?>;
        var map = L.map('map').setView([11.1271, 78.6569], 7); // Default center on Tamil Nadu

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 22, // Set max zoom level to 22
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        properties.forEach(function(property) {
            var latlngs = property.coordinates.map(function(coord) {
                return [coord.lat, coord.lng];
            });
            var polygon = L.polygon(latlngs, { color: 'blue' }).addTo(map);
            polygon.bindPopup("<b>Property ID: " + property.property_id + "</b><br>Owner: " + property.owner_name + "<br>Contact: " + property.contact_details);
        });

        document.getElementById('searchButton').addEventListener('click', function() {
            var selectedValue = document.getElementById('propertySearch').value;
            if (selectedValue) {
                var coordinates = JSON.parse(selectedValue);
                var lat = parseFloat(coordinates[0].lat);
                var lng = parseFloat(coordinates[0].lng);
                map.setView([lat, lng], 18); // Zoom level set to 18 for closer view
            }
        });
    </script>
</body>
</html>