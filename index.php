<?php
    session_start();
    session_destroy();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TES - Landbank Form</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
        <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body class="indexpage">        
        <div>
            <div class="login-clean">
                
                <form method="post" action="other/functions.php">
                    
                    <h2 class="sr-only">Login Form</h2>
                    <div class="illustration" style="margin-bottom:-5px;"><img></div><br><center>
                    <!-- <span style="font-size:13px; color:#ff0000"><i><b></b>Temporary Closed for scheduled exporting to LANDBANK</i></span><br>
                    <span style="font-size:13px;"><i><b>February 02, 2022</b> - Resume of LMPC Applications</i></span><br><br></center> -->
                    <?php
                        if(isset($_GET['emptylogin'])){
                            echo "<div class='form-row' style='margin-top:-15px;margin-bottom:5px;text-align:center;font-size:13px;'><div class='col'><span style='color:#D8000C;'><i>".$_GET['emptylogin']."</i></span></div></div>";
                        }
                        elseif(isset($_GET['notmatchedlogin'])){
                            echo "<div class='form-row' style='margin-top:-15px;margin-bottom:5px;text-align:left;font-size:13px;'><div class='col'><span style='color:#D8000C;'><i>".$_GET['notmatchedlogin']."</i></span></div></div>";
                        }
                    ?>

                    <div class="form-group"><input class="form-control" type="text" name="awardeenum" placeholder="Award Number" ></div>
                    <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password" ></div>
                    <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name="btn_login" >Log In</button></div>
                    
                </form>
            </div>
            <?php include('footer.php');?>
        </div>
                
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/particles.js"></script>
        <script src="assets/js/particles.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>        
    </body>
</html>
