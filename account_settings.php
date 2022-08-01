<?php
    include('navigation.php');
    include('other/dbconn.php');
    header("Content-Type:text/html; charset=ISO-8859-1"); 
  

    if(!$_SESSION['awardeenumber']){
        header('location: index.php');
    }
    else{
        $GLOBALawardeeNumber = $_SESSION['awardeenumber'];
    }
    

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TES - Landbank Form</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Contact-Form-v2-Modal--Full-with-Google-Map.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="background-image:url('image/background2.webp');">
    <div class="container" style="background-color:rgba(255,255,255,0.9); color:#737373; padding-top:20px;  padding-bottom:20px; border-radius:7px;background-attachment: fixed; background-position: center;">
        <form action = "other/functions.php" method = "POST">  

        <div class="form-row">
                <div class="col">                                
                    <?php
                        if(isset($_GET['errmsg'])){
                            echo "<div class='form-row' style='background-color:#FFD2D2;text-align:center;border-radius:7px;'><div class='col'><span style='color:#D8000C;'>".$_GET['errmsg']."</span></div></div>";
                        }
                        if(isset($_GET['sucmsg'])){
                            echo "<div class='form-row' style='background-color:#DFF2BF;text-align:center;border-radius:7px;'><div class='col'><span style='color:#4F8A10;'>".$_GET['sucmsg']."</span></div></div>";
                        }
                    ?>
                </div>
            </div>
            <h5>Change Password</h5>
            <div class="container" style="width:50%"><br>
                <div class="form-group">
                    <label for="from-name">Type your current password</label><input class="form-control" type="password" name="txt_current_password" value="">
                </div>
                <div class="form-group">
                <label for="from-name">Type your new password <i style='font-size:10px;'>
                    <ul>
                    <li>Have at least 8 characters from A-Z, 0-9, dash and underscore</li>
                    <li>Maximum of 30 characters</li></i>
                    </ul></label><input class="form-control" type="password" name="txt_new_password" value="" pattern="[a-zA-Z0-9\-_]{8,30}" maxlength="30">
                </div>
                <div class="form-group">
                <label for="from-name">Re-type your new password</label><input class="form-control" type="password" name="txt_retype_password" value="" pattern="[a-zA-Z0-9\-_]{8,30}" maxlength="30">
                </div><br><br>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col" style="text-align:center"><button class="btn btn-primary change_password" name="btn_change_password" type="submit" style="width:150px;margin-right:15px;">Change Password</button></div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</body>