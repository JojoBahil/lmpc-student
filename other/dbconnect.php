<?php

$dbservername = "92.204.135.165";
$dbusername = "unifastgov_lmpc";

$dbpassword = "teslmpconlineapplication";
$dbname = "unifastgov_ufdb";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if(!$conn){
    die("Cant connect");
}

?>