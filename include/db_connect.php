<?php 

$conn = new mysqli("127.0.0.1:3390","root", "","roi");

if($conn->connect_error){
    die("Lidhja deshtoi".$conn->connect_error);
}

?>