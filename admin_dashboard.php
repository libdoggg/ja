<?php
include "hmdb.php";

// Initialize messages
$success = $error = '';

// Handle Add Product
if (isset($_POST['name'], $_POST['desc'], $_POST['price'], $_FILES['img'], $_POST['quantity'])) {
    $name = trim($_POST['name']);
    $desc = trim($_POST['desc']);
    $price = (float)$_POST['price'];
    $quantity = (int)$_POST['quantity'];

    // Check if product with same name exists
    $check = $conn->prepare("SELECT id FROM products WHERE name=?");
    $check->bind_param("s", $name);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        $error = "Product with this name already exists!";
    } else {
        // Handle image upload
        if ($_FILES['img']['error'] == 0) {
            $img_name = time() . '_' . $_FILES['img']['name'];
            $img_tmp  = $_FILES['img']['tmp_name'];
            $upload_dir = 'images/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            move_uploaded_file($img_tmp, $upload_dir.$img_name);
            $img_path = $upload_dir.$img_name;
        } else {
            $img_path = '';
        }

        $stmt = $conn->prepare("INSERT INTO products (name, `desc`, price, img, quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $name, $desc, $price, $img_path, $quantity);

        if ($stmt->execute()) $success = "Product added successfully!";
        else $error = "Error: " . $conn->error;
    }
    $check->close();
}

// Handle Delete Product
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];

    // Delete image file if exists
    $img_result = mysqli_query($conn, "SELECT img FROM products WHERE id=$delete_id");
    if ($img_result && $img_row = mysqli_fetch_assoc($img_result)) {
        if (file_exists($img_row['img'])) unlink($img_row['img']);
    }

    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link href="bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.container { max-width: 1000px; margin: 50px auto; }
.table img { width: 60px; }
.table th, .table td { vertical-align: middle; text-align: center; }
.form-container { background: #fff; padding: 30px; border-radius: 10px; margin-bottom: 50px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
.alert { text-align: center; font-weight: bold; }
</style>
</head>
<body>
<div class="container">
<h2 class="text-center mb-4">Admin Dashboard</h2>

<!-- Add Product Form -->
<div class="form-container">
<h4>Add New Product</h4>
<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" class="form-control mb-2" placeholder="Product Name" required>
    <textarea name="desc" class="form-control mb-2" placeholder="Description" required></textarea>
    <input type="number" name="price" class="form-control mb-2" placeholder="Price ($)" step="0.01" required>
    <input type="number" name="quantity" class="form-control mb-2" placeholder="Quantity" min="0" value="1" required>
    <input type="file" name="img" class="form-control mb-2" required>
    <button type="submit" class="btn btn-primary w-100">Add Product</button>
</form>
</div>

<!-- Products Table -->
<h4>All Products</h4>
<table class="table table-striped table-bordered shadow-sm bg-white">
<thead class="table-dark">
<tr>
<th>#</th>
<th>Image</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
<th>Quantity</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
$counter = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$counter++."</td>";
    echo "<td><img src='".$row['img']."' alt='Product'></td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['desc']."</td>";
    echo "<td>$".$row['price']."</td>";
    echo "<td>".$row['quantity']."</td>";
    echo "<td>
            <a href='admin_dashboard.php?delete_id=".$row['id']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Delete this product?\")'>Delete</a>
          </td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>

<script src="bootstrap.bundle.min.js"></script>
</body>
</html>
