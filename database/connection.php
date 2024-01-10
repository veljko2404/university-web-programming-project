<?php

$host = "localhost";
$username = "root";
$pass = "";
$db_name = "car_dealership";

$conn = new mysqli($host,$username,$pass,$db_name);
if($conn->connect_error){
    die("greska: ".$conn->connect_error);
}

?>