<?php
$conn = new mysqli("localhost", "root", "" , "ddb");
    if($conn -> connect_error){
        die("connection failed". $conn->connect_error);
    }
?>