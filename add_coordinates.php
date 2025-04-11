<?php
require("config.php");

if(isset($_POST['submit'])) {
    $property_id = $_POST['property_id'];
    $owner_name = $_POST['owner_name'];
    $contact_details = $_POST['contact_details'];
    $coordinates = json_encode($_POST['coordinates']);

    $query = "INSERT INTO property_details (property_id, owner_name, contact_details, coordinates) VALUES ('$property_id', '$owner_name', '$contact_details', '$coordinates')";
    $result = mysqli_query($con, $query);

    if($result) {
        header("Location: add_coordinates.php?success=1");
        exit();
    } else {
        $error = "Failed to add property details!";
    }
}

// Fetch land properties from the database
$query = "SELECT property_id, coordinates FROM property_details";
$result = mysqli_query($con, $query);
$properties = [];
while ($row = mysqli_fetch_assoc($result)) {
    $properties[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management System - Add Coordinates</title>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group button {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        #map {
            width: 100%;
            height: 400px;
            margin-top: 20px;
            cursor: crosshair; /* Set cursor to crosshair for better precision */
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Add Coordinates</h3>
        <?php if(isset($_GET['success'])) { echo "<div style='color: green;'>Property details added successfully!</div>"; } ?>
        <?php if(isset($error)) { echo "<div style='color: red;'>$error</div>"; } ?>
        <div id="map"></div>
        <form method="post" action="">
            <div class="form-group">
                <label>Property ID</label>
                <input type="text" name="property_id" required>
            </div>
            <div class="form-group">
                <label>Owner Name</label>
                <input type="text" name="owner_name" required>
            </div>
            <div class="form-group">
                <label>Contact Details</label>
                <input type="text" name="contact_details" required>
            </div>
            <div id="coordinates-container">
                <!-- <div class="form-group coordinate-group">
                    <label>Latitude 1</label>
                    <input type="text" name="coordinates[0][lat]" required>
                    <label>Longitude 1</label>
                    <input type="text" name="coordinates[0][lng]" required>
                </div>
                <div class="form-group coordinate-group">
                    <label>Latitude 2</label>
                    <input type="text" name="coordinates[1][lat]" required>
                    <label>Longitude 2</label>
                    <input type="text" name="coordinates[1][lng]" required>
                </div>
                <div class="form-group coordinate-group">
                    <label>Latitude 3</label>
                    <input type="text" name="coordinates[2][lat]" required>
                    <label>Longitude 3</label>
                    <input type="text" name="coordinates[2][lng]" required>
                </div>
                <div class="form-group coordinate-group">
                    <label>Latitude 4</label>
                    <input type="text" name="coordinates[3][lat]" required>
                    <label>Longitude 4</label>
                    <input type="text" name="coordinates[3][lng]" required>
                </div> -->
            </div>
            <button type="button" id="add-coordinate">Add More Coordinates</button>
            <button type="submit" name="submit">Submit</button>
        </form>
      
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <!-- Custom JS -->
    <script>
    var map = L.map('map').setView([11.1271, 78.6569], 7); // Default center on Tamil Nadu

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 22, // Set max zoom level to 22
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var markers = [];
    var latlngs = [];

    map.on('click', function(e) {
        var marker = L.marker(e.latlng).addTo(map);
        markers.push(marker);
        latlngs.push(e.latlng);

        // Add coordinate input fields dynamically
        var coordinateGroup = document.createElement('div');
        coordinateGroup.className = 'form-group coordinate-group';
        coordinateGroup.innerHTML = `
            <label>Latitude ${markers.length}</label>
            <input type="text" name="coordinates[${markers.length - 1}][lat]" value="${e.latlng.lat}" required>
            <label>Longitude ${markers.length}</label>
            <input type="text" name="coordinates[${markers.length - 1}][lng]" value="${e.latlng.lng}" required>
        `;
        document.getElementById('coordinates-container').appendChild(coordinateGroup);

        // Draw a line connecting the last two points
        if (latlngs.length > 1) {
            var lastTwoPoints = [latlngs[latlngs.length - 2], latlngs[latlngs.length - 1]];
            var line = L.polyline(lastTwoPoints, { color: 'blue' }).addTo(map);
        }
    });

    document.getElementById('add-coordinate').addEventListener('click', function() {
        var coordinateGroup = document.createElement('div');
        coordinateGroup.className = 'form-group coordinate-group';
        var index = document.querySelectorAll('.coordinate-group').length;
        coordinateGroup.innerHTML = `
            <label>Latitude ${index + 1}</label>
            <input type="text" name="coordinates[${index}][lat]" required>
            <label>Longitude ${index + 1}</label>
            <input type="text" name="coordinates[${index}][lng]" required>
        `;
        document.getElementById('coordinates-container').appendChild(coordinateGroup);
    });
</script>
</body>
</html>