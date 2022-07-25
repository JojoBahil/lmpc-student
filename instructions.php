<?php
    session_start();
    
    include('other/dbconn.php');
    header("Content-Type:text/html; charset=ISO-8859-1");

    if(!$_SESSION['awardeenumber']){
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TES - LANDBANK Form</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/Footer-Basic.css">
        <link rel="stylesheet" href="assets/css/instruction.css">
        <link rel="stylesheet" href="assets/css/all.min.css">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body style="background-image:url('image/background2.png');background-attachment: fixed; background-position: center;">
        <?php include('navigation.php'); ?>
        <div>
            <div class="container" style="background-color:rgba(255,255,255,0.9); color:#737373; padding-top:20px;  padding-bottom:20px; border-radius:7px;">
                <div>
                    <div style="background-image:url('image/heading.webp');background-repeat: no-repeat;background-size: 500px 43px;padding:10px;padding-left:40px;color:white;">
                        <h4><b> What is UniFAST LANDBANK Form</b></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">The UniFAST LANDBANK Form is a portal created for you as a TES Grantee. In order to recieve your monthly subsidy, you must be a LANDBANK card holder. This portal's main purpose is to help you accomplish the form required by the bank for card registration without queueing in their branch and save your time.</p>
                        <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">By filling out all the fields from this form, you will be able to export a duly accomplished form except your signature which should be hand written.</p>
                    </div>
                </div><br>
                <div>
                    <div style="background-image:url('image/heading.webp');background-repeat: no-repeat;background-size: 500px 43px;padding:10px;padding-left:40px;color:white;">
                        <h4><b> Instructions</b></h4>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col">
                            <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">Please read the instructions below before filling out the form to avoid mistakes. Note that all fields are required. This section will guide you from filling out the LANDBANK form up to Exporting. </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">Go to the actual form by clicking the "LANDBANK Form" from the upper left side of the navigation menu.</p>
                        </div>
                        <div class="col-lg-4" style="background-color:#97989a;margin-right:10px;padding-bottom:10px;"><label style="color:white;">Click to see example image.</label>
                            <a href="image/gotonavigation.webp" target="_blank">
                                <div class="card" style="background-color:rgba(255,0,0,0.0);border-color:rgba(255,0,0,0.0);"><img class="img-fluid card-img-top w-100 d-block" src="image/gotonavigation.webp"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                <div>
                    <div class="row">
                        <div class="col">
                            <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">The LANDBANK form page will appear. The first section you will see is the selection of where you want to pick up the LANDBANK Mastercard Prepaid Card (LMPC). Put check if you want to pick up the LMPC at your School. Otherwise, if you want to pick up at the nearest or most accessible LANDBANK branch, select your region then the branch list dropdown will generate all the landbank branch within the selected region.</p>
                            <p align = "justify" style="margin:30px; margin-bottom:10px;">Tip: you can click the link below for better details regarding LBP Branches<br><a target="_blank" href='https://www.landbank.com/find-us'>LANDBANK Branch Details</a></p>
                        </div>
                        <div class="col-lg-4" style="background-color:#97989a;margin-right:10px;padding-bottom:10px;"><label style="color:white;">Click to see example image.<br></label>
                            <a href="image/landbankformpage.png" target="_blank">
                                <div class="card"><img class="img-fluid card-img-top card-img-bottom w-100 d-block" src="image/landbankformpage.webp"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                <div>
                    <div class="row">
                        <div class="col">
                        <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">The next section is the Personal Information. In this section you will see a button where you can upload your photo. Click the "Choose File" and select your photo. After you select your photo, another window will appear where you can drag and resize your photo. Please note that your photo is valid only if it is set properly <i>(see example of valid photo below)</i>.</p>
                        <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;"><img class="img-fluid card-img-top w-100 d-block" src="image/samplephoto.webp"></p>
                        <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">Forms with improper photo may not accept by the LANDBANK.</p>
                        <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">Your ID is also necessary for verification purposes. To upload your ID, click the "Choose File" from ID Image (Front) for front side or ID Image (Back) for back side and choose the appropriate photo that shows the whole card with clear image of your photo and signature.</p>
                        <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">You will also see grayed out text fields, those fields are not intended to be editable because it is the data you already provided during the TES Application. Skip those grayed out text field and proceed to the white editable text fields and to the preceeding sections.</p>
                        </div>
                        <div class="col-lg-4 order-2" style="background-color:#97989a;margin-right:10px;"><label style="color:white;">Click to see example image.<br></label>
                            <a href="image/personalinfo.webp" target="_blank">
                                <div class="card" style="margin-bottom:50px;"><img class="img-fluid card-img-top card-img-bottom w-100 d-block" src="image/personalinfo.webp"></div>
                            </a>
                            <a href="image/cropresize.webp" target="_blank">
                                <div class="card" style="margin-bottom:10px;"><img class="img-fluid card-img-top card-img-bottom w-100 d-block" src="image/cropresize.webp"></div>
                            </a>
                            <a href="image/personalinfo2.webp" target="_blank">
                                <div class="card" style="margin-bottom:50px;"><img class="img-fluid card-img-top card-img-bottom w-100 d-block" src="image/personalinfo2.webp"></div>
                            </a>
                            
                            <a href="image/uploadingofid.webp" target="_blank">
                                <div class="card" style="margin-bottom:50px;"><img class="img-fluid card-img-top card-img-bottom w-100 d-block" src="image/uploadingofid.webp"></div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <hr>
                <div>
                    <div class="row">
                        <div class="col">
                            <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">In Emboss section, type the name you want to appear on the card. This field allows up to 22 characters only. Please make sure that your emboss name contains your <b>First Name</b> or <b>Last Name</b>.</p>
                        </div>
                        <div class="col-lg-4" style="background-color:#97989a;margin-right:10px;"><label style="color:white;">Click to see example image.<br></label>
                            <a href="image/emboss.webp" target="_blank">
                                <div class="card"><img class="img-fluid card-img-top card-img-bottom w-100 d-block" src="image/emboss.webp"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <hr>
                <div>
                    <div class="row">
                        <div class="col">
                            <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">Click "Save" button to save your information and "Finalize" button to finish and generate the accomplished form. Note that clicking the Finalize button will also disable the save button and you will not be able to update your information again.</p>
                            <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">Finished. Your accomplished form is already submitted to UniFAST for verification and submission to LANDBANK. If your application is approved, you will receive an email from LANDBANK with activation link. Your School Administrator will be informed once your Prepaid Card is ready to be picked up.</p>
                            <p align = "justify" style="margin:30px; margin-bottom:10px;text-indent:40px;">Your School Administrator will inform you if your application is rejected. The form page will be editable again for you to correct the detail that caused the rejection of your application.</p>
                        </div>
                        <div class="col-lg-4" style="background-color:#97989a;margin-right:10px;padding-bottom:10px;"><label style="color:white;">Click to see example image.<br></label>
                            <a href="image/saveexport.webp" target="_blank">
                                <div class="card"><img class="img-fluid card-img-top card-img-bottom w-100 d-block" src="image/saveexport.webp"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            include('footer.php');
        ?>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/all.min.js"></script>
    </body>
</html>
