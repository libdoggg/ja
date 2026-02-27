<?php 
$conn = new mysqli("localhost","root","","dbb");

if($conn -> connect_error){
    die("connection feil". $conn->connect_error);
}
?>