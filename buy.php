<!-- Bootstrap CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="stail.css">
<!-- Navbar -->
<nav id="nav" class="navbar navbar-expand-lg px-3">
    <a class="navbar-brand" href="#">
       <img src="ham.jpg" alt="Logo" width="40"> <label class="log"><i>Hammershop</i></label>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="home.html" >Home</a></li>
            <li class="nav-item"><a class="nav-link" href="productss.php">Products</a></li>
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
You ordered <strong>' . $quantity . '</strong> item(s).


</div>
<div style="
    background: #d4edda;
    border: 1px solid #28a745;
    color: #155724;
    font-size: 1.5rem;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
    margin: 10px auto;
    width: 20%;
   
">
<a href="productss.php" style=" ;
    color:#155724;">Shop again</a>
</div>';

        }
    } else echo "<center>Product not found!</center>";
}else echo "<center>No product selected!</center>";
?>




 
<footer class="text-center py-3 text-white">
  <p>footer</p>
</footer>