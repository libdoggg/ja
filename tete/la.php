<?php 
include "dbb.php";
$sql = "SELECT * FROM country";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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
<body>
    


 
<div id="carouselExample" class="carousel slide">
  <div class="carousel-inner">
    <?php 
    $first = true;
    if($result->num_rows > 0) {
    while($country = $result->fetch_assoc()){
        $activeClass = $first ? 'active' : '';
    ?>

        <div class="carousel-item <?php echo $activeClass; ?>">
            <img src="img/<?php echo $country['country_img'];?>" class="d-block w-100" alt="...">
            
        </div>

        <?php
        $first = false;
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