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
    
    $sql = "SELECT fname, mname, lname, email FROM vw_complete_teslbp_data WHERE award_no = '$GLOBALawardeeNumber'";
    $results = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($results);

    if($resultCheck > 0){
        $row=mysqli_fetch_array($results);
        $fname  = mysqli_real_escape_string($conn, $row['fname']);
        $mname  = mysqli_real_escape_string($conn, $row['mname']);
        $lname  = mysqli_real_escape_string($conn, $row['lname']);
        $email  = mysqli_real_escape_string($conn, $row['email']);
        $fullname = $fname." ".$mname." ".$lname;
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
    <div>
        <div class="container" style="background-color:rgba(255,255,255,0.9); color:#737373; padding-top:20px;  padding-bottom:20px; border-radius:7px;background-attachment: fixed; background-position: center;">
    <div style="background-image:url('image/heading.png');background-repeat: no-repeat;background-size: 500px 43px;padding:10px;padding-left:40px;color:white;">
        <h4><b>Contact Information</b></h4> 
    </div>
            <hr>
            <!--<form action = 'https://formspree.io/jbahil47@gmail.com' method = 'POST' id = 'contactForm' -->
            <form action="other/functions.php" method="POST" id="contactForm">
                <div class="form-row">
                    <div class="col-md-6">
                        <div id="successfail"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12 col-md-6" id="message">
                        <h5 class="h4"><i class="fa fa-envelope"></i> Contact Us<small></small></h5>
                        <div class="form-group"><label for="from-name">Name</label><input class="form-control" type="text" name="txt_name" readonly="" value="<?php echo $fullname; ?>"></div>
                        <div class="form-group"><label for="from-name">Email Address</label><input class="form-control" type="email" name="txt_email" readonly="" value="<?php echo $email; ?>"></div>
                        <div class="form-group"><label for="from-name">Subject</label><input class="form-control" type="text" name="txt_subject" readonly="" value="Filling Landbank Form"></div>
                        <div class="form-group"><label for="from-comments">Message</label><textarea class="form-control" rows="8" name="txt_message" readonly="" placeholder="Enter Message" id="from-comments">(This feature is not yet available)</textarea></div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col"><button class="btn btn-primary btn-block" type="submit" name="btn_send" disabled = "false">Send</button></div>
                            </div>
                        </div>
                        <hr class="d-flex d-md-none">
                    </div>
                    <div class="col-12 col-md-6">
                        <h2 class="h4"><i class="fa fa-map-marker"></i> Locate Us</h2>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="static-map"><iframe allowfullscreen frameborder="0" width="100%" height="400" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAoqJL1IqDboHKrUIec-KmyUrPq7yiJ1s8&amp;q=UP+Ayala+Land+Technohub+Building+E%2C+Don+Mariano+Marcos+Avenue%2C+Diliman%2C+Quezon+City%2C+Metro+Manila&amp;zoom=15"></iframe></div>
                            </div>
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <h2 class="h4"><i class="fa fa-user"></i> Our Info</h2>
                                <div><span><strong>UniFAST</strong></span></div>
                                <div><span><i class="fa fa-facebook-official"></i>&nbsp;facebook.com/unifastofficial</span></div>
                                <div><span><i class="icon ion-email"></i>&nbsp;tes.unifast@ched.gov.ph</span></div>
                                <!-- <div><span><i class="icon ion-ios-telephone"></i>&nbsp;922-9630</span></div> -->
                                <hr class="d-sm-none d-md-block d-lg-none">
                            </div>
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <h2 class="h4"><i class="fa fa-location-arrow"></i> Our Address</h2>
                                <div><span><strong>UniFAST Secretariat</strong><br></span></div>
                                <div><span>Ground Floor, IBM Building E, UP Ayala Land, Technohub Complex, Commonwealth, Diliman, Quezon City</span></div>
                                <div></div>
                                <div></div>
                                <hr class="d-sm-none">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php
        include('footer.php');
    ?>
    </div>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>