<?php

$conn = new mysqli("localhost", "root","","quis");
if($conn->connect_error){
    die("conectionf ailed". $conn->connect_error);
    }

?>
