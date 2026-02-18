<!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <Style>
       body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        #nav {
            background-color: rgb(143, 179, 167);
        }

        #nav img {
            
             border-radius: 8px;
    width:20%;
    margin-left: 10px;
        }

        .log i {
            color: white;
            font-size: 22px;
        }

        #nav li a {
            color: white;
            font-size: 18px;
            padding: 8px 14px;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        #nav li a:hover,
        #act {
            background-color: rgb(90, 140, 120);
            color: white;
        }

            /* Footer */
        footer {
            background-color: rgb(143, 179, 167);
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto; /* pushes footer to bottom */
        }


        .modal-img {
    width: 200px;          /* fixed width */
    height: 200px;         /* fixed height */
    object-fit: cover;     /* keeps image ratio & crops nicely */
    border-radius: 8px;
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}

.but{
    background-color:#329649;
    color:white;
    border-radius:8px;
    border: 1px solid #329649;
    padding:10px 10px 10px 10px;    
}
</style>
<!-- Navbar -->
<nav id="nav" class="navbar navbar-expand-lg navbar-dark">

    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <img src="ham.jpg" alt="Logo" >
        <label class="log"><i>Hammershop</i></label>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="home.html" >Home</a></li>
            <li class="nav-item"><a class="nav-link" href="productss.php"id="act">Products</a></li>
            <li class="nav-item"><a class="nav-link" href="aboutt.html">About</a></li>
            <li class="nav-item"><a class="nav-link" href="contactt.html">Contact</a></li>
        </ul>
    </div>
</nav>



<?php
include "hmdb.php";

if(isset($_POST['product_id'], $_POST['quantity'])){
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    $result = mysqli_query($conn,"SELECT quantity FROM products WHERE id=$product_id");
    if($result && $row=mysqli_fetch_assoc($result)){
        if($quantity > $row['quantity']){
            echo "<center>Not enough stock! Available: ".$row['quantity']."</center>";
        } else {
           // Correct: only update stock, do not insert
$new_qty = $row['quantity'] - $quantity;
$stmt = $conn->prepare("UPDATE products SET quantity=? WHERE id=?");
$stmt->bind_param("ii",$new_qty,$product_id);
$stmt->execute();
            $stmt2 = $conn->prepare("INSERT INTO orders (product_id, quantity, order_date) VALUES (?, ?, NOW())");
            $stmt2->bind_param("ii",$product_id,$quantity);
            $stmt2->execute();

           echo '
<div style="
    background: #d4edda;
    border: 1px solid #28a745;
    color: #155724;
    font-size: 1.5rem;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    margin: 20px auto;
    width: 50%;
    box-shadow:1px 7px rgba(0,0,0,0.2);
">
✔ Order Successful!<br>
You ordered <strong>' .  $quantity . '</strong> item(s).


</div>
<div style="
    background: #d4edda;
    border: 1px solid #28a745;
    color: #155724;
    font-size: 1.5rem;
    padding: 7px;
    border-radius: 6px;
    text-align: center;
    margin: 10px auto;
    width: 12%;
   
">
<a href="productss.php" style=" ;
    color:#155724;">Shop again</a>
</div>';

        }
    } else echo "<center>Product not found!</center>";
}else echo "<center>No product selected!</center>";
?>




 
<footer>
    <h5>© 2026 Hammershop. All rights reserved.</h5>
</footer>
