<?php 
$conn = new mysqli("localhost","root", "","hamshop");

if(!$conn){
    die("Conneciton failed:". mysqli_Connect_error());
}
?>