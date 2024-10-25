<?php

$userName = "root";
$password = "";
$servername = "localhost";
$dbName = "questteach";


$conn = mysqli_connect($servername, $userName, $password, $dbName);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



?>
