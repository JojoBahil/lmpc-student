<?php

$dbservername = "localhost";
$dbusername = "root";

$dbpassword = "20unifast19TES";
$dbname = "unifastg_ufdb";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if(!$conn){
    die("Cant connect");
}

?>