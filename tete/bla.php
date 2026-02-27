<?php 
include "db.php";
$sql = "SELECT * FROM country" ;
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Country Carousel</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        #carouselExample {
            width: 70%; /* Adjusted for better visibility */
            margin: 50px auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
             border-radius:8px;
        }
        .carousel-item img {
            height: 450px;
            object-fit: contain;
            margin:10px 0px 10px 0px;
        }

        .carousel-control-prev-icon {
            background-color:black;
            border-radius:8px;
        }

        .carousel-control-next-icon{
            background-color:black;
             border-radius:8px;
        }
    </style>
    <link rel="Stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $first = true;
        if($result->num_rows > 0) {
            while($country = $result->fetch_assoc()) {
                // Determine if this is the active slide
                $activeClass = $first ? 'active' : '';
                ?>

                <div class="carousel-item <?php echo $activeClass; ?>">
                <img src="img/<?php echo $country['country_img']; ?>" class="d-block w-100">
                    
                    <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.3); border-radius: 10px;">
                        <h5><?php echo $country['country_name']; ?></h5>
                        <label><?php echo $country['capital'];?></label>
                    </div>

                </div>

                <?php
                $first = false; // Turn off 'active' for all following items
                     }
                 }
             ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>