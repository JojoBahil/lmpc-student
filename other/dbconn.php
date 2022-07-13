<?php

$dbservername = "localhost";
$dbusername = "unifastgov_lmpc";

$dbpassword = "7_d[MJB(#l8A";
$dbname = "unifastgov_ufdb";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if(!$conn){
    die("Cant connect");
}

?>