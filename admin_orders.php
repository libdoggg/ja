<?php
include "hmdb.php";



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Orders</title>
<link href="bootstrap.min.css" rel="stylesheet">
<style>
    body { background-color: #f8f9fa; }
    table img { width: 60px; height: auto; }
    .table-container { margin: 50px auto; max-width: 1000px; }
    .table th, .table td { vertical-align: middle; text-align: center; }
</style>
</head>
<body>

<div class="container table-container">
<h2 class="text-center mb-4">Admin Dashboard - Orders</h2>

<table class="table table-striped table-bordered shadow-sm bg-white">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>Product Image</th>
    <th>Product Name</th>
    <th>Quantity</th>
    <th>Price per unit</th>
    <th>Total</th>
    <th>Order Date</th>
</tr>
</thead>
<tbody>
<?php
$sql = "
    SELECT 
        o.id AS order_id,
        p.name AS product_name,
        p.img AS product_img,
        o.quantity,
        o.price,
        o.total,
        o.order_date
    FROM orders o
    JOIN products p ON o.product_id = p.id
    ORDER BY o.order_date DESC
";
$result = mysqli_query($conn, $sql);
$counter = 1;

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$counter++."</td>";
    echo "<td><img src='".$row['product_img']."' alt='Product'></td>";
    echo "<td>".$row['product_name']."</td>";
    echo "<td>".$row['quantity']."</td>";
    echo "<td>$".$row['price']."</td>";
    echo "<td>$".$row['total']."</td>";
    echo "<td>".$row['order_date']."</td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>

<script src="bootstrap.bundle.min.js"></script>
</body>
</html>
