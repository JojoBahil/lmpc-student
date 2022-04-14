<?php
session_start();

if(!$_SESSION['awardeenumber']){
   header('location: index.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body>

        <div>
            <nav class="navbar navbar-light navbar-expand-md" id="navigationbar">
                <div class="container-fluid"><a class="navbar-brand" href="forms.php"><img src="image/navigation-logo.png" width="270" height="60" style="margin:-10px;"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                            <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item" role="presentation"><a class="nav-link" href="instructions.php">Instructions</a></li>         
                            <li class="nav-item" role="presentation"><a class="nav-link" href="forms.php">LANDBANK Form</a></li>                        
                            <li class="nav-item" role="presentation"><a class="nav-link" href="contactus.php">Contact Us</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="account_settings.php">Settings</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="other/logout.php">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <script src="assets/js/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
    </body>
</html>

