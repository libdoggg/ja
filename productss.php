<?php include "hmdb.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products</title>
<link rel="stylesheet" href="bootstrap.min.css">
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
</head>
<body>
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

<div class="row justify-content-center">
<?php
// Only select products with stock > 0
$sql = "SELECT * FROM products WHERE quantity > 0";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>
    <div class="card" style="width: 18rem; margin: 8px;">
        <img src="<?php echo $row['img']; ?>" class="card-img-top">
        <div class="card-body">
            <h5 class="card-title"><?php echo $row['name']; ?></h5>
            <p class="card-text"><?php echo $row['desc']; ?></p>
            <p>Price: $<?php echo $row['price']; ?></p>
            <p>Stock: <?php echo $row['quantity']; ?></p>
            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#buyModal<?php echo $row['id']; ?>">
                Buy
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="buyModal<?php echo $row['id']; ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="buy.php" onsubmit="setQty(<?php echo $row['id']; ?>)">
        <div class="modal-header">
          <h5 class="modal-title">Checkout: <?php echo $row['name']; ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="text-center mb-3">
            <img src="<?php echo $row['img']; ?>" class="modal-img mb-2">
            <h6>Unit Price: $<?php echo number_format($row['price'], 2); ?></h6>
            <h5 class="text-success">Total: $<span id="total<?php echo $row['id']; ?>"><?php echo number_format($row['price'], 2); ?></span></h5>
          </div>

          <hr>

          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="customer_name" class="form-control" placeholder="John Doe" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="customer_email" class="form-control" placeholder="john@example.com" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Delivery Address</label>
            <textarea name="customer_address" class="form-control" rows="2" placeholder="Street, City, Zip Code" required></textarea>
          </div>

          <div class="mb-3">
    <label class="form-label">Payment Method</label>
    <select name="payment_method" id="paymentMethod<?php echo $row['id']; ?>" class="form-control" onchange="togglePaymentFields(<?php echo $row['id']; ?>)" required>
        <option value="" disabled selected>Select Payment</option>
        <option value="COD">Cash on Delivery</option>
        <option value="Gcash">Gcash</option>
        <option value="Card">Credit/Debit Card</option>
    </select>
</div>

<div id="gcashField<?php echo $row['id']; ?>" class="mb-3" style="display: none;">
    <label class="form-label">Gcash Number</label>
    <input type="text" name="payment_details_gcash" class="form-control" placeholder="0912 345 6789">
</div>

<div id="cardField<?php echo $row['id']; ?>" class="mb-3" style="display: none;">
    <label class="form-label">Card Number</label>
    <input type="text" name="payment_details_card" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX">
</div>

          <hr>

          <div class="d-flex justify-content-between align-items-center">
            <span>Quantity:</span>
            <div class="d-flex align-items-center gap-2">
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decreaseQty(<?php echo $row['id']; ?>, <?php echo (float)$row['price']; ?>)">−</button>
              <input type="number" id="qty<?php echo $row['id']; ?>" value="1" min="1" max="<?php echo $row['quantity']; ?>" class="form-control text-center" style="width:70px;" readonly>
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="increaseQty(<?php echo $row['id']; ?>, <?php echo $row['quantity']; ?>, <?php echo (float)$row['price']; ?>)">+</button>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
          <input type="hidden" name="quantity" id="hiddenQty<?php echo $row['id']; ?>" value="1">
          <button type="submit" class="but w-100">Confirm Order</button>
        </div>
      </form>
    </div>
  </div>
</div>
    
<?php } ?>
</div>

<!-- Footer -->
<footer>
    <h5>© 2026 Hammershop. All rights reserved.</h5>
</footer>

<!-- Bootstrap JS -->



<script src="bootstrap.bundle.min.js"></script>
<script>
function updateTotal(id, price) {
    let qty = parseInt(document.getElementById('qty' + id).value);
    price = parseFloat(price);

    if (isNaN(qty) || isNaN(price)) {
        return;
    }

    let total = qty * price;
    document.getElementById('total' + id).innerText = total.toFixed(2);
}


function increaseQty(id, max, price) {
    let qty = document.getElementById('qty' + id);
    if (parseInt(qty.value) < max) {
        qty.value = parseInt(qty.value) + 1;
        updateTotal(id, price);
    }
}

function decreaseQty(id, price) {
    let qty = document.getElementById('qty' + id);
    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
        updateTotal(id, price);
    }
}

function setQty(id) {
    document.getElementById('hiddenQty' + id).value =
        document.getElementById('qty' + id).value;
}

function togglePaymentFields(id) {
    let selection = document.getElementById('paymentMethod' + id).value;
    let gcashDiv = document.getElementById('gcashField' + id);
    let cardDiv = document.getElementById('cardField' + id);

    // Reset visibility
    gcashDiv.style.display = 'none';
    cardDiv.style.display = 'none';

    // Show specific field based on selection
    if (selection === 'Gcash') {
        gcashDiv.style.display = 'block';
    } else if (selection === 'Card') {
        cardDiv.style.display = 'block';
    }
}
</script>

</body>
</html>