<?php include "hmdb.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body { min-height: 100vh; display: flex; flex-direction: column; background-color: #f8f9fa; }
        #nav { background-color: rgb(143, 179, 167); }
        #nav img { border-radius: 8px; width:20%; margin-left: 10px; }
        .log i { color: white; font-size: 22px; }
        footer { background-color: rgb(143, 179, 167); color: white; text-align: center; padding: 15px 0; margin-top: auto; }
        
        .status-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            margin-top: 50px;
        }
        .btn-custom { background-color: #329649; color: white; border-radius: 8px; padding: 10px 25px; text-decoration: none; }
        .btn-custom:hover { background-color: #28a745; color: white; }
    </style>
</head>
<body>

<nav id="nav" class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
        <img src="ham.jpg" alt="Logo">
        <label class="log"><i>Hammershop</i></label>
    </a>
</nav>

<div class="container d-flex justify-content-center">
    <div class="col-md-6 status-card">
        <?php
        if(isset($_POST['product_id'], $_POST['quantity'])){
            $product_id = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            $customer_name = $_POST['customer_name'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];
            $payment_method = $_POST['payment_method'];
            
            // Logic for Gcash/Card numbers
            $payment_info = "N/A";
            if($payment_method == "Gcash") {
                $payment_info = $_POST['payment_details_gcash'];
            } elseif($payment_method == "Card") {
                $payment_info = $_POST['payment_details_card'];
            }

            $result = mysqli_query($conn, "SELECT price, name, quantity FROM products WHERE id=$product_id");
            
            if($result && $row = mysqli_fetch_assoc($result)){
                if($quantity > $row['quantity']){
                    echo "<h2 class='text-danger'>Out of Stock!</h2>";
                    echo "<p>Sorry, we only have " . $row['quantity'] . " left.</p>";
                } else {
                    $price = (float)$row['price']; 
                    $total = $price * $quantity;
                    $new_qty = $row['quantity'] - $quantity;

                    // Update Stock
                    $stmt = $conn->prepare("UPDATE products SET quantity=? WHERE id=?");
                    $stmt->bind_param("ii", $new_qty, $product_id);
                    $stmt->execute();

                    // Insert Order
                    $stmt2 = $conn->prepare("INSERT INTO orders (product_id, quantity, price, total, customer_name, customer_email, customer_address, payment_method, payment_info, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                    $stmt2->bind_param("iiddsssss", $product_id, $quantity, $price, $total, $customer_name, $customer_email, $customer_address, $payment_method, $payment_info);

                    if($stmt2->execute()){
                        echo "<h2 class='text-success'>✔ Order Successful!</h2>";
                        echo "<p class='lead'>Thank you, <strong>" . htmlspecialchars($customer_name) . "</strong>!</p>";
                        echo "<p>Your order for " . $quantity . "x " . $row['name'] . " has been placed.</p>";
                        echo "<h4>Total: $" . number_format($total, 2) . "</h4>";
                    } else {
                        echo "<h2 class='text-danger'>Error</h2><p>" . $stmt2->error . "</p>";
                    }
                }
            }
        } else {
            echo "<h2>No data received.</h2>";
        }
        ?>
        <br><br>
        <a href="productss.php" class="btn-custom">Back to Shop</a>
    </div>
</div>

<footer>
    <h5>© 2026 Hammershop. All rights reserved.</h5>
</footer>

</body>
</html>