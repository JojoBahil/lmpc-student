<?php

$dbservername = "localhost";
$dbusername = "unifastgov_ufdb";

$dbpassword = "dJTBrFKM4aazRszR";
$dbname = "unifastgov_ufdb";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if(!$conn){
    die("Cant connect");
}

?>