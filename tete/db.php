<?php
$conn = new mysqli("localhost","root","","dbb");

if ($conn -> connect_error){
    die("connection error". $conn->connect_error);

    }
?>