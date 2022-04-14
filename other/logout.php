<?php
    session_start();
    session_destroy();
    unset($_SESSION['awardeenumber']);
    header('location: ../index.php');

?>