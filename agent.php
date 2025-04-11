<?php 
session_start();
include("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta Tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

    <!-- CSS Links -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/layerslider.css">
    <link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Title -->
    <title>Agents - Real Estate Template</title>
</head>
<body>
    <!-- Include Header -->
    <?php include("include/header.php"); ?>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-4">Our Agents</h1>
                <p>Meet our professional real estate agents.</p>
                <div class="row">
                    <?php
                    $query = mysqli_query($con, "SELECT * FROM user WHERE utype='agent'");
                    while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img class="card-img-top" src="admin/user/<?php echo $row['uimage']; ?>" alt="Agent Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['uname']; ?></h5>
                                <p class="card-text">
                                    <strong>Email:</strong> <?php echo $row['uemail']; ?><br>
                                    <strong>Phone:</strong> <?php echo $row['uphone']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include("include/footer.php"); ?>

    <!-- JavaScript Files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-slider.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/layerslider.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>